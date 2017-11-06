<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Arr;
use Illuminate\View\View as LaravelView;
use View as ViewFacade;

/**
 * Class View
 *
 * @package App\Http\Controllers\Benchmark
 */
class View extends BenchmarkController
{
    /**
     * @return LaravelView
     * @throws \ReflectionException
     */
    public function test(): LaravelView
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

    /**
     * @return void
     */
    public function viewHelperTest()
    {
        view('index');
    }

    /**
     * @return void
     */
    public function viewFacadeTest()
    {
        \Illuminate\Support\Facades\View::make('index');
    }

    /**
     * @return void
     */
    public function viewFacadeAliasTest()
    {
        ViewFacade::make('index');
    }
}
