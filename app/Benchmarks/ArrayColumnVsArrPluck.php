<?php

declare(strict_types=1);

namespace App\Benchmarks;

use Faker\Generator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View as ViewFacade;

use const true;

/**
 * Class ArrayColumnVsArrPluck
 *
 * @package App\Benchmark
 */
class ArrayColumnVsArrPluck extends Benchmark
{
    /**
     * @return \Illuminate\View\View
     *
     * @throws \ReflectionException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function test(): View
    {
        return ViewFacade::make('benchmark.default', [
            'results' => $this->runTests($this->getData()),
        ]);
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayColumnWithoutKeyTest(array $items)
    {
        array_column($items, 'email');
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayColumnWithKeyTest(array $items)
    {
        array_column($items, 'email', 'id');
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayColumnBackslashedWithoutKeyTest(array $items)
    {
        \array_column($items, 'email');
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrayColumnBackslashedWithKeyTest(array $items)
    {
        \array_column($items, 'email', 'id');
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrPluckWithoutKeyTest(array $items)
    {
        Arr::pluck($items, 'email');
    }

    /**
     * @param array $items
     *
     * @return void
     */
    public function arrPluckWithKeyTest(array $items)
    {
        Arr::pluck($items, 'email', 'id');
    }

    /**
     * @return array
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getData(): array
    {
        /** @var \Faker\Generator $faker */
        $faker = $this->app->make(Generator::class);

        $items = [];

        for ($i = 0; $i < 10; $i++) {
            $items[] = [
                'id' => $i,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'bio' => $faker->words(3, true),
                'email' => $faker->safeEmail,
            ];
        }

        return $items;
    }
}
