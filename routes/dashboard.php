<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Auth\Passwords\ForgetPasswordController;
use App\Http\Controllers\Dashboard\Auth\Passwords\RestPasswordController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
    ],
    function () {
        Route::controller(AuthController::class)->name('login.')->group(function () {
            Route::get('/login', 'showLoginForm')->name('showLoginForm');
            Route::post('/login', 'login')->name('post');
            Route::post('/logout', 'logout')->name('logout');

        });
        Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
            Route::get('email', [ForgetPasswordController::class, 'showEmailForm'])->name('showEmailForm');
            Route::post('email', [ForgetPasswordController::class, 'sendOtp'])->name('sendOtp');
            Route::get('confirm/{email}', [ForgetPasswordController::class, 'showConfirmForm'])->name('showConfirmForm');
            Route::post('confirm/', [ForgetPasswordController::class, 'verifyOtp'])->name('verifyOtp');
            Route::get('rest/{email}', [RestPasswordController::class, 'showRestForm'])->name('showRestForm');
            Route::post('rest/', [RestPasswordController::class, 'rest'])->name('rest');

        });
        Route::group(
            ['middleware' => ['auth:user']],
            function () {
                Route::get('/home', [HomeController::class, 'index'])->name('home');

                ////////////////////////////////////////////#roles#//////////////////////////////////////////
                Route::group(['middleware' => 'can:roles'], function () {
                    Route::resource('roles', RoleController::class);
                });

                ////////////////////////////////////////////#user#//////////////////////////////////////////
                Route::group(['middleware' => 'can:users'], function () {
                    Route::resource('users', UserController::class);
                    Route::get('users/{id}/status', [UserController::class, 'changeStatus'])
                        ->name('users.status');
                });


                Route::group(['middleware' => 'can:invoices'], function () {
                    Route::get('invoices/{invoice}/pdf', [InvoiceController::class,'downloadPdf'])
                        ->name('invoices.pdf');
                    Route::resource('invoices', InvoiceController::class);
                    Route::get('invoices-all', [InvoiceController::class, 'getAll'])
                        ->name('invoices.all');

                });


                Route::group(['middleware' => 'can:clients'], function () {
                    Route::resource('clients', ClientController::class);
                    Route::get('clients-all', [ClientController::class, 'getAll'])
                        ->name('clients.all');
                });

            }

        );
    }
);


