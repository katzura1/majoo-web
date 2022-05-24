<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboadController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
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


Route::get('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['check.login']], function () {
    Route::get('/', [AuthController::class, 'index'])->name('login_page');
});

Route::group(['middleware' => ['check.session']], function () {
    Route::get('home', [DashboadController::class, 'index'])->name('home');
    Route::get('product_category', [ProductCategoryController::class, 'index'])->name('product_category.index');
    Route::get('product', [ProductController::class, 'index'])->name('product.index');
});

Route::group(['middleware' => ['check.ajax']], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');;
});

Route::group(['middleware' => ['check.session', 'check.ajax']], function () {
    Route::get('product_category/data', [ProductCategoryController::class, 'data'])->name('product_category.data');

    Route::post('product_category/save', [ProductCategoryController::class, 'save'])->name('product_category.save');
    Route::post('product_category/delete', [ProductCategoryController::class, 'delete'])->name('product_category.delete');
    Route::post('product_category/select2', [ProductCategoryController::class, 'select2'])->name('product_category.select2');


    Route::get('product/data', [ProductController::class, 'data'])->name('product.data');

    Route::post('product/save', [ProductController::class, 'save'])->name('product.save');
    Route::post('product/save_photo', [ProductController::class, 'save_photo'])->name('product.save_photo');
    Route::post('product/delete', [ProductController::class, 'delete'])->name('product.delete');
});
