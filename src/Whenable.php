<?php

namespace Interop\Async\Whenable;

/**
 * Simple interface for whenable objects representing the future value of asynchronous operations.
 */
interface Whenable
{
    /**
     * Registers a callback to be invoked when the whenable is resolved.
     *
     * @param callable(\Throwable|\Exception $exception = null, mixed $result = null) $onResolved
     */
    public function when(callable $onResolved);
}
