<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use McMatters\Helpers\Helpers\MathHelper;
use ReflectionClass;
use ReflectionException;
use const true;
use function count, memory_get_usage, microtime, rtrim, sprintf, substr;

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
     * @return array
     */
    protected function runTest(string $method, array $args = []): array
    {
        $timeStart = microtime(true);
        $memory = memory_get_usage();

        $this->{$method}(...$args);

        return [
            'time'   => $this->getFloatValue(microtime(true) - $timeStart),
            'memory' => MathHelper::convertBytes(memory_get_usage() - $memory, 'kb'),
        ];
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
     * @param string|null $key
     *
     * @return string
     */
    protected function avg(array $array, string $key = null): string
    {
        $array = null === $key ? $array : Arr::pluck($array, $key);

        return $this->getFloatValue(array_sum($array) / count($array));
    }

    /**
     * @return array
     */
    protected function getTestItems(): array
    {
        return ['time', 'memory'];
    }

    /**
     * @param string $method
     *
     * @return string
     */
    protected function sanitizeMethodName(string $method): string
    {
        return substr($method, 0, -4);
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
