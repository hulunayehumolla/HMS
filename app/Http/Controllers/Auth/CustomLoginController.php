<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
class CustomLoginController extends Controller
{
    /**
     * Show the custom login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('welcome'); // Create a custom login view
    } 
    public function showregisterForm()
    {
        return view('auth.register'); // Create a custom login view
    }
    /**
     * Handle login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

/*
 public function login(Request $request) {
    // Validate login data
    $this->validateLogin($request);
    // Attempt to log the user in with the given credentials
    if (Auth::attempt(['username' => $request->userName, 'password' => $request->passWord])) {
        // Check if the authenticated user is active
         $user = Auth::user(); // Retrieve the authenticated user
        if ($user->status == 1) { // Check the status column
            return response()->json(['success' => true]);
        } else {
              Auth::logout();  // Logout the user if inactive
             $request->session()->invalidate();
          // Regenerate the session token to prevent session fixation attacks
             $request->session()->regenerateToken();
            return response()->json(['success' => false, 'message' => "Your account is inactive."]);
        }
    }

    // If the login attempt fails, return an error message in JSON
    return response()->json(['success' => false, 'message' => "Incorrect credentials!"]);
}*/

public function login(Request $request) {
    // Validate login credentials
    $request->validate([
        'userName' => 'required|string',
        'passWord' => 'required|string',
    ]);
    // Check if user exists
    $user = User::where('username', $request->userName)->first();
    // If user does not exist
    if (!$user) {
        return redirect()->back()->withErrors(['message' => 'Login Failed. Please remember that passwords are case sensitive.']);
     }
    // Lock the user if failed attempts exceed 5
    if ($user->failed_attempts >= 5) {
        return redirect()->back()->withErrors(['message' => 'Your account is locked due to too many failed login attempts.']);
      }
    // Attempt login with 'remember me' functionality
     $remember = $request->has('remember');
    if (Auth::attempt(['username' => $request->userName, 'password' => $request->passWord], $remember)) {
        // Reset failed login attempts on successful login
        $user->failed_attempts = 0;
        $user->save();
        // Check if user is active
        if ($user->status == 1) {
             return redirect()->route('dashboard'); // Redirect to home or dashboard
         } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['message' => 'Your account is inactive.']);
        }
     } else {
        // Increment failed login attempts
        $user->failed_attempts += 1;
        $user->save();
        // Calculate remaining attempts before account is locked
         $remainingAttempts = 5 - $user->failed_attempts;
        if ($remainingAttempts > 0) {
            // If there are remaining attempts, show how many attempts left
            if($remainingAttempts==1){
                 return redirect()->back()->withErrors(['message' => "Login Fail ! You have: '".$remainingAttempts."' attempt(s) left.  It is better to reset your password befor Account Locked"]);
                }
            return redirect()->back()->withErrors(['message' => "Incorrect credentials! You have: '".$remainingAttempts."' attempt(s) left."]);
        } else {
            // Lock the account after 5 failed attempts
               $user->status = 0;
               $user->save();
            return redirect()->back()->withErrors(['message' => 'Your account is locked due to too many failed login attempts.']);
        }
    }
}







    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'userName' => 'required|string',
            'passWord' => 'required|string',
        ]);
    }

    /**
     * Handle logout request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
  public function logout(Request $request)
{
    Auth::logout();
    // Invalidate the session (optional but recommended)
    $request->session()->invalidate();
    // Regenerate the session token to prevent session fixation attacks
    $request->session()->regenerateToken();
    // Redirect to login page after logout
    //return redirect()->route('login');
     return redirect('/');
}

}
