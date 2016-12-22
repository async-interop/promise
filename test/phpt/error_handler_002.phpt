--TEST--
ErrorHandler::notify() does not fatal with a handler
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

Interop\Async\Promise\ErrorHandler::set(function () { print "1"; });
Interop\Async\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECT--
1
