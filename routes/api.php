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
Route::group(['prefix' => 'room',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [RoomController::class, 'index']);
    Route::post('/create', [RoomController::class, 'store']);
    Route::post('/update/{id}', [RoomController::class, 'update']);
    Route::delete('/delete/{id}', [RoomController::class, 'destroy']);
});

// Room Function Controller
Route::group(['prefix' => 'room-function',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [RoomFunctionController::class, 'index']);
    Route::post('/create', [RoomFunctionController::class, 'store']);
    Route::post('/update/{id}', [RoomFunctionController::class, 'update']);
    Route::delete('/delete/{id}', [RoomFunctionController::class, 'destroy']);
});

// Room Type Controller
Route::group(['prefix' => 'room-type',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [RoomTypeController::class, 'index']);
    Route::post('/create', [RoomTypeController::class, 'store']);
    Route::post('/update/{id}', [RoomTypeController::class, 'update']);
    Route::delete('/delete/{id}', [RoomTypeController::class, 'destroy']);
});

// Facility Controller
Route::group(['prefix' => 'facility',  'middleware' => ['jwt.verify']], function() {
    Route::get('/read', [FacilityController::class, 'index']);
    Route::post('/create', [FacilityController::class, 'store']);
    Route::post('/update/{id}', [FacilityController::class, 'update']);
    Route::delete('/delete/{id}', [FacilityController::class, 'destroy']);
});

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