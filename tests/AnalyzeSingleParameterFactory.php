<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity\Tests;

use DecodeLabs\Fluidity\SingleParameterFactory;
use DecodeLabs\Fluidity\SingleParameterFactoryTrait;

/**
 * @implements SingleParameterFactory<string>
 */
class AnalyzeSingleParameterFactory implements SingleParameterFactory
{
    /**
     * @use SingleParameterFactoryTrait<string>
     */
    use SingleParameterFactoryTrait;

    protected string $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }
}
