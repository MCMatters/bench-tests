<?php

declare(strict_types=1);

namespace App\Benchmarks;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Class ArrayVsCompact
 *
 * @package App\Benchmarks
 */
class ArrayVsCompact extends Benchmark
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \ReflectionException
     */
    public function test(): View
    {
        // Prevent advantage, because view has caching.
        (string) ViewFacade::make(
            'benchmark.stubs.foo-bar-baz',
            ['foo' => '', 'bar' => '', 'baz' => '']
        );

        return ViewFacade::make('benchmark.default', [
            'results' =>  $this->runTests(),
        ]);
    }

    /**
     * @param string $foo
     * @param string $bar
     * @param string $baz
     *
     * @return void
     */
    public function compactTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        (string) ViewFacade::make(
            'benchmark.stubs.foo-bar-baz',
            compact('foo', 'bar', 'baz')
        );
    }

    /**
     * @param string $foo
     * @param string $bar
     * @param string $baz
     *
     * @return void
     */
    public function compactBackslashedTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        (string) ViewFacade::make(
            'benchmark.stubs.foo-bar-baz',
            \compact('foo', 'bar', 'baz')
        );
    }

    /**
     * @param string $foo
     * @param string $bar
     * @param string $baz
     *
     * @return void
     */
    public function manualArrayTest($foo = 'foo', $bar = 'bar', $baz = 'baz')
    {
        (string) ViewFacade::make(
            'benchmark.stubs.foo-bar-baz',
            ['foo' => $foo, 'bar' => $bar, 'baz' => $baz]
        );
    }
}
