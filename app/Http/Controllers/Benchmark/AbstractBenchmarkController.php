<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use const true;
use function microtime, rtrim, sprintf;

/**
 * Class AbstractBenchmarkController
 *
 * @package App\Http\Controllers\Benchmark
 */
abstract class AbstractBenchmarkController extends Controller
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * AbstractBenchmarkController constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return mixed
     */
    abstract public function test();

    /**
     * @param string $method
     * @param array $args
     *
     * @return string
     */
    protected function runTest(string $method, array $args = []): string
    {
        $start = microtime(true);

        $this->{$method}(...$args);

        return rtrim(sprintf('%.20f', microtime(true) - $start), '0');
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    protected function getTests(): array
    {
        $methods = [];

        $reflection = new ReflectionClass($this);

        foreach ($reflection->getMethods() as $method) {
            if (Str::endsWith($method->getName(), 'Test')) {
                $methods[] = $method->getName();
            }
        }

        return $methods;
    }

    /**
     * @param array $array
     *
     * @return string
     */
    protected function avg(array $array): string
    {
        return rtrim(sprintf('%.20f', array_sum($array) / count($array)), '0');
    }
}
