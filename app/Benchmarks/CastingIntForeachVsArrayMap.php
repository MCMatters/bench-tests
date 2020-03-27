<?php

declare(strict_types=1);

namespace App\Benchmarks;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Class CastingIntForeachVsArrayMap
 *
 * @package App\Benchmarks
 */
class CastingIntForeachVsArrayMap extends Benchmark
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \ReflectionException
     */
    public function test(): View
    {
        $items = \array_map('\strval', \range(0, 100000));

        return ViewFacade::make('benchmark.default', [
            'results' => $this->runTests([$items]),
        ]);
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

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapCustomStaticFunctionTest(array $items)
    {
        $data = array_map(static function ($item) {
            return (int) $item;
        }, $items);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapBackslashedIntValTest(array $items)
    {
        $data = \array_map('intval', $items);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapBackslashedIntValBackslashTest(array $items)
    {
        $data = \array_map('\intval', $items);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapBackslashedCustomFunctionTest(array $items)
    {
        $data = \array_map(function ($item) {
            return (int) $item;
        }, $items);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayMapBackslashedCustomStaticFunctionTest(array $items)
    {
        $data = \array_map(static function ($item) {
            return (int) $item;
        }, $items);
    }
}
