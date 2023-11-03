<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

interface Then
{
    /**
     * @return $this
     */
    public function then(
        callable $callback
    ): Then;

    /**
     * @param iterable<mixed, mixed> $values
     * @return $this
     */
    public function thenEach(
        iterable $values,
        callable $callback
    ): Then;

    /**
     * @return $this
     */
    public function thenIf(
        ?bool $truth,
        callable $yes,
        callable $no = null
    ): Then;

    /**
     * @return $this
     */
    public function thenUnless(
        ?bool $truth,
        callable $no,
        callable $yes = null
    ): Then;
}
