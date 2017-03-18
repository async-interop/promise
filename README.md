# Promise

The purpose of this specification is to provide a common interface for simple placeholder objects returned from async operations. This allows libraries and components from different vendors to create coroutines regardless of the placeholder implementation used. This specification is not designed to replace promise implementations that may be chained. Instead, the common interface may be extended by promise implementations.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [RFC 2119][].

A `Promise` represents the eventual result of an asynchronous operation. Interaction with a `Promise` happens through its `when()` method, which registers a callback to receive either a `Promise`'s eventual value, or reason for failure.

`Promise` is the fundamental primitive in asynchronous programming. It should be as lightweight as possible, as any cost adds up significantly.

This specification defines the absolute minimum for interoperable coroutines, which can be implemented in PHP using generators.

This specification does not deal with how a `Promise` should be created, succeed, or fail, as only the consumption of `Promise` is required to be interoperable.

For further design explanations and notes, please refer to [the meta document](META.md).

## Terminology

1. _Promise_ is an object implementing `AsyncInterop\Promise` and conforming to this specification.
2. _Value_ is any legal PHP value (including `null`), but not an instance of `AsyncInterop\Promise`.
3. _Error_ is any value that can be thrown using the `throw` statement.
4. _Reason_ is an error indicating why a `Promise` has failed.

## States

A `Promise` MUST be in one of three states: `pending`, `succeeded`, `failed`.

| A promise in … state | &nbsp; |
|----------------------|--------|
|`pending`  | <ul><li>MAY transition to either the `succeeded` or `failed` state.</li></ul>                                |
|`succeeded`| <ul><li>MUST NOT transition to any other state.</li><li>MUST have a value which MUST NOT change.*</li></ul>  |
|`failed`   | <ul><li>MUST NOT transition to any other state.</li><li>MUST have a reason which MUST NOT change.*</li></ul> |

* _Must not change_ refers to the _reference_ being immutable in case of an object, _not the object itself_ being immutable.

A `Promise` is resolved once it either succeeded or failed.

## Consumption

A `Promise` MUST implement `AsyncInterop\Promise` and thus provide a `when()` method to access its value or reason.

```php
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
     * @param callable(\Throwable|\Exception|null $reason, $value) $onResolved `$reason` shall be `null` on
     *     success, `$value` shall be `null` on failure.
     *
     * @return mixed Return type and value are unspecified.
     */
    public function when(callable $onResolved);
}
```

All callbacks registered before the `Promise` is resolved MUST be executed in the order they were registered after the `Promise` has been resolved. Callbacks registered after the resolution MUST be executed immediately.

The invocation of `Promise::when()` MUST NOT throw exceptions bubbling up from an `$onResolved` invocation. If one of the callbacks throws an `Exception` or `Throwable`, the `Promise` implementation MUST catch it and call `AsyncInterop\Promise\ErrorHandler::notify()` with the `Exception` or `Throwable` as first argument. The `Promise` implementation MUST then continue to call the remaining callbacks with the original parameters.

Registered callbacks MUST NOT be called from a file with strict types enabled (`declare(strict_types=1)`).

## Error Handling

Uncaught exceptions thrown from callbacks registered to `Promise::when()` are forwarded to the `ErrorHandler` by `Promise` implementations. `ErrorHandler::set()` can be used to register a callable to handle these exceptions gracefully, e.g. by logging them. In case the handler throws again or is not set, an `E_USER_ERROR` is triggered. If a PHP error handler is set using `set_error_handler` and it throws, a short message is written to STDERR and the program exits with code `255`. Thus, it's RECOMMENDED to set an error handler and ensure it doesn't throw, especially if the PHP error handler is set up to convert errors to exceptions.

## Contributors

* [Aaron Piotrowski](https://github.com/trowski)
* [Andrew Carter](https://github.com/AndrewCarterUK)
* [Bob Weinand](https://github.com/bwoebi)
* [Cees-Jan Kiewiet](https://github.com/WyriHaximus)
* [Christopher Pitt](https://github.com/assertchris)
* [Daniel Lowrey](https://github.com/rdlowrey)
* [Niklas Keller](https://github.com/kelunik)
* [Stephen M. Coakley](https://github.com/coderstephen)

[RFC 2119]: http://tools.ietf.org/html/rfc2119
