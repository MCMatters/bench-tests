<?php

declare(strict_types = 1);

namespace App\Benchmarks;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View as ViewFacade;
use View as ViewFacadeAlias;

/**
 * Class View
 *
 * @package App\Benchmarks
 */
class View extends Benchmark
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \ReflectionException
     */
    public function test(): ViewContract
    {
        // Prevent advantage, because view has caching.
        (string) ViewFacade::make('index');

        return ViewFacade::make('benchmark.default', [
            'results' => $this->runTests(),
        ]);
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
    public function viewHelperBackslashedTest()
    {
        \view('index');
    }

    /**
     * @return void
     */
    public function viewFacadeTest()
    {
        ViewFacade::make('index');
    }

    /**
     * @return void
     */
    public function viewFacadeAliasTest()
    {
        ViewFacadeAlias::make('index');
    }
}
