<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Fluidity\Tests;

use DecodeLabs\Fluidity\Cast;
use DecodeLabs\Fluidity\CastTrait;

class AnalyzeCastTrait implements Cast
{
    use CastTrait;

    public static function getInstance(): AnalyzeCastTrait
    {
        return new ExtensionCastTrait();
    }
};

class ExtensionCastTrait extends AnalyzeCastTrait
{
    public function special(): string
    {
        return 'hello';
    }
}

$obj = AnalyzeCastTrait::getInstance()
    ->as(ExtensionCastTrait::class)
    ->special();
