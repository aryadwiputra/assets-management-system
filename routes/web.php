<?php

use App\Http\Controllers\AssetClassController;
use App\Http\Controllers\AssetStatusController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PersonInChargeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UnitOfMeasurementController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $users = User::all();

    return view('pages.dashboard.index', compact('users'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('companies', CompanyController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('assets-class', AssetClassController::class);
    Route::resource('assets-status', AssetStatusController::class);
    Route::resource('unit-of-measurement', UnitOfMeasurementController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('person-in-charge', PersonInChargeController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('settings', SettingController::class);

    Route::get('/log', LogController::class)->name('log');
    Route::get('/log-activity', [LogActivityController::class, 'index'])->name('log-activity');
});

require __DIR__ . '/auth.php';