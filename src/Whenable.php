<?php

namespace Interop\Async\Whenable;

/**
 * Simple interface for whenable objects representing the future value of asynchronous operations.
 */
interface Whenable
{
    /**
     * Calling this method without a callback will throw the exception from a failed whenable in an uncatchable way.
     *
     * @param callable(\Throwable|\Exception $exception = null, mixed $result = null)|null $onResolved
     */
    public function when(callable $onResolved = null);
}
