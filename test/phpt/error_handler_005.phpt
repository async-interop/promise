--TEST--
ErrorHandler::set() replaces the current handler
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

Interop\Async\Promise\ErrorHandler::set(function () { print "1"; });
Interop\Async\Promise\ErrorHandler::set(function () { print "2"; });
Interop\Async\Promise\ErrorHandler::set(function () { print "3"; });
Interop\Async\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECT--
3
