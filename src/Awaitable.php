<?php

namespace Interop\Async;

/**
 * Awaitable object representing the future value of an asynchronous operation.
 */
interface Awaitable
{
    /**
     * Registers a callback to be invoked when the awaitable is resolved.
     *
     * @param callable(\Throwable|\Exception|null $exception, mixed $result) $onResolved
     *
     * @return void
     */
    public function when(callable $onResolved);
}
