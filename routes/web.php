<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use App\Models\Genre;

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

Route::get('/', function () {
    return view('pages.index');
})->name('index');

Route::get('/registration', [AuthController::class,'RegistrationUserPage'])->middleware('guest')->name('RegistrationUserPage');

Route::post('/registration', [AuthController::class,'RegistrationUserSubmit'])->name('RegistrationUserSubmit');

Route::get('sign-up/github' , [AuthController::class,'github']);

Route::get('sign-up/github/redirect' , [AuthController::class,'githubRedirect']);

Route::get('/login', [AuthController::class,'LoginUserPage'])->middleware('guest')->name('LoginUserPage');

Route::post('/login', [AuthController::class,'LoginUserSubmit'])->name('LoginUserSubmit');

Route::get('/verify/{id}', [AuthController::class,'verifyEmail'])->middleware('guest')->name('verifyEmail');

Route::get('/profile/{id}', [AuthController::class,'UserProfilePage'])->name('UserProfilePage');

Route::get('/logout',[AuthController::class,'Logout'])->name('Logout');

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/' , [AdminDashboardController::class,'index'])->name('admin');
        Route::get('/delete/{id}', [AdminDashboardController::class,'deleteUser'])->name('deleteUser');
    });
});

Route::resource('book', BookController::class);

Route::group(['middleware' => ['auth']], function() {
Route::get('stripe/{id}', [StripeController::class, 'stripe'])->name('stripe');
Route::post('stripe/{id}', [StripeController::class, 'stripePost'])->name('stripe.post');
});

Route::get('/{file}', [DownloadController::class, 'download'])->name('download');
