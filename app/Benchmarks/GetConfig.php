<?php

declare(strict_types=1);

namespace App\Http\Controllers\Benchmarks;

use App\Benchmarks\Benchmark;
use Config;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config as ConfigFacade;
use Illuminate\Support\Facades\View as ViewFacade;

use function app, config;

/**
 * Class GetConfig
 *
 * @package App\Http\Controllers\Benchmark
 */
class GetConfig extends Benchmark
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function test(): View
    {
        // Ensure that it is resolved.
        $this->app->make('config');

        $result = $this->runTests();

        return ViewFacade::make('benchmark.default', ['results' => $result]);
    }

    /**
     * @return void
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function appHelperTest()
    {
        app('config')->get('services');
    }

    /**
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function appMakeHelperTest()
    {
        app()->make('config')->get('services');
    }

    /**
     * @return void
     */
    public function configHelperTest()
    {
        config('services');
    }

    /**
     * @return void
     */
    public function configGetHelperTest()
    {
        config()->get('services');
    }

    /**
     * @return void
     */
    public function facadeTest()
    {
        ConfigFacade::get('services');
    }

    /**
     * @return void
     */
    public function facadeAliasTest()
    {
        Config::get('services');
    }

    /**
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function containerInstanceTest()
    {
        Container::getInstance()->make('config')->get('services');
    }

    /**
     * @return void
     */
    public function offsetApplicationTest()
    {
        $this->app['config']['services'];
    }

    /**
     * @return void
     */
    public function offsetApplicationGetTest()
    {
        $this->app['config']->get('services');
    }

    /**
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return void
     */
    public function dependencyInjectionTest(Repository $config)
    {
        $config->get('services');
    }
}
