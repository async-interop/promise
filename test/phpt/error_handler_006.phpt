--TEST--
ErrorHandler::notify() fatals if handler throws
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

AsyncInterop\Promise\ErrorHandler::set(function ($e) { throw $e; });
AsyncInterop\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECTF--
Fatal error: An exception has been thrown from the promise error handler registered to AsyncInterop\Promise\ErrorHandler::set().

%s in %s:%d
Stack trace:
#0 {main} in %s on line %d
