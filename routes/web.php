<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
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

});
