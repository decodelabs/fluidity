<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

use Throwable;

/**
 * @template TInput
 */
trait SingleParameterFactoryTrait
{
    /**
     * @phpstan-param TInput $value
     */
    public static function instance(mixed $value): static
    {
        if ($value instanceof static) {
            return $value;
        }

        return new static($value);
    }

    /**
     * @phpstan-param TInput|null $value
     */
    public static function orNull(mixed $value): ?static
    {
        if ($value === null) {
            return null;
        }

        try {
            return static::instance($value);
        } catch (Throwable $e) {
            return null;
        }
    }
}
