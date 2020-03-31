<?php

declare(strict_types=1);

use App\Benchmarks\ArrayColumnVsArrPluck;
use App\Benchmarks\ArrayVsCompact;
use App\Benchmarks\CastingIntForeachVsArrayMap;
use App\Benchmarks\InArrayVsIsset;
use App\Benchmarks\ReferenceVsOverriding;
use App\Benchmarks\StringJoins;
use App\Benchmarks\View;
use App\Http\Controllers\Benchmarks\GetConfig;

return [
    'benchmarks' => [
        'array_column-arr_pluck' => ArrayColumnVsArrPluck::class,
        'array-compact' => ArrayVsCompact::class,
        'casting-int-foreach-array_map' => CastingIntForeachVsArrayMap::class,
        'get-config' => GetConfig::class,
        'in_array-isset' => InArrayVsIsset::class,
        'reference-overriding' => ReferenceVsOverriding::class,
        'string-joins' => StringJoins::class,
        'view' => View::class,
    ],
];
