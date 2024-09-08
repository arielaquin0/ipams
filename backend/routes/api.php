<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\IpAddress\IpAddressController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/ip-addresses', [IpAddressController::class, 'index']);
Route::post('/ip-addresses', [IpAddressController::class, 'store']);
