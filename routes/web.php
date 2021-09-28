<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FarmerController;
use App\Http\Controllers\Admin\IndicatorController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\BasicController;

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
  return redirect('/admin/dashboard');
});

/**-------------------Admin Routes-----------------*/
Route::prefix('admin')->name('admin.')->group(function() {

  /** Dashboard */
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  /** Farmers */
  Route::get('/farmers', [FarmerController::class, 'index'])->name('farmer.index');
  Route::get('/farmers/{farmer}', [FarmerController::class, 'show'])->name('farmer.show');

  /** Indicators */
  Route::get('/indicators', [IndicatorController::class, 'index'])->name('indicator.index');
  Route::get('exportExcel/{type}', [IndicatorController::class, 'exportExcel'])->name('indicator.export');
  Route::post('/indicators/importExcel', [IndicatorController::class, 'importExcel'])->name('indicator.import');

  /** History of contours */
  Route::get('/histories', [HistoryController::class, 'index'])->name('history.index');

  /** Basic data */
  Route::prefix('basic')->name('basic.')->group(function() {
    Route::get('/regions', [BasicController::class, 'getRegions'])->name('region.index');
    Route::get('/districts', [BasicController::class, 'getDistricts'])->name('district.index');
    Route::get('/matrix', [BasicController::class, 'getMatrix'])->name('matrix.index');
  });

});
