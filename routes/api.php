<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DirectoryController;


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

use App\Http\Controllers\JWTAuthController;
Route::get('user/{id}',[App\Http\Controllers\UserController::class,'getUser']);
Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::middleware(['jwt.auth']) ->group( function () {
    Route::post('/file/{user_id}', [App\Http\Controllers\FileController::class, 'uploadfile']);
    Route::put('/file/{file}', [App\Http\Controllers\FileController::class, 'renamefile']);
    Route::delete('/file/{file}', [App\Http\Controllers\FileController::class, 'deletefile']);
    Route::get('/file/{file}', [App\Http\Controllers\FileController::class, 'downloadfile']);
    Route::get('/getfile/{user_id}', [App\Http\Controllers\FileController::class, 'getfiles']);
    Route::post('/directory/{user_id}', [App\Http\Controllers\DirectoryController::class, 'createdirectory']);
    Route::get('/geturl/{file}', [App\Http\Controllers\FileController::class, 'getPublicUrl']);
    Route::get('/getweightdir/{directory_id}', [App\Http\Controllers\FileController::class, 'getDirectoryWeight']);
    Route::get('/getweightdisk/{user_id}', [App\Http\Controllers\FileController::class, 'getDiskWeight']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
});
