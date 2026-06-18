<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;

// Pastikan baris ini ada ya!
Route::post('/sensor/pir-update', [DosenController::class, 'updateStatusBySensor']);