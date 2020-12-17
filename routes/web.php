<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Admin\Branches;
use App\Http\Livewire\Admin\CabinetOrganizations;
use App\Http\Livewire\Admin\DataTemplates;
use App\Http\Livewire\Admin\Departments;
use App\Http\Livewire\Admin\Instituations;
use App\Http\Livewire\Admin\Ontologies;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Verify;
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

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');

    Route::prefix('admin')->name('admin.')->group(function(){
        Route::view('dashboard','admin.pages.dashboard')
            ->name('dashboard');
        Route::get('cabinet-organizations',CabinetOrganizations::class)
            ->name('cabinetOrganizations.index');
        Route::get('departments',Departments::class)
            ->name('departments.index');
        Route::get('instituations',Instituations::class)
            ->name('instituations.index');
        Route::get('branches',Branches::class)
            ->name('branches.index');
        Route::prefix('modelling')->group(function(){
            Route::get('ontologies',Ontologies::class)
                ->name('ontologies.index');
            Route::get('data-templates',DataTemplates::class)
                ->name('dataTemplates.index');
        });
    });
});

