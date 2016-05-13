<?php

namespace Interop\Async\Awaitable;

/**
 * Simple interface for awaitable objects representing the future value of asynchronous operations.
 */
interface Awaitable
{
    /**
     * Calling this method without a callback will throw the exception from a failed awaitable in an uncatchable way.
     *
     * @param callable(\Throwable|\Exception $exception = null, mixed $result = null)|null $onResolved
     */
    public function when(callable $onResolved = null);
}
