--TEST--
ErrorHandler::notify() does not fatal with a handler
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

AsyncInterop\Promise\ErrorHandler::set(function () { print "1"; });
AsyncInterop\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECT--
1
