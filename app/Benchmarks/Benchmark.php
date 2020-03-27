<?php

declare(strict_types=1);

namespace App\Benchmarks;

use App\Utilities\Timer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Illuminate\Support\Str;
use ReflectionClass;

use function count, rtrim, sprintf, substr;

/**
 * Class Benchmark
 *
 * @package App\Benchmarks
 */
abstract class Benchmark
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var \App\Utilities\Timer
     */
    protected $timer;

    /**
     * Benchmark constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->timer = new Timer();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    abstract public function test(): View;

    /**
     * @param array $args
     * @param int $count
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function runTests(array $args = [], int $count = 100): array
    {
        $result = [];
        $executed = [];

        // Run empty "noop" method for PHP initialization of the "runTest" method.
        $this->runTest('noop');

        for ($i = 0; $i < $count; $i++) {
            foreach ($this->getTests() as $method) {
                $executed[$this->sanitizeMethodName($method)][] = $this->runTest(
                    $method,
                    $args
                );
            }
        }

        foreach ($executed as $method => $results) {
            $result[] = [
                'name' => $method,
                'min' => $this->min($results),
                'max' => $this->max($results),
                'avg' => $this->avg($results),
            ];
        }

        return $result;
    }

    /**
     * @return void
     */
    public function noop(): void
    {
        // Do nothing.
    }

    /**
     * @param string $method
     * @param array $args
     *
     * @return float
     */
    protected function runTest(string $method, array $args = []): float
    {
        $this->timer->start();

        $this->app->call([$this, $method], $args);

        return $this->timer->stop();
    }

    /**
     * @return array
     *
     * @throws \ReflectionException
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
     * @param array $array
     *
     * @return string
     */
    protected function min(array $array): string
    {
        return $this->getFloatValue(min(...$array));
    }

    /**
     * @param array $array
     *
     * @return string
     */
    protected function max(array $array): string
    {
        return $this->getFloatValue(max(...$array));
    }

    /**
     * @param string $method
     *
     * @return string
     */
    protected function sanitizeMethodName(string $method): string
    {
        return Str::snake(substr($method, 0, -4));
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
