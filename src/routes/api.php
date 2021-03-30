<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', 'App\Http\Controllers\API\ProductController@index')->name('api.v1.products.index');
        Route::post('/store', 'App\Http\Controllers\API\ProductController@store')->name('api.v1.products.store');
        Route::patch('/{product_id}/update', 'App\Http\Controllers\API\ProductController@update')->name('api.v1.products.update');
        Route::delete('/{product_id}/delete', 'App\Http\Controllers\API\ProductController@delete')->name('api.v1.products.delete');
    });

    Route::prefix('product_categories')->group(function () {
        Route::get('/', 'App\Http\Controllers\API\ProductCategoryController@index')->name('api.v1.product_categories.index');
        Route::post('/store', 'App\Http\Controllers\API\ProductCategoryController@store')->name('api.v1.product_categories.store');
        Route::patch('/{product_category_id}/update', 'App\Http\Controllers\API\ProductCategoryController@update')->name('api.v1.product_categories.update');
        Route::delete('/{product_category_id}/delete', 'App\Http\Controllers\API\ProductCategoryController@delete')->name('api.v1.product_categories.delete');
    });

});
