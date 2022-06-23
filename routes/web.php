<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\IndexController;
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

Route::get('/registration', [AuthController::class,'registrationUserPage'])->middleware('guest')->name('RegistrationUserPage');

Route::post('/registration', [AuthController::class,'registrationUserSubmit'])->name('RegistrationUserSubmit');

Route::get('sign-up/github' , [AuthController::class,'github']);

Route::get('sign-up/github/redirect' , [AuthController::class,'githubRedirect']);

Route::get('/login', [AuthController::class,'loginUserPage'])->middleware('guest')->name('LoginUserPage');

Route::post('/login', [AuthController::class,'loginUserSubmit'])->name('LoginUserSubmit');

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
});

Route::get('{file}', [DownloadController::class, 'download'])->name('download');


