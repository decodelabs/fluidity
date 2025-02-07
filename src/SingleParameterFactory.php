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
     * @param TInput|static $value
     */
    public static function instance(
        mixed $value
    ): static;

    /**
     * @param TInput|static|null $value
     */
    public static function orNull(
        mixed $value
    ): ?static;

    /**
     * @param TInput $value
     */
    public function __construct(
        mixed $value
    );
}
