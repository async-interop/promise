--TEST--
ErrorHandler::notify() fatals after handlers have been removed with ErrorHandler::set(null)
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

AsyncInterop\Promise\ErrorHandler::set(function () { print "1"; });
AsyncInterop\Promise\ErrorHandler::set(null);
AsyncInterop\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECTF--
Fatal error: An exception has been thrown from an AsyncInterop\Promise::when() handler, but no handler has been registered via AsyncInterop\Promise\ErrorHandler::set(). A handler has to be registered to prevent exceptions from going unnoticed. Do NOT install an empty handler that just does nothing. If the handler is called, there is ALWAYS something wrong.

%s in %s:%d
Stack trace:
#0 {main} in %s on line %d
