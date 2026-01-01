<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\PasswordResetCodeMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\User;
use App\Models\PasswordResetCode;
class ForgotPasswordController extends Controller {

public function sendResetCode(Request $request) {
    $request->validate(['email' => 'required|email']);

    // Check if email exists in the employees table
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Your email does not exists in the system']);
    }


    if ($user->failed_attempts>=5 || $user->status==0) {
        return back()->withErrors(['email' => 'Your account is locked and you can not reset your password.Pleae contact system Admin. ']);
     }

      
        $userSentCode = PasswordResetCode::where('email', $request->email)->first();
         if($userSentCode && $userSentCode->no_changes>=3){
            $user->status=0;
            $user->save();

             return back()->withErrors(['email' => 'You have reached maximum passsword reset limit. Pleae contact system Admin. ']);
           }
          // Generate a 6-digit code
          $code = random_int(100000, 999999);

       // Send the code via email
        try {
            if ($userSentCode) {
                $userSentCode->code = $code;
                $userSentCode->created_at = now();
                $userSentCode->save();
             } else {
                PasswordResetCode::create(['code' => $code, 'created_at' => now(),'email' => $request->email ]);
                 }

            $employee = Employee::where('emp_Id', $user->username)->first();
            // Send the reset code email
            Mail::to($request->email)->send(new PasswordResetCodeMail($employee, $code));
        } catch (\Exception $e) {
            // Handle exceptions and return an error message
            return back()->withErrors(['email' => 'Failed to send the reset code. Please try again later.']);
        }


    // Store email in the session and redirect to verify page
    session(['password_reset_email' => $request->email]);

    return redirect()->route('password.verifyPage')->with('status', 'Password reset code has been sent to your email.');
}




public function verifyResetCode(Request $request)
{
    $request->validate([
        'code' => 'required|string',
        'password' => 'required|min:6|confirmed',
    ]);

    // Retrieve email from the session
    $email = session('password_reset_email');

    if (!$email) {
        return response()->json([
            'status' => 'error',
            'message' => 'Session expired. Please request a new reset code.'
        ], 400);
    }

    // Find the reset code
    $reset = PasswordResetCode::where('email', $email)
                            ->where('code', $request->code)
                            ->where('created_at', '>=', now()->subMinutes(5)) ->first();

    if (!$reset) {
        return response()->json(['status' => 'error', 'message' => 'Invalid or expired reset code.'], 400);
        }

    // Update the user password
   $user= User::where('email', $email)->update(['password' => Hash::make($request->password), ]);

    // update PasswordResetCode for no of chnages the reset code
    $ResetCode=PasswordResetCode::where('email', $email)->first();

    if($ResetCode->no_changes==0){
       $noChanges=1;
      }
      else{
        $noChanges=$ResetCode->no_changes+1;
      }

    $ResetCode->code="";
    $ResetCode->no_changes=$noChanges;
    $ResetCode->save();

    // Clear the session
    session()->forget('password_reset_email');

    // Return success response
    return response()->json([
        'status' => 'success',
        'message' => 'Password reset successfully. Redirecting to login...',
        'redirect_url' => route('login')  // Include the URL for the login page to redirect after success
    ]);

}



public function deleteResetCode(Request $request)
{
    $email = $request->email;

    // Delete the reset code from the database
    DB::table('password_reset_codes')->where('email', $email)->update(['code'=>""]);

    // Set a session message to notify the user about the reset code expiration
    session()->flash('status', 'The reset code has expired. Please request a new one.');

    return response()->json(['success' => true]);
}




}
