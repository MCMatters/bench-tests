<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class ArrayVsCompact extends BenchmarkController
{
    /**
     * @return View
     * @throws \ReflectionException
     */
    public function test(): View
    {
        $avg = [];
        $executed = [];

        for ($i = 0; $i < 100; $i++) {
            foreach ($this->getTests() as $method) {
                $executed[$this->sanitizeMethodName($method)][] = $this->runTest($method);
            }
        }

        foreach ($executed as $method => $results) {
            foreach ($this->getTestItems() as $item) {
                $avg[$method][$item] = $this->avg($results, $item);
            }
        }

        return view('benchmark.view', ['avg' => Arr::sort($avg, 'time')]);
    }

    public function compactTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        $array = compact($foo, $bar, $baz);
    }

    public function manualArrayTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        $array = ['foo' => $foo, 'bar' => $bar, 'baz' => $baz];
    }
}
