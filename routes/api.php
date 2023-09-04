<?php

use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\classroom\AttachmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::post('login', [AuthController::class, 'login']);

Route::controller(AttachmentController::class)->group(function () {
    
    Route::middleware('auth:sanctum')->group(function (){
        
    });

    Route::post('convert/file', 'convertion')->name('file.convertion');
});
