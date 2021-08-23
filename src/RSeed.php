<?php

declare(strict_types=1);

namespace Softwarewisdom\PRO;

/**
 * Trait RSeed
 * @package Softwarewisdom\PRO
 */
trait RSeed
{
    /**
     * @return int
     */
    public function makeSeed(): int
    {
        list($usec, $sec) = explode(' ', microtime());
        return (int)($sec + $usec * 1000000);
    }

    /**
     * @return float
     * return a float number between 0 - 1, with 4 decimal number
     */
    public function randomFloat(): float
    {
        return mt_rand() / mt_getrandmax();
        //return round($v, 4);
    }
}
