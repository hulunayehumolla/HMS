<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeederController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\RoomReservationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use Andegna\AgeCalculator\AgeCalculator;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;

Route::get('myLang', [LanguageController::class, 'langSwithch'])->name('lang.change');
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/welcome/{food}/edit', [WelcomeController::class, 'edit'])->name('welcome.edit');
Route::put('/welcome/{food}', [WelcomeController::class, 'update'])->name('welcome.update');




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

/*Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::resources(['roles' => RoleController::class, 'users' => UserController::class,]);
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

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

// ... other routes (dashboard, welcome, etc.)


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


 Route::get('/news/view', [NewsController::class, 'viewNews'])->name('news.view.users');// for users
 Route::get('/news-page', [NewsController::class, 'viewNewsForPublic'])->name('news.view.public');// for public 
 Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
 Route::get('/checkforNewNews', [NewsController::class, 'checkNewNews'])->name('news.check.new.news');// for users
 Route::get('/news/{news}/details', [NewsController::class, 'show'])->name('news.show.details'); // not yet

                // staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');



                // Doctor
    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.index');
    Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::delete('/doctor/{staff}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::get('/doctor/{staff}/edit', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/doctor/{staff}', [DoctorController::class, 'update'])->name('doctor.update');

                    // Nurse
    Route::get('/nurse', [NurseController::class, 'index'])->name('nurse.index');
    Route::post('/nurse', [NurseController::class, 'store'])->name('nurse.store');
    Route::delete('/nurse/{staff}', [NurseController::class, 'destroy'])->name('nurse.destroy');
    Route::get('/nurse/{staff}/edit', [NurseController::class, 'edit'])->name('nurse.edit');
    Route::put('/nurse/{staff}', [NurseController::class, 'update'])->name('nurse.update');

                       // Pharmacist
    Route::get('/pharmacist', [PharmacistController::class, 'index'])->name('pharmacist.index');
    Route::post('/pharmacist', [PharmacistController::class, 'store'])->name('pharmacist.store');
    Route::delete('/pharmacist/{staff}', [PharmacistController::class, 'destroy'])->name('Pharmacist.destroy');
    Route::get('/Pharmacist/{staff}/edit', [PharmacistController::class, 'edit'])->name('Pharmacist.edit');
    Route::put('/Pharmacist/{staff}', [PharmacistController::class, 'update'])->name('Pharmacist.update');                       // Laboratory
    Route::get('/laboratory', [LaboratoryController::class, 'index'])->name('laboratory.index');
    Route::post('/laboratory', [LaboratoryController::class, 'store'])->name('laboratory.store');
    Route::delete('/laboratory/{staff}', [LaboratoryController::class, 'destroy'])->name('laboratory.destroy');
    Route::get('/laboratory/{staff}/edit', [LaboratoryController::class, 'edit'])->name('laboratory.edit');
    Route::put('/laboratory/{staff}', [LaboratoryController::class, 'update'])->name('laboratory.update');


                /*patient*/
        Route::resource('patients', PatientController::class)->except(['create']); 
        // Hospial Routes
Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospitals.index');
Route::post('/hospitals/store', [HospitalController::class, 'store'])->name('hospitals.store');
Route::post('/hospitals/update', [HospitalController::class, 'store'])->name('hospitals.update');
Route::delete('/hospitals', [HospitalController::class, 'store'])->name('hospitals.destroy'); 


                /*invoiceItem*/
    Route::get('/invoice_items', [InvoiceItemController::class, 'index'])->name('invoice_items.index');
    Route::post('/invoice_items', [InvoiceItemController::class, 'store'])->name('invoice_items.store');
    Route::delete('/invoice_items/{staff}', [InvoiceItemController::class, 'destroy'])->name('invoice_items.destroy');
    Route::get('/invoice_items/{staff}/edit', [InvoiceItemController::class, 'edit'])->name('invoice_items.edit');
    Route::put('/invoice_items/{staff}', [InvoiceItemController::class, 'update'])->name('invoice_items.update');

                /*invoiceItem*/
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::delete('/invoice/{staff}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/{staff}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{staff}', [InvoiceController::class, 'update'])->name('invoice.update');

             //Department
        Route::get('/departments', [DepartmentController::class,'index'])->name('departments.index');
        Route::post('/departments', [DepartmentController::class,'store'])->name('departments.store');
        Route::delete('/departments/{department}', [DepartmentController::class,'destroy'])->name('departments.destroy');
});

/*require __DIR__.'/auth.php';*/


// Forgot Password routes

