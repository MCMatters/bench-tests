<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use function array_map;

/**
 * Class CastingIntForeachVsArrayMap
 *
 * @package App\Http\Controllers\Benchmark
 */
class CastingIntForeachVsArrayMap extends BenchmarkController
{
    /**
     * @return View
     * @throws \ReflectionException
     */
    public function test(): View
    {
        $items = array_map('strval', range(0, 100000));

        $avg = [];
        $executed = [];

        for ($i = 0; $i < 100; $i++) {
            foreach ($this->getTests() as $method) {
                $executed[$this->sanitizeMethodName($method)][] = $this->runTest(
                    $method,
                    [$items]
                );
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
     * @param array $items
     *
     * @return void
     */
    public function foreachIntTest(array $items)
    {
        $data = [];

        foreach ($items as $item) {
            $data[] = (int) $item;
        }
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function foreachIntValTest(array $items)
    {
        $data = [];

        foreach ($items as $item) {
            $data[] = \intval($item);
        }
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapIntValTest(array $items)
    {
        $data = array_map('intval', $items);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapIntValBackslashTest(array $items)
    {
        $data = array_map('\intval', $items);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapCustomFunctionTest(array $items)
    {
        $data = array_map(function ($item) {
            return (int) $item;
        }, $items);
    }
}
