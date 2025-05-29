<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/registrar',"auth.register")
    ->middleware('guest')
    ->name('registerForm');

Route::post('/registrar', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::view('/login',"auth.login")
    ->middleware('guest')
    ->name('login.form');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::view('/esqueciSenha', "auth.forgotPassword")
    ->middleware('guest')
    ->name('password.email.form');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/password-reset/{token}', function(Request $r){
    return view("auth.newPassword",["token"=>$r->token,'email'=>$r->email]);
})
->middleware('guest')
->name('password.store');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/changePassword', [NewPasswordController::class, 'update'])
->middleware(['auth'])
->name('change.password');

Route::view('/mudarSenha', "auth.changePassword")
->middleware(['auth'])
->name('change.password.form');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
