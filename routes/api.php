<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\SuperAdminController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
Route::get('/profile', [AuthController::class, 'profile']);
Route::post('/logout', [AuthController::class, 'logout']);


 Route::get('/owners', [SuperAdminController::class, 'ownerList']);
 Route::get('/owners/{id}', [SuperAdminController::class, 'viewOwner']);
 Route::put('/owners/{id}/subscription', [SuperAdminController::class, 'updateSubscription']);
 Route::delete('/owners/{id}', [SuperAdminController::class, 'deleteOwner']);



});
