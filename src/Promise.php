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
     * @param callable(\Throwable|\Exception|null $exception, mixed $result) $onResolved
     *
     * @return void
     */
    public function when(callable $onResolved);
}
