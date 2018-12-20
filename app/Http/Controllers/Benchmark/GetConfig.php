<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Config;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Config as ConfigFacade;
use Illuminate\View\View;
use function app, asort, config;

/**
 * Class GetConfig
 *
 * @package App\Http\Controllers\Benchmark
 */
class GetConfig extends BenchmarkController
{
    /**
     * @var array
     */
    protected $resolvingMethods = ['*'];

    /**
     * @return View
     * @throws \ReflectionException
     */
    public function test(): View
    {
        // Ensure that it is resolved.
        $this->app->make('config');

        $executed = [];
        $avg = [];
        $tests = $this->getTests();

        for ($i = 0; $i < 100; $i++) {
            foreach ($tests as $method) {
                $executed[$this->sanitizeMethodName($method)][] = $this->runTest($method);
            }
        }

        foreach ($executed as $method => $results) {
            foreach ($this->getTestItems() as $item) {
                $avg[$method][$item] = $this->avg($results, $item);
            }
        }

        asort($avg);

        return view('benchmark.get-config', ['avg' => $avg]);
    }

    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function appHelperTest()
    {
        app('config')->get('services');
    }

    /**
     * @return void
     */
    protected function appMakeHelperTest()
    {
        app()->make('config')->get('services');
    }

    /**
     * @return void
     */
    protected function configHelperTest()
    {
        config('services');
    }

    /**
     * @return void
     */
    protected function configGetHelperTest()
    {
        config()->get('services');
    }

    /**
     * @return void
     */
    protected function facadeTest()
    {
        ConfigFacade::get('services');
    }

    /**
     * @return void
     */
    protected function facadeAliasTest()
    {
        Config::get('services');
    }

    /**
     * @return void
     */
    protected function containerInstanceTest()
    {
        Container::getInstance()->make('config')->get('services');
    }

    /**
     * @return void
     */
    protected function offsetApplicationTest()
    {
        $this->app['config']['services'];
    }

    /**
     * @return void
     */
    protected function offsetApplicationGetTest()
    {
        $this->app['config']->get('services');
    }

    /**
     * @param \Illuminate\Contracts\Cache\Repository $cache
     *
     * @return void
     */
    protected function dependencyInjectionTest(Repository $cache)
    {
        $cache->get('services');
    }
}
