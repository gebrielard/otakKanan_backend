<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFunctionController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommonRegulationsController;
use App\Http\Controllers\FoodDrinksController;


// User Controller
Route::group(['middleware' => 'jwt.verify'], function(){
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('me', [UserController::class, 'getAuthenticatedUser']);
    Route::post('/editProfile', [UserController::class, 'update']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

//Galery Controller
Route::group(['prefix' => 'gallery',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [GalleryController::class, 'index']);
    Route::post('/create', [GalleryController::class, 'store']);
    Route::post('/update/{id}', [GalleryController::class, 'update']);
    Route::delete('/delete/{id}', [GalleryController::class, 'destroy']);
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

//Common Regulation Controller
Route::group(['prefix' => 'common-regulations',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [CommonRegulationsController::class, 'index']);
    Route::post('/create', [CommonRegulationsController::class, 'store']);
    Route::post('/update/{id}', [CommonRegulationsController::class, 'update']);
    Route::delete('/delete/{id}', [CommonRegulationsController::class, 'destroy']);
});

//foodDrinks Controller
Route::group(['prefix' => 'food-drinks',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [CommonRegulationsController::class, 'index']);
    Route::post('/create', [CommonRegulationsController::class, 'store']);
    Route::post('/update/{id}', [CommonRegulationsController::class, 'update']);
    Route::delete('/delete/{id}', [CommonRegulationsController::class, 'destroy']);
});

//CategoryPrice Controller
Route::group(['prefix' => 'category-price',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [CommonRegulationsController::class, 'index']);
    Route::post('/create', [CommonRegulationsController::class, 'store']);
    Route::post('/update/{id}', [CommonRegulationsController::class, 'update']);
    Route::delete('/delete/{id}', [CommonRegulationsController::class, 'destroy']);
});

//OperationalTimes Controller
Route::group(['prefix' => 'operational-times',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [CommonRegulationsController::class, 'index']);
    Route::post('/create', [CommonRegulationsController::class, 'store']);
    Route::post('/update/{id}', [CommonRegulationsController::class, 'update']);
    Route::delete('/delete/{id}', [CommonRegulationsController::class, 'destroy']);
});