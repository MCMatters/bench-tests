<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use const true;
use function microtime, rtrim, sprintf;

/**
 * Class BenchmarkController
 *
 * @package App\Http\Controllers\Benchmark
 */
abstract class BenchmarkController extends Controller
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

        return $this->getFloatValue(microtime(true) - $start);
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
            $name = $method->getName();

            if ($name !== 'runTest' && Str::endsWith($name, 'Test')) {
                $methods[] = $name;
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
        return $this->getFloatValue(array_sum($array) / count($array));
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    protected function getFloatValue($value): string
    {
        return rtrim(sprintf('%.20f', $value), '0');
    }
}
