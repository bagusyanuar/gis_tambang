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

Route::match(['post', 'get'], '/', [\App\Http\Controllers\AuthController::class, 'login'])->middleware('guest');
Route::get( '/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/quarry/map', [\App\Http\Controllers\DashboardController::class, 'geo_json_data']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);

    Route::group(['prefix' => 'jenis', 'middleware' => 'admin'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\CategoryController::class, 'add']);
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'patch']);
        Route::post( '/{id}/delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'perusahaan'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CompanyController::class, 'index']);
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\CompanyController::class, 'add']);
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\CompanyController::class, 'patch']);
        Route::post( '/{id}/delete', [\App\Http\Controllers\Admin\CompanyController::class, 'destroy']);
    });

    Route::group(['prefix' => 'member'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\MemberController::class, 'index']);
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\MemberController::class, 'add']);
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\MemberController::class, 'patch']);
        Route::match(['post', 'get'], '/{id}/password', [\App\Http\Controllers\Admin\MemberController::class, 'change_password']);
        Route::post( '/{id}/delete', [\App\Http\Controllers\Admin\MemberController::class, 'destroy']);
    });

    Route::group(['prefix' => 'provinsi'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProvinceController::class, 'index']);
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\ProvinceController::class, 'add']);
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\ProvinceController::class, 'patch']);
        Route::post( '/{id}/delete', [\App\Http\Controllers\Admin\ProvinceController::class, 'destroy']);
    });
    Route::group(['prefix' => 'kota'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\CityController::class, 'index']);
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\CityController::class, 'add']);
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\CityController::class, 'patch']);
    });

    Route::group(['prefix' => 'quarry'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\QuarryController::class, 'index']);
        Route::get('/data', [\App\Http\Controllers\Admin\QuarryController::class, 'data']);
//        Route::post('/media', [\App\Http\Controllers\Admin\QuarryController::class, 'store_tmp_media'])->name('products.storeMedia');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\Admin\QuarryController::class, 'add']);
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\Admin\QuarryController::class, 'patch']);
        Route::get('/{id}/detail', [\App\Http\Controllers\Admin\QuarryController::class, 'show']);
        Route::post('/{id}/media', [\App\Http\Controllers\Admin\QuarryController::class, 'add_media']);
        Route::post('/{image_id}/media/destroy', [\App\Http\Controllers\Admin\QuarryController::class, 'remove_media']);
    });
});

Route::group(['prefix' => 'member', 'middleware' => 'auth:web'], function (){
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'dashboard_member']);
});
