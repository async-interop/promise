<?php

namespace Interop\Async;

/**
 * Simple interface for awaitable objects representing the future value of asynchronous operations.
 */
interface Awaitable
{
    /**
     * Registers a callback to be invoked when the awaitable is resolved.
     *
     * @param callable(\Throwable|\Exception $exception = null, mixed $result = null) $onResolved
     *
     * @return void
     */
    public function when(callable $onResolved);
}
