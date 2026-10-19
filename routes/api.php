<?php

use App\Http\Controllers\ObjectController;
use Illuminate\Support\Facades\Route;

Route::post('/object', [ObjectController::class, 'store']);
