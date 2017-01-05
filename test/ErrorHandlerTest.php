<?php

namespace AsyncInterop\Promise\Test;

use AsyncInterop\Promise;

class ErrorHandlerTest extends \PHPUnit_Framework_TestCase {
    function testSetReturnsPreviousErrorHandler() {
        $old = Promise\ErrorHandler::set($f = function() {});
        $expectedF = Promise\ErrorHandler::set($old);
        $this->assertEquals($f, $expectedF);
    }
}
