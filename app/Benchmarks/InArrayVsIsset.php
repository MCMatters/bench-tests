<?php

declare(strict_types=1);

namespace App\Benchmarks;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

use function array_filter, array_flip, explode, in_array, md5, preg_replace,
    random_bytes, substr, substr_count;

use const false;

/**
 * Class InArrayVsIsset
 *
 * @package App\Benchmarks
 */
class InArrayVsIsset extends Benchmark
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function test(): View
    {
        $string = $this->getRandomString();

        $count = substr_count($string, ' ') + 1;
        $exploded = array_filter(explode(' ', $string));

        return ViewFacade::make('benchmark.in_array-isset', [
            'result' => $this->runTests([$count, $exploded], 10),
            'count' => $count,
        ]);
    }

    /**
     * @param int $count
     * @param array $exploded
     *
     * @return void
     *
     * @throws \Exception
     */
    public function inArrayTest(int $count, array $exploded)
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
     *
     * @return void
     *
     * @throws \Exception
     */
    public function issetTest(int $count, array $exploded)
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
     *
     * @throws \Exception
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
     *
     * @throws \Exception
     */
    protected function searchString(): string
    {
        return substr(md5(random_bytes(16)), 0, 4);
    }
}
