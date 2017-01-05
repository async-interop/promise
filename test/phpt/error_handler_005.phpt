--TEST--
ErrorHandler::set() replaces the current handler
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

AsyncInterop\Promise\ErrorHandler::set(function () { print "1"; });
AsyncInterop\Promise\ErrorHandler::set(function () { print "2"; });
AsyncInterop\Promise\ErrorHandler::set(function () { print "3"; });
AsyncInterop\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECT--
3
