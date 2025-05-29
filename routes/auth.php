<?php

use App\Livewire\Auth\Admin\Login;
use App\Livewire\Pages\PageEditPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Sites\IndexPage;
use App\Livewire\Sites\EditPage;

Route::middleware('auth')->group(function () {

  Route::view('/dashboard', 'dashboard')->name('dashboard');


  Route::get('sites', IndexPage::class)->name('sites.index');
  Route::get('sites/{subdomain}/editar', EditPage::class)->name('sites.edit');
  Route::get('pages/{page}/editar', PageEditPage::class)->name('pages.edit');
});

Route::group(['prefix' => ''], function () {

  Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    // Route::get('register', Register::class)->name('register');
    // Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    // Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
  });

  // Route::middleware('auth')->group(function () {
  //     Route::get('verify-email', VerifyEmail::class)
  //         ->name('verification.notice');

  //     Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
  //         ->middleware(['signed', 'throttle:6,1'])
  //         ->name('verification.verify');

  //     Route::get('confirm-password', ConfirmPassword::class)
  //         ->name('password.confirm');
  // });

  Route::any('logout', App\Livewire\Actions\Admin\Logout::class)
    ->name('logout');
});
