<?php

declare(strict_types=1);

namespace App\Benchmarks;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;

/**
 * Class StringJoins
 *
 * @package App\Benchmark
 */
class StringJoins extends Benchmark
{
    /**
     * @return \Illuminate\View\View
     *
     * @throws \ReflectionException
     */
    public function test(): View
    {
        return ViewFacade::make('benchmark.default', [
            'results' => $this->runTests([Str::random(255), Str::random(255)]),
        ]);
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function concatenationTest(string $one, string $two)
    {
        return $one.$two;
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function interpolationWithEscapingTest(string $one, string $two)
    {
        return "{$one}{$two}";
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function interpolationWithoutEscapingTest(string $one, string $two)
    {
        return "$one$two";
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function sprintfWithoutBackslashTest(string $one, string $two)
    {
        return sprintf('%s%s', $one, $two);
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function sprintfWithBackslashTest(string $one, string $two)
    {
        return \sprintf('%s%s', $one, $two);
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function implodeWithoutBackslashTest(string $one, string $two)
    {
        return implode('', [$one, $two]);
    }

    /**
     * @param string $one
     * @param string $two
     *
     * @return string
     */
    public function implodeWithBackslashTest(string $one, string $two)
    {
        return \implode('', [$one, $two]);
    }
}
