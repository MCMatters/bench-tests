<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class BenchmarkController
 *
 * @package App\Http\Controllers\Benchmark
 */
class BenchmarkController extends Controller
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param string $arg
     *
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(Application $app, string $arg)
    {
        $class = $this->getBenchThroughRoute($arg);

        return $app->make($class)->test();
    }

    /**
     * @param string $arg
     *
     * @return string
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    protected function getBenchThroughRoute(string $arg): string
    {
        $map = Config::get('benchmark.benchmarks');

        if (!isset($map[$arg])) {
            throw new BadRequestHttpException();
        }

        return $map[$arg];
    }
}
