<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
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

Route::post('product', [ProductController::class, 'create']);
Route::post('product/upload_photo', [ProductController::class, 'upload_photo']);
Route::get('product', [ProductController::class, 'read']);
Route::get('product/{id?}', [ProductController::class, 'read']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'delete']);

Route::post('product_category', [ProductCategoryController::class, 'create']);
Route::get('product_category', [ProductCategoryController::class, 'read']);
Route::get('product_category/{id?}', [ProductCategoryController::class, 'read']);
Route::put('product_category/{id}', [ProductCategoryController::class, 'update']);
Route::delete('product_category/{id}', [ProductCategoryController::class, 'delete']);

Route::post('admin', [AdminController::class, 'create']);
Route::post('login', [AdminController::class, 'login']);
Route::get('admin', [AdminController::class, 'read']);
Route::get('admin/{id?}', [AdminController::class, 'read']);
Route::put('admin/{id}', [AdminController::class, 'update']);
Route::put('admin/password/{id}', [AdminController::class, 'update_password']);
Route::delete('admin/{id}', [AdminController::class, 'delete']);
