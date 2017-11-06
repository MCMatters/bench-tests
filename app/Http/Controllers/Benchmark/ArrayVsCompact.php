<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Arr;
use Illuminate\View\View;

/**
 * Class ArrayVsCompact
 *
 * @package App\Http\Controllers\Benchmark
 */
class ArrayVsCompact extends BenchmarkController
{
    /**
     * @return View
     * @throws \ReflectionException
     */
    public function test(): View
    {
        // Prevent advantage, because view has caching.
        (string) view('benchmark.stubs.foo-bar-baz', ['foo' => '', 'bar' => '', 'baz' => '']);

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

    /**
     * @param string $foo
     * @param string $bar
     * @param string $baz
     *
     * @return void
     */
    public function compactTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        (string) view('benchmark.stubs.foo-bar-baz', compact($foo, $bar, $baz));
    }

    /**
     * @param string $foo
     * @param string $bar
     * @param string $baz
     *
     * @return void
     */
    public function manualArrayTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        $array = ['foo' => $foo, 'bar' => $bar, 'baz' => $baz];

        (string) view('benchmark.stubs.foo-bar-baz', $array);
    }
}
