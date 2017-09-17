<?php

declare(strict_types = 1);

Route::view('/', 'index');

Route::get('bench/get-config', 'Benchmark\GetConfig@test');
Route::get('bench/in_array-isset', 'Benchmark\InArrayVsIsset@test');
