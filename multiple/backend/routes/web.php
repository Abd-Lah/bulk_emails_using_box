<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\SmtpAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('email')->group(function () {
    Route::post('/send-batch', [EmailController::class, 'sendBatchEmails']);
});
Route::prefix('smtp-accounts')->group(function () {
    Route::post('/store', [SmtpAccountController::class, 'store']);
});
