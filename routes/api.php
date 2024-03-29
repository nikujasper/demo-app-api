<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\InspectionController;
use App\Http\Controllers\RabbitMQController;
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
Route::POST('/userLogin', [UsersController::class, 'show']);
Route::get('/user', [UsersController::class, 'index']);
Route::get('/getDistrict', [InspectionController::class, 'getDistrict']);
Route::post('/getBlock', [InspectionController::class, 'getBlock']);
Route::post('/getCluster', [InspectionController::class, 'getCluster']);
Route::post('/getSchool', [InspectionController::class, 'getSchool']);
Route::post('/storeInspection', [InspectionController::class, 'store']);


Route::get('/queue', [InspectionController::class, 'que']);


Route::post('/publish', [RabbitMQController::class, 'publishMessage']);
Route::get('/consume', [RabbitMQController::class, 'consumeMessage']);
