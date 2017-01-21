--TEST--
ErrorHandler::notify() converts non-exception to exception
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

AsyncInterop\Promise\ErrorHandler::notify(42);

?>
--EXPECTF--
Fatal error: An exception has been thrown from an AsyncInterop\Promise::when() handler, but no handler has been registered via AsyncInterop\Promise\ErrorHandler::set(). A handler has to be registered to prevent exceptions from going unnoticed. Do NOT install an empty handler that just does nothing. If the handler is called, there is ALWAYS something wrong.

%SException%SPromise implementation called AsyncInterop\Promise\ErrorHandler::notify() with an invalid argument of type 'integer'%S in %s:%d
Stack trace:
#0 %s(%d): AsyncInterop\Promise\ErrorHandler::notify(%S)
#1 {main} in %s on line %d
