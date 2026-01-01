<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeederController;
use App\Http\Controllers\RoomController;

use App\Http\Controllers\NewsController;

use Illuminate\Support\Facades\Route;

use Andegna\AgeCalculator\AgeCalculator;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('myLang', [LanguageController::class, 'langSwithch'])->name('lang.change');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//special one
/*Route::get('/logout', function (Request $request) {
     Auth::guard('web')->logout();
    return redirect('/');
})->name('logout.get');
*/

// Welcome page (for guests)
Route::middleware(['redirectIfAuthenticated'])->group(function () {
    Route::get('/', [WelcomeController::class,'welcome'])->name('welcome');

    // Add login page route here (if required)
    Route::get('/login', function () {
       return view('auth.login');
    })->name('loginpage');
});



Route::post('login', [CustomLoginController::class, 'login'])->name('login');
Route::post('logout', [CustomLoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

        Route::resources([
            'roles' => RoleController::class,
            'users' => UserController::class,
          ]);
    /*
    |--- Language Translation Route--
    */
  Route::get('myLang', [LanguageController::class, 'langSwithch'])->name('lang.change');
   Route::post('/run-permission-seeder', [SeederController::class, 'runPermissionSeeder'])->name('seed.permissions'); 
 
    /*
    |---End of Language Translation Route--
  */

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/getuserDepartment', [UserController::class, 'getUserDepartment'])->name('users.getdepartment');
    Route::get('users/list', [UserController::class, 'getUserList'])->name('users.getList');
    Route::get('Student-User-List', [UserController::class, 'viewStudetUser'])->name('student.user.getlist');

    Route::get('users/{user}/password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
    Route::post('users/{user}/status', [UserController::class, 'updateUserStatus'])->name('users.updateUserStatus');



/*
|--------------------------------------------------------------------------
| Rooms CRUD Routes
|--------------------------------------------------------------------------
*/
// Rooms CRUD
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::post('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
Route::delete('/rooms/{room}/photo/{index}', [RoomController::class, 'deletePhoto'])->name('rooms.deletePhoto');


    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');



 /*For Blogs*/
 // Announcement Routes
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::post('/news/{news}/update', [NewsController::class, 'update'])->name('news.update');
    Route::post('/news/{news}/delete', [NewsController::class, 'destroy'])->name('news.destroy');

   


    Route::get('forgot-password', function () {return view('auth.forgotPassword');})->name('password.request');
   Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.sendCode');
    Route::get('verify-code', function () {return view('auth.verify'); })->name('password.verifyPage');
   Route::post('verify-code', [ForgotPasswordController::class, 'verifyResetCode'])->name('password.verifyCode');

Route::post('/password/delete-code', [ForgotPasswordController::class, 'deleteResetCode'])->name('password.deleteCode');


});


 Route::get('/news/view', [NewsController::class, 'viewNews'])->name('news.view.users');// for users
 Route::get('/news-page', [NewsController::class, 'viewNewsForPublic'])->name('news.view.public');// for public 
 Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');


    Route::get('/checkforNewNews', [NewsController::class, 'checkNewNews'])->name('news.check.new.news');// for users
    Route::get('/news/{news}/details', [NewsController::class, 'show'])->name('news.show.details'); // not yet



/*require __DIR__.'/auth.php';*/


// Forgot Password routes

