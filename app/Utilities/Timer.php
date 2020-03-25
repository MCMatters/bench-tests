<?php

declare(strict_types=1);

namespace App\Utilities;

use InvalidArgumentException;

use function microtime;

use const null, true;

/**
 * Class Timer
 *
 * @package App\Utilities
 */
class Timer
{
    /**
     * @var float
     */
    protected $start;

    /**
     * @return void
     */
    public function start(): void
    {
        $this->start = microtime(true);
    }

    /**
     * @return float
     *
     * @throws \InvalidArgumentException
     */
    public function slice(): float
    {
        if (null === $this->start) {
            throw new InvalidArgumentException('Timer has not started yet');
        }

        return microtime(true) - $this->start;
    }

    /**
     * @return float
     */
    public function stop(): float
    {
        $result = $this->slice();

        $this->start = null;

        return $result;
    }
}
