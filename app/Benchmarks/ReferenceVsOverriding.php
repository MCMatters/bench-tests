<?php

declare(strict_types=1);

namespace App\Benchmarks;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

use function range, str_pad;

/**
 * Class ReferenceVsOverriding
 *
 * @package App\Benchmarks
 */
class ReferenceVsOverriding extends Benchmark
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \ReflectionException
     */
    public function test(): View
    {
        return ViewFacade::make('benchmark.default', [
            'results' => $this->runTests([range(0, 10000)]),
        ]);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function referenceTest(array $data)
    {
        $changingData = $data;

        $this->reference($changingData);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function overridingTest(array $data)
    {
        $data = $this->overriding($data);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    protected function reference(array &$data)
    {
        foreach ($data as $key => $item) {
            $data[$key] = str_pad((string) $item, 2);
        }
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function overriding(array $data): array
    {
        foreach ($data as $key => $item) {
            $data[$key] = str_pad((string) $item, 2);
        }

        return $data;
    }
}
