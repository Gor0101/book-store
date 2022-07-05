<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class,'index'])->name('index');

Route::prefix('registration')->group(function () {
    Route::get('/', [AuthController::class,'registrationUserPage'])->middleware('guest')->name('RegistrationUserPage');

    Route::post('/', [AuthController::class,'registrationUserSubmit'])->name('RegistrationUserSubmit');
});

Route::prefix('sign-up')->group(function () {

    Route::get('/github' , [AuthController::class,'github']);

    Route::get('/github/redirect' , [AuthController::class,'githubRedirect']);

});

Route::prefix('login')->group(function () {

    Route::get('/', [AuthController::class,'loginUserPage'])->middleware('guest')->name('LoginUserPage');

    Route::post('/', [AuthController::class,'loginUserSubmit'])->name('LoginUserSubmit');

});

Route::prefix('forgot-password')->group(function () {

    Route::get('/', function () {
        return view('auth.forgot-password');
    })->middleware('guest')->name('password.request');

    Route::post('/', [PasswordResetController::class , 'checkAndSend'])->middleware('guest')->name('password.email');

});

Route::prefix('reset-password')->group(function () {

    Route::get('/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

    Route::post('/', [PasswordResetController::class , 'reset'])->middleware('guest')->name('password.update');

});

Route::get('/verify/{id}', [AuthController::class,'verifyEmail'])->middleware('guest')->name('verifyEmail');

Route::get('/profile/{id}', [AuthController::class,'userProfilePage'])->name('UserProfilePage');

Route::get('/logout',[AuthController::class,'logout'])->name('Logout');

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/' , [AdminDashboardController::class,'index'])->name('admin');
        Route::get('/delete/{id}', [AdminDashboardController::class,'deleteUser'])->name('deleteUser');
    });
});

Route::resource('book', BookController::class);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/stripe/{id}', [StripeController::class, 'stripe'])->name('stripe');
    Route::post('/stripe/{id}', [StripeController::class, 'stripePost'])->name('stripe.post');
    Route::get('/subscribe',[StripeController::class, 'index']);
    Route::post('/subscribe/{id}',[StripeController::class, 'store']);
    Route::get('/refund/{id}',[StripeController::class, 'refundPayment']);
    Route::get('/subscribe/refund/{id}',[StripeController::class, 'refundSubscription']);
});

Route::get('{file}', [DownloadController::class, 'download'])->name('download');
