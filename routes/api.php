<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFunctionController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\FacilityController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Room Controller
Route::get('/room', [RoomController::class, 'index']);
Route::get('/room/{id}', [RoomController::class, 'show']);
Route::post('/room/create', [RoomController::class, 'store']);
Route::put('/room/{id}', [RoomController::class, 'update']);
Route::delete('/room/{id}', [RoomController::class, 'destroy']);

// Room Function Controller
Route::get('/room/function', [RoomFunctionController::class, 'index']);
Route::get('/room/function{id}', [RoomFunctionController::class, 'show']);
Route::post('/room/function/create', [RoomFunctionController::class, 'store']);
Route::put('/room/function/{id}', [RoomFunctionController::class, 'update']);
Route::delete('/room/function/{id}', [RoomFunctionController::class, 'destroy']);

// Room Type Controller
Route::get('/room/type', [RoomTypeController::class, 'index']);
Route::get('/room/type/{id}', [RoomTypeController::class, 'show']);
Route::post('/room/type/create', [RoomTypeController::class, 'store']);
Route::put('/room/type/{id}', [RoomTypeController::class, 'update']);
Route::delete('/room/type/{id}', [RoomTypeController::class, 'destroy']);

// Facility Controller
Route::get('/facility', [FacilityController::class, 'index']);
Route::get('/facility/{id}', [FacilityController::class, 'show']);
Route::post('/facility/create', [FacilityController::class, 'store']);
Route::put('/facility/{id}', [FacilityController::class, 'update']);
Route::delete('/facility/{id}', [FacilityController::class, 'destroy']);