<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Illuminate\Support\Arr;
use function range, str_pad;

/**
 * Class ReferenceVsOverriding
 *
 * @package App\Http\Controllers\Benchmark
 */
class ReferenceVsOverriding extends BenchmarkController
{
    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function test()
    {
        $data = range(0, 10000);

        $avg = [];
        $executed = [];

        for ($i = 0; $i < 100; $i++) {
            foreach ($this->getTests() as $method) {
                $executed[$this->sanitizeMethodName($method)][] = $this->runTest(
                    $method,
                    [$data]
                );
            }
        }

        foreach ($executed as $method => $results) {
            foreach ($this->getTestItems() as $item) {
                $avg[$method][$item] = $this->avg($results, $item);
            }
        }

        return view('benchmark.reference-overriding', ['avg' => Arr::sort($avg, 'time')]);
    }

    /**
     * @param array $data
     */
    protected function referenceTest(array $data)
    {
        $changingData = $data;

        $this->reference($changingData);
    }

    /**
     * @param array $data
     */
    protected function overridingTest(array $data)
    {
        $data = $this->overriding($data);
    }

    /**
     * @param $data
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
