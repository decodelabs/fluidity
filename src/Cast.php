<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

interface Cast
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return $this&T
     */
    public function as(
        string $type
    ): static;
}
