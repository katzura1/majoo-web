<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboadController;
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

Route::group(['middleware' => ['check.login']], function () {
    Route::get('/', [AuthController::class, 'index']);
});

Route::group(['middleware' => ['check.session']], function () {
    Route::get('home', [DashboadController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['check.ajax']], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');;
});
