<?php

declare(strict_types = 1);

Route::view('/', 'index');

Route::get('bench/get-config', 'Benchmark\GetConfig@test');
Route::get('bench/in_array-isset', 'Benchmark\InArrayVsIsset@test');
Route::get('bench/view', 'Benchmark\View@test');
Route::get('bench/reference-overriding', 'Benchmark\ReferenceVsOverriding@test');
Route::get('bench/array-compact', 'Benchmark\ArrayVsCompact@test');
