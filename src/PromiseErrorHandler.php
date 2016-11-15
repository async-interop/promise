<?php

namespace Async\Interop;

/**
 * Global error handler for promises.
 *
 * Callbacks passed to `Promise::when()` should never throw, but they might. Such errors have to be passed to this
 * global error handler to make them easily loggable. These can't be handled gracefully in any way, so we just enable
 * logging with this handler and ignore them otherwise.
 */
final class PromiseErrorHandler
{
    /** @var callable[] */
    private static $callbacks = [];

    private function __construct()
    {
        // disable construction, only static helper
    }

    /**
     * Adds a new handler that will be notified on uncaught promise resolution callback errors.
     *
     * This callback can attempt to log the error or exit the execution of the script if it sees need. It receives the
     * exception as first and only parameter.
     *
     * This callable MUST NOT throw in any case, as it's already a last chance handler. Thus it's suggested to always
     * wrap the body of your callback in a generic `try` / `catch` block.
     *
     * @return int Returns an integer identifier which allows to remove the handler again.
     */
    public static function addHandler(callable $onError)
    {
        self::$callbacks[] = $onError;
        end(self::$callbacks);
        return key(self::$callbacks);
    }

    /**
     * Removes the handler with the specified identifier.
     *
     * @return bool Returns `true` if the handler existed, `false` otherwise.
     */
    public static function removeHandler($id)
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException(sprintf(
                "The provided identifier isn't an integer, %s provided.",
                is_object($id) ? get_class($id) : gettype($id)
            ));
        }

        $exists = array_key_exists($id, self::$callbacks);
        unset(self::$callbacks[$id]);
        return $exists;
    }

    /**
     * Notifies all registered handlers, that an exception occurred.
     *
     * This method MUST be called by every promise implementation if a callback passed to `Promise::when()` throws upon
     * invocation.
     */
    public static function notify($error)
    {
        // No type declaration, because of PHP 5 + PHP 7 support.
        if (!$error instanceof \Exception && !$error instanceof \Throwable) {
            // We have this error handler specifically so we never throw from Promise::when, so it doesn't make sense to
            // throw here. We just forward a generic exception to the registered handlers.
            $error = new \Exception(sprintf(
                "Promise implementation called %s::%s with an invalid argument type: %s",
                __CLASS__,
                __METHOD__,
                is_object($error) ? get_class($error) : gettype($error)
            ));
        }

        foreach (self::$callbacks as $callback) {
            try {
                $callback($error);
            } catch (\Exception $e) {
                // ignore, we're already a last chance handler
            } catch (\Throwable $e) {
                // ignore, we're already a last chance handler
            }
        }
    }
}
