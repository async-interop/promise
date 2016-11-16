--TEST--
ErrorHandler::notify() converts non-exception to exception
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

Interop\Async\Promise\ErrorHandler::notify(42);

?>
--EXPECTF--
Fatal error: An exception has been thrown from an Interop\Async\Promise::when handler, but no handler has been registered via Interop\Async\Promise\ErrorHandler::add. At least one handler has to be registered to prevent exceptions from going unnoticed. Do NOT install an empty handler that just does nothing. If the handler is called, there is ALWAYS something wrong.

%sPromise implementation called Interop\Async\Promise\ErrorHandler::notify with an invalid argument of type 'integer'%sin %s:%d
Stack trace:
#0 -(%d): Interop\Async\Promise\ErrorHandler::notify(42)
#1 {main} in %s on line %d