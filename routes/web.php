<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboadController;
use App\Http\Controllers\ProductCategoryController;
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
});

Route::group(['middleware' => ['check.ajax']], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');;
});

Route::group(['middleware' => ['check.session', 'check.ajax']], function () {
    Route::get('product_category/data', [ProductCategoryController::class, 'data'])->name('product_category.data');

    Route::post('product_category/save', [ProductCategoryController::class, 'save'])->name('product_category.save');
    Route::post('product_category/delete', [ProductCategoryController::class, 'delete'])->name('product_category.delete');
    Route::post('product_category/select2', [ProductCategoryController::class, 'select2'])->name('product_category.select2');
});
