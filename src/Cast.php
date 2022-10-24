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
     * @phpstan-param class-string<T> $type
     * @phpstan-return $this&T
     */
    public function as(string $type): static;
}
