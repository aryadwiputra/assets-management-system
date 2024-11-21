<?php

use App\Http\Controllers\AssetClassController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetStatusController;
use App\Http\Controllers\AssetUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\PersonInChargeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UnitOfMeasurementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/dashboard');

Route::get('/assets/{slug}', [MainController::class, 'detail'])->name('assets.detail');

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
    Route::resource('class', ClassController::class);
    Route::resource('status', StatusController::class);
    Route::resource('unit-of-measurement', UnitOfMeasurementController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('person-in-charge', PersonInChargeController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('warranties', WarrantyController::class);
    Route::post('assets/import', [AssetController::class, 'import'])->name('assets.import');
    Route::resource('assets', AssetController::class);
    Route::post('mutations/add-asset', [MutationController::class, 'addAsset'])->name('mutations.add-asset');
    Route::delete('mutations/remove-asset', [MutationController::class, 'removeAsset'])->name('mutations.remove-asset');    
    Route::post('mutations/bulk-add-asset', [MutationController::class, 'bulkAddAsset'])->name('mutations.bulk-add-asset');
    Route::post('mutations/bulk-remove-asset', [MutationController::class, 'bulkRemoveAsset'])->name('mutations.bulk-remove-asset');
    Route::post('mutations/{mutation}/cancel', [MutationController::class, 'cancel'])->name('mutations.cancel'); 
    Route::post('mutations/{mutation}/open', [MutationController::class, 'open'])->name('mutations.open');
    Route::get('mutations/{mutation}/print', [MutationController::class, 'print'])->name('mutations.print');
    Route::post('mutations/{mutation}/done', [MutationController::class, 'done'])->name('mutations.done');
    Route::post('mutations/{mutation}/upload-document', [MutationController::class, 'uploadDocument'])->name('mutations.upload-document');
    Route::delete('mutations/{mutation}/delete-document/{file_id}', [MutationController::class, 'deleteDocument'])->name('mutations.delete-document');
    Route::resource('mutations', MutationController::class);
    Route::resource('settings', SettingController::class);

    Route::get('/log', LogController::class)->name('log');
    Route::get('/log-activity', [LogActivityController::class, 'index'])->name('log-activity');
});

require __DIR__ . '/auth.php';  