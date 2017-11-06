<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Benchmark;

use App\Http\Controllers\BenchmarkController;
use Illuminate\View\View;
use const false;
use function array_filter, array_flip, explode, in_array, md5, preg_replace,
    random_bytes, substr, substr_count;

/**
 * Class InArrayVsIsset
 *
 * @package App\Http\Controllers\Benchmark
 */
class InArrayVsIsset extends BenchmarkController
{
    /**
     * @return View
     * @throws \ReflectionException
     */
    public function test(): View
    {
        $avg = [];

        $string = $this->getRandomString();

        $count = substr_count($string, ' ') + 1;
        $exploded = array_filter(explode(' ', $string));

        foreach ($this->getTests() as $method) {
            $executed[$this->sanitizeMethodName($method)][] = $this->runTest(
                $method,
                [$count, $exploded]
            );
        }

        foreach ($executed as $method => $results) {
            foreach ($this->getTestItems() as $item) {
                $avg[$method][$item] = $this->avg($results, $item);
            }
        }

        return view('benchmark.in_array-isset', ['avg' => $avg, 'count' => $count]);
    }

    /**
     * @param int $count
     * @param array $exploded
     */
    protected function inArrayTest(int $count, array $exploded)
    {
        $k = 0;

        for ($i = 0; $i < 3; $i++) {
            $search = $this->searchString();

            for ($j = 0; $j < $count; $j++) {
                if (in_array($search, $exploded, false)) {
                    $k++;
                }
            }
        }
    }

    /**
     * @param int $count
     * @param array $exploded
     */
    protected function issetTest(int $count, array $exploded)
    {
        $k = 0;
        $flip = array_flip($exploded);

        for ($i = 0; $i < 3; $i++) {
            $search = $this->searchString();

            for ($j = 0; $j < $count; $j++) {
                if (isset($flip[$search])) {
                    $k++;
                }
            }
        }
    }

    /**
     * @return string
     */
    protected function getRandomString(): string
    {
        $parts = [];

        for ($i = 0; $i < 1000; $i++) {
            $parts[] = md5(random_bytes(16));
        }

        $string = implode('1', $parts);

        return preg_replace('/\d/', ' ', $string);
    }

    /**
     * @return string
     */
    protected function searchString(): string
    {
        return substr(md5(random_bytes(16)), 0, 4);
    }
}
