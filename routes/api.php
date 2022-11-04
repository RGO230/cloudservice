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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
Route::middleware(['auth'])->group(function(){
  
});  

Route::group(['middleware'=>'auth:sanctum'],function(){
   
});

Route::post('/file/{user_id}', [App\Http\Controllers\FileController::class, 'uploadfile']); 
Route::put('/file/{file}', [App\Http\Controllers\FileController::class, 'renamefile']);
Route::delete('/file/{file}', [App\Http\Controllers\FileController::class, 'deletefile']);
Route::get('/file/{file}', [App\Http\Controllers\FileController::class, 'downloadfile']);
Route::post('/directory/{user_id}', [App\Http\Controllers\DirectoryController::class, 'createdirectory']); 
Route::get('/geturl/{file}', [App\Http\Controllers\FileController::class, 'getPublicUrl']);
Route::get('/getweightdir/{directory_id}', [App\Http\Controllers\FileController::class, 'getDirectoryWeight']);
Route::get('/getweightdisk/{user_id}', [App\Http\Controllers\FileController::class, 'getDiskWeight']);


