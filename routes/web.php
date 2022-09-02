<?php

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

Route::match(['post', 'get'], '/', [\App\Http\Controllers\AuthController::class, 'login']);


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);
    Route::group(['prefix' => 'provinsi'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProvinceController::class, 'index']);
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\ProvinceController::class, 'add']);
    });
    Route::group(['prefix' => 'kota'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CityController::class, 'index']);
    });
});
