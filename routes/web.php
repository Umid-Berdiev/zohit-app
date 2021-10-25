<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FarmerController;
use App\Http\Controllers\Admin\IndicatorController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\BasicController;
use App\Http\Controllers\Admin\ShapefileController;
use App\Http\Controllers\Portal\PortalController;

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
  return redirect('/portal');
});

/**------------------Portal Routes-----------------*/
Route::get('/portal', [PortalController::class, 'index'])->name('portal.index');

/**-------------------Admin Routes-----------------*/
Route::prefix('admin')->name('admin.')->group(function() {

  /** Dashboard */
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  /** Farmers */
  Route::get('/farmers', [FarmerController::class, 'index'])->name('farmer.index');
  Route::get('/farmers/{farmer}', [FarmerController::class, 'show'])->name('farmer.show');
  Route::post('/farmers/update', [FarmerController::class, 'update'])->name('farmer.update');
  Route::post('/farmers/delete', [FarmerController::class, 'destroy'])->name('farmer.delete');
  Route::get('/farmers/list/{district}', [FarmerController::class, 'getFarmerList'])->name('farmer.filter-list');

  /** Indicators */
  Route::get('/indicators', [IndicatorController::class, 'index'])->name('indicator.index');
  Route::get('/indicators/exportExcel/{type}', [IndicatorController::class, 'exportExcel'])->name('indicator.export');
  Route::get('/indicators/templateExportExcel/{type}', [IndicatorController::class, 'templateExportExcel'])->name('indicator.template-export');
  Route::post('/indicators/importExcel', [IndicatorController::class, 'importExcel'])->name('indicator.import');

  /** History of contours */
  Route::get('/histories', [HistoryController::class, 'index'])->name('history.index');
  Route::get('/histories/exportExcel/{type}', [HistoryController::class, 'exportExcel'])->name('history.export');
  Route::get('/histories/templateExportExcel/{type}', [HistoryController::class, 'templateExportExcel'])->name('history.template-export');
  Route::post('/histories/importExcel', [HistoryController::class, 'importExcel'])->name('history.import');

  /** Import Shape file */
  Route::get('/shape-file', [ShapefileController::class, 'index'])->name('shape-file.index');
  Route::post('/shape-file/import', [ShapefileController::class, 'importShapeFile'])->name('shape-file.import');

  /** Basic data */
  Route::prefix('basic')->name('basic.')->group(function() {
    Route::get('/regions', [BasicController::class, 'getRegions'])->name('region.index');
    Route::get('/districts', [BasicController::class, 'getDistricts'])->name('district.index');
    Route::get('/districts/{region}', [BasicController::class, 'getDistrictList'])->name('district.list');
    Route::get('/matrix', [BasicController::class, 'getMatrix'])->name('matrix.index');
  });

});
