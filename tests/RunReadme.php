<?php

/**
 * @package Fluidity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

use DecodeLabs\Fluidity\Then;
use DecodeLabs\Fluidity\ThenTrait;

require dirname(__DIR__) . '/vendor/autoload.php';

$test = new class() implements Then {
    use ThenTrait;

    public function doThing(int $value=null) { var_dump($value); }
};

$truth = true;

$test
    ->then(function($test) {
        $test->doThing();
    })

    ->thenEach([1, 2, 3], function($test, $value) {
        // Called three times
        $test->doThing($value);
    })

    ->thenIf($truth, function($test) {
        // This gets called if($truth)
    }, function($test) {
        // This get called otherwise
    })

    ->thenUnless($truth, function($test) {
        // This gets called if(!$truth)
    }, function($test) {
        // This get called otherwise
    });
