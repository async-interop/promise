# Promise

The purpose of this specification is to provide a common interface for simple placeholder objects returned from async operations. This allows libraries and components from different vendors to create coroutines regardless of the used placeholder implementation. This specification is not designed to replace promise implementations that may be chained. Instead, this interface may be extended by promise implementations.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [RFC 2119][].

A `Promise` represents the eventual result of an asynchronous operation. Interaction with a `Promise` happens through its `when()` method, which registers a callback to receive either a `Promise`'s eventual value or the reason why the `Promise` has failed.

`Promise` is the fundamental primitive in asynchronous programming. It should be as lightweight as possible, as any cost adds up significantly.

This specification defines the absolute minimums for interoperable coroutines, which can be implemented in PHP using generators.

This specification does not deal with how to create, succeed or fail `Promise`s, as only the consumption of `Promise`s is required to be interoperable.

For further design explanations and notes, please refer to [the meta document](META.md).

## Terminology

1. _Promise_ is an object implementing `Interop\Async\Promise` and conforming to this specification.
2. _Value_ is any legal PHP value (including `null`), but not an instance of `Interop\Async\Promise`.
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

## Consumption

A `Promise` MUST implement `Interop\Async\Promise` and thus provide a `when()` method to access its current or eventual value or reason.

```php
<?php

namespace Interop\Async;

/**
 * Representation of the future value of an asynchronous operation.
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
```

The `when()` method MUST accept at least one argument:

`$callback` – A callable conforming to the following signature:

```php
function($error, $value) { /* ... */ }
```

Any implementation MUST at least provide these two parameters. The implementation MAY extend the `Promise` interface with additional parameters passed to the callback. Further arguments to `when()` MUST have default values, so `when()` can always be called with only one argument. `when()` MAY NOT return a value. `when()` MUST NOT throw exceptions bubbling up from a callback invocation.

> **NOTE:** The signature doesn't specify a type for `$error`. This is due to the new `Throwable` interface introduced in PHP 7. As this specification is PHP 5 compatible, we can use neither `Throwable` nor `Exception`.

All callbacks registered before the resolution MUST be executed in the order they were registered. Callbacks registered after the resolution MUST be executed immediately. If one of the callbacks throws an `Exception` or `Throwable`, it MUST be forwarded to `Async\Interop\Promise\ErrorHandler::notify`. The `Promise` implementation MUST then continue to call the remaining callbacks with the original parameters.

Registered callbacks MUST NOT be called from a file with strict types enabled (`declare(strict_types=1)`).

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
