<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

/**
 * @template TInput
 */
interface SingleParameterFactory
{
    /**
     * @phpstan-param TInput $value
     */
    public static function instance(mixed $value): static;

    /**
     * @phpstan-param TInput|null $value
     */
    public static function orNull(mixed $value): ?static;

    /**
     * @phpstan-param TInput $value
     */
    public function __construct(mixed $value);
}
