<?php

use \App\Http\Controllers\DataController;
use \App\Http\Controllers\SmtpAccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use \App\Http\Controllers\DropController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// routes/api.php

//Test & drops
Route::prefix('email')->group(function () {
    Route::post('/send', [EmailController::class, 'sendBatchEmails']);
});
//accounts
Route::prefix('accounts')->group(function () {
    Route::get('/', [SmtpAccountController::class, 'index']);
    Route::post('/', [SmtpAccountController::class, 'store']);
    Route::get('/check_available', [EmailController::class, 'checkAvailableAccount']);
    Route::put('/{id}', [SmtpAccountController::class, 'update']);
    Route::delete('/{id}', [SmtpAccountController::class, 'delete']);
});
//drops
Route::prefix('drops')->group(function () {
    Route::get('/', [DropController::class, 'index']);
});
Route::put('account/enable/{id}', [SmtpAccountController::class, 'enable']);

//Data


Route::get('/get_data', [DataController::class, 'get_data']);
Route::post('/get_data_emails', [DataController::class, 'get_data_emails']);
Route::post('/data/upload', [DataController::class, 'uploadData']);
Route::get('/data/get_email', [DataController::class, 'search_by_email']);
Route::delete('/data/delete_email', [DataController::class, 'delete_email']);
Route::post('/data/get_data_count', [DataController::class, 'dataCount']);

