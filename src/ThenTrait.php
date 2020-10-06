<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity;

use DecodeLabs\Fluidity\Then;

trait ThenTrait
{
    /**
     * Pass parent to callback
     *
     * @return $this
     */
    public function then(callable $callback): Then
    {
        $callback($this);
        return $this;
    }


    /**
     * For each value in $values, call callback with parent
     *
     * @return $this
     */
    public function thenEach(array $values, callable $callback): Then
    {
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
    public function thenIf($truth, callable $yes, callable $no = null): Then
    {
        if ($truth) {
            $yes($this, $truth);
        } elseif ($no) {
            $no($this, $truth);
        }

        return $this;
    }


    /**
     * If !$truth, call $no, otherwise call $yes
     *
     * @return $this
     */
    public function thenUnless($truth, callable $no, callable $yes = null): Then
    {
        if (!$truth) {
            $no($this, $truth);
        } elseif ($yes) {
            $yes($this, $truth);
        }

        return $this;
    }
}
