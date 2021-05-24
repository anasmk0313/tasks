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

Route::get('/', function () {
    return redirect(url('/product/view'));
});

Route::get('/product/view', [App\Http\Controllers\ProductController::class, 'view']);
Route::post('/product/create', [App\Http\Controllers\ProductController::class, 'store']);

Route::post('/save-token', [App\Http\Controllers\NotificationController::class, 'saveToken'])->name('save-token');
// Route::post('/send-notification', [App\Http\Controllers\NotificationController::class, 'sendNotification'])->name('send.notification');