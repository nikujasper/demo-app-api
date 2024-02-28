<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\InspectionController;

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
Route::get('/getBlock/{id}', [InspectionController::class, 'getBlock']);
Route::get('/getCluster/{id}', [InspectionController::class, 'getCluster']);
Route::get('/getSchool/{id}', [InspectionController::class, 'getSchool']);
