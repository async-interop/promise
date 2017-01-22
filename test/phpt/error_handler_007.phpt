--TEST--
ErrorHandler::notify() fatals with a throwing error handler
--SKIPIF--
<?php if (PHP_VERSION_ID < 50600) die("Skipped: PHPUnit 5.1 required to test for STDERR output."); ?>
--FILE--
<?php

require __DIR__ . "/../../vendor/autoload.php";

set_error_handler(function () {
    throw new RuntimeException;
});

AsyncInterop\Promise\ErrorHandler::notify(new Exception);

?>
--EXPECT--
Fatal error: Uncaught exception 'RuntimeException' while trying to report a throwing AsyncInterop\Promise::when() handler gracefully.
