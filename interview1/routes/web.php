<?php

use App\Models\WebhookData;
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
    
    $data = WebhookData::orderBy('product_name')
    ->get();
    return view('webookdata', compact('data'));
});

Route::webhooks('webhook-receiving-url');
