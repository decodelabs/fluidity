<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

trait ThenTrait
{
    /**
     * Pass parent to callback
     *
     * @return $this
     */
    public function then(
        callable $callback
    ): Then {
        $callback($this);

        return $this;
    }


    /**
     * For each value in $values, call callback with parent
     *
     * @return $this
     */
    public function thenEach(
        iterable $values,
        callable $callback
    ): Then {
        foreach ($values as $key => $value) {
            $callback($this, $value, $key);
        }

        return $this;
    }


    /**
     * If $truth, call $yes, otherwise call $no
     *
     * @return $this
     */
    public function thenIf(
        ?bool $truth,
        callable $yes,
        callable $no = null
    ): Then {
        if ($truth === true) {
            $yes($this, $truth);
        } elseif (is_callable($no)) {
            $no($this, $truth);
        }

        return $this;
    }


    /**
     * If !$truth, call $no, otherwise call $yes
     *
     * @return $this
     */
    public function thenUnless(
        ?bool $truth,
        callable $no,
        callable $yes = null
    ): Then {
        if ($truth !== true) {
            $no($this, $truth);
        } elseif (is_callable($yes)) {
            $yes($this, $truth);
        }

        return $this;
    }
}
