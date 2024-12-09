<?php

use App\Http\Controllers\AssetClassController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetRepairCarController;
use App\Http\Controllers\AssetRepairElectronicController;
use App\Http\Controllers\AssetStatusController;
use App\Http\Controllers\AssetUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\PersonInChargeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
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
  
    Route::delete('assets/deletePhoto', [AssetController::class, 'deletePhoto'])->name('assets.deletePhoto');
    Route::get('assets/print-qr', [AssetController::class, 'printQR'])->name('assets.print-qr');
    Route::post('assets/import', [AssetController::class, 'import'])->name('assets.import');
    Route::get('assets/{asset}/mutation', [AssetController::class, 'mutation'])->name('assets.mutation');
    Route::post('assets/sale/store', [AssetController::class, 'addSale'])->name('assets.sale.store');
    Route::post('assets/disposal/store', [AssetController::class, 'addDisposal'])->name('assets.disposal.store');
    Route::post('assets/repair-car/store', [AssetRepairCarController::class, 'store'])->name('assets.repair-car.store');
    Route::get('/assets/repair-car/{id}', [App\Http\Controllers\AssetRepairCarController::class, 'show'])->name('dashboard.assets.repair-car.show');
    Route::put('/assets/repair-car/{id}', [App\Http\Controllers\AssetRepairCarController::class, 'update'])->name('dashboard.assets.repair-car.update');
    Route::post('assets/repair-electronic/store', [AssetRepairElectronicController::class, 'store'])->name('assets.repair-electronic.store');
    Route::get('/assets/repair-electronic/{id}', [App\Http\Controllers\AssetRepairElectronicController::class, 'show'])->name('assets.repair-electronic.show');
    Route::put('/assets/repair-electronic/{id}', [App\Http\Controllers\AssetRepairElectronicController::class, 'update'])->name('assets.repair-electronic.update');


    Route::get('/assets/borrow', [App\Http\Controllers\AssetBorrowingController::class, 'index'])->name('assets.borrow.index'); 
    Route::get('/assets/borrow/create', [App\Http\Controllers\AssetBorrowingController::class, 'create'])->name('assets.borrow.create');
    Route::post('/assets/borrow', [App\Http\Controllers\AssetBorrowingController::class, 'store'])->name('assets.borrow.store');
    Route::get('/assets/borrow/{id}', [App\Http\Controllers\AssetBorrowingController::class, 'show'])->name('assets.borrow.show');
    Route::get('/assets/borrow/edit/{id}', [App\Http\Controllers\AssetBorrowingController::class, 'edit'])->name('assets.borrow.edit');
    Route::put('/assets/borrow/{id}', [App\Http\Controllers\AssetBorrowingController::class, 'update'])->name('assets.borrow.update');
    Route::delete('/assets/borrow/{id}', [App\Http\Controllers\AssetBorrowingController::class, 'destroy'])->name('assets.borrow.destroy');

    Route::resource('assets', AssetController::class);

    // Mutations
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

    // Disposals
    Route::post('disposals/add-asset', [DisposalController::class, 'addAsset'])->name('disposals.add-asset');
    Route::delete('disposals/remove-asset', [DisposalController::class, 'removeAsset'])->name('disposals.remove-asset');    
    Route::post('disposals/bulk-add-asset', [DisposalController::class, 'bulkAddAsset'])->name('disposals.bulk-add-asset');
    Route::post('disposals/bulk-remove-asset', [DisposalController::class, 'bulkRemoveAsset'])->name('disposals.bulk-remove-asset');
    Route::post('disposals/{disposal}/cancel', [DisposalController::class, 'cancel'])->name('disposals.cancel'); 
    Route::post('disposals/{disposal}/open', [DisposalController::class, 'open'])->name('disposals.open');
    Route::get('disposals/{disposal}/print', [DisposalController::class, 'print'])->name('disposals.print');
    Route::post('disposals/{disposal}/done', [DisposalController::class, 'done'])->name('disposals.done');
    Route::post('disposals/{disposal}/upload-document', [DisposalController::class, 'uploadDocument'])->name('disposals.upload-document');
    Route::delete('disposals/{disposal}/delete-document/{file_id}', [DisposalController::class, 'deleteDocument'])->name('disposals.delete-document');
    Route::resource('disposals', DisposalController::class);

    // Sales
    Route::post('sales/add-asset', [SaleController::class, 'addAsset'])->name('sales.add-asset');
    Route::delete('sales/remove-asset', [SaleController::class, 'removeAsset'])->name('sales.remove-asset');    
    Route::post('sales/bulk-add-asset', [SaleController::class, 'bulkAddAsset'])->name('sales.bulk-add-asset');
    Route::post('sales/bulk-remove-asset', [SaleController::class, 'bulkRemoveAsset'])->name('sales.bulk-remove-asset');
    Route::post('sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel'); 
    Route::post('sales/{sale}/open', [SaleController::class, 'open'])->name('sales.open');
    Route::get('sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    Route::post('sales/{sale}/done', [SaleController::class, 'done'])->name('sales.done');
    Route::post('sales/{sale}/upload-document', [SaleController::class, 'uploadDocument'])->name('sales.upload-document');
    Route::delete('sales/{sale}/delete-document/{file_id}', [SaleController::class, 'deleteDocument'])->name('sales.delete-document');
    Route::resource('sales', SaleController::class);

    Route::get('/report/mutation', [ReportController::class, 'mutation'])->name('report.mutation');
    Route::get('/report/mutation/print', [ReportController::class, 'printMutation'])->name('report.printMutation');
    Route::get('/report/borrow', [ReportController::class, 'borrow'])->name('report.borrow');
    Route::get('/report/borrow/print', [ReportController::class, 'printBorrow'])->name('report.printBorrow');
    Route::get('/report/repair-car', [ReportController::class, 'repair_car'])->name('report.repair.car');
    Route::get('/report/repair-car/print', [ReportController::class, 'printRepairCar'])->name('report.printRepairCar');
    Route::get('/report/repair-electronic', [ReportController::class, 'repair_electronic'])->name('report.repair.electronic');
    Route::get('/report/repair-electronic/print', [ReportController::class, 'printRepairElectronic'])->name('report.printRepairElectronic');

    Route::resource('settings', SettingController::class);
    Route::get('/log', LogController::class)->name('log');
    Route::get('/log-activity', [LogActivityController::class, 'index'])->name('log-activity');
});

require __DIR__ . '/auth.php';  