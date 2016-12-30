<?php

namespace AsyncInterop;

/**
 * Representation of the future value of an asynchronous operation.
 */
interface Promise
{
    /**
     * Registers a callback to be invoked when the promise is resolved.
     *
     * If the promise is already resolved, the callback MUST be executed immediately.
     *
     * @param callable(mixed $reason, mixed $value) <`$reason` shall be `null` on success, `$value` shall be `null` on failure>
     *
     * @return void
     */
    public function when(callable $onResolved);
}
