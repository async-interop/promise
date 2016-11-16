--TEST--
ErrorHandler::notify() fatals after handlers have been removed with ErrorHandler::reset()
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

Interop\Async\Promise\ErrorHandler::add(function () { print "1"; });
Interop\Async\Promise\ErrorHandler::reset();
Interop\Async\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECTF--
Fatal error: An exception has been thrown from an Interop\Async\Promise::when handler, but no handler has been registered via Interop\Async\Promise\ErrorHandler::add. At least one handler has to be registered to prevent exceptions from going unnoticed. Do NOT install an empty handler that just does nothing. If the handler is called, there is ALWAYS something wrong.

Exception in -:%d
Stack trace:
#0 {main} in %s on line %d