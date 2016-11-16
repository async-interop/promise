--TEST--
ErrorHandler::notify() does call handlers in order
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

Interop\Async\Promise\ErrorHandler::add(function () { print "1"; });
Interop\Async\Promise\ErrorHandler::add(function () { print "2"; });
Interop\Async\Promise\ErrorHandler::add(function () { print "3"; });
Interop\Async\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECT--
123