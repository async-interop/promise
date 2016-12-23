<?php

namespace Interop\Async;

/**
 * Promise object representing the future value of an asynchronous operation.
 */
interface Promise
{
    /**
     * Registers a callback to be invoked when the promise is resolved.
     *
     * The callback receives `null` as first parameter and `$value` as second parameter on success. It receives the
     * failure reason as first parameter and `null` as second parameter on failure.
     *
     * If the promise is already resolved, the callback MUST be executed immediately.
     *
     * Warning: If you use type declarations for `$value`, be sure to make them accept `null` in case of failures.
     *
     * @param callable(\Throwable|\Exception|null $exception, mixed $value) $onResolved Callback to be executed.
     *
     * @return void
     */
    public function when(callable $onResolved);
}
