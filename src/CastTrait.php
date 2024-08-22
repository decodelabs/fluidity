<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

use TypeError;

/**
 * @phpstan-require-implements Cast
 */
trait CastTrait
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return $this&T
     */
    public function as(
        string $type
    ): static {
        if (!$this instanceof $type) {
            throw new TypeError(get_class($this) . ' cannot be cast to ' . $type);
        }

        return $this;
    }
}
