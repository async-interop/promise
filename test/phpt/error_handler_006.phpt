--TEST--
ErrorHandler::notify() fatals after handlers have been removed with ErrorHandler::remove()
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

$id = Interop\Async\Promise\ErrorHandler::add(function () { print "1"; });
Interop\Async\Promise\ErrorHandler::remove($id);
Interop\Async\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECTF--
Fatal error: An exception has been thrown from an Interop\Async\Promise::when handler, but no handler has been registered via Interop\Async\Promise\ErrorHandler::add. At least one handler has to be registered to prevent exceptions from going unnoticed. Do NOT install an empty handler that just does nothing. If the handler is called, there is ALWAYS something wrong.

%s in %s:%d
Stack trace:
#0 {main} in %s on line %d