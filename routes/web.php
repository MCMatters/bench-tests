<?php

declare(strict_types = 1);

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index');

Route::get('bench/{arg}', BenchmarkController::class);
