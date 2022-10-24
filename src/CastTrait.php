<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

use TypeError;

trait CastTrait
{
    /**
     * @template T of object
     * @phpstan-param class-string<T> $type
     * @phpstan-return $this&T
     */
    public function as(string $type): static
    {
        if (!$this instanceof $type) {
            throw new TypeError(get_class($this) . ' cannot be cast to ' . $type);
        }

        return $this;
    }
}
