# Awaitable

This document describes a few design considerations, for the main specification, refer to [the README document](README.md).

## Recommended usage of Awaitable

We are explicitly _not_ providing a chainable method, thus we are also not recommending to chain them, but rather to use coroutines in form of generators inside application code.

Coroutines solve the problem of the so-called callback hell very nicely and also allow proper usage of `try` / `catch`.

## Choice of `when()`

The specification proposes `when()` in order to only expose the most primitive common denominatior needed for interoperability, which is a simple callable to be executed after the resolution.

If implementations wish to adhere to e.g. [Promises/A+ from Javascript](https://promisesaplus.com) (which had been implemented in many PHP Promise libraries at the time of writing this specification) or implement any other methods, they still may do so; `when()` however is the fundamental interoperable primitive every `Awaitable` is guaranteed to have.

Additionally, coroutines do not use the returned `Promise` of a `then` callback, but returning a `Promise` is required by Promises/A+. Thus there's a lot of useless object creations when using Awaitables the recommended way, which isn't cheap and adds up. This conflicts with the goal of being as lightweight as possible.

## Naming

As we are not using a thenable, which is sometimes associated with the word `Promise`, we decided against using `Promise`.

Thus, `Awaitable` was a logical choice, with [HHVM already having it](https://docs.hhvm.com/hack/reference/interface/HH.Awaitable/) and PHP possibly also being some day extended to natively support an `await` keyword.

## Creation of Awaitables

Awaitable creation and managing is out of scope of this specification, as managing never shall cross library boundaries and thus does not need to be interoperable at all; each library shall resolve the Awaitable it created itself.
