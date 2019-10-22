<?php

declare(strict_types=1);

namespace Iter;

use IteratorAggregate;
use PhpOption\Option;
use Traversable;

/**
 * @template T
 */
interface Iter extends IteratorAggregate
{
    /** @return Option<T> */
    public function next(): Option;

    /**
     * @return Option<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function last(): Option;

    /**
     * @return Option<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function nth(int $nth): Option;

    /**
     * @return Option<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function find(callable $find): Option;

    /**
     * @return Option<int>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function position(callable $find): Option;

    /**
     * @return Peekable<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function peekable(): Peekable;

    /**
     * @return Enumerate<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function enumerate(): Enumerate;

    /**
     * @template U
     * @param callable(T):U $mapper
     * @return Map<U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function map(callable $mapper): Map;

    /**
     * @param callable(T):bool $filter
     * @return Filter<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function filter(callable $filter): Filter;

    /**
     * @return StepBy<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function stepBy(int $step): StepBy;

    /**
     * @return Skip<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function skip(int $skip): Skip;

    /**
     * @param callable(T):bool $skipWhile
     * @return SkipWhile<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function skipWhile(callable $skipWhile): SkipWhile;

    /**
     * @return Take<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function take(int $take): Take;

    /**
     * @param callable(T):bool $takeWhile
     * @return TakeWhile<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function takeWhile(callable $takeWhile): TakeWhile;

    /**
     * @template U
     * @param Iter<U> $other
     * @return Zip<T, U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function zip(Iter $other): Zip;

    /**
     * @template U
     * @param Iter<U> $other
     * @return Chain<T, U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function chain(Iter $other): Chain;

    /**
     * @return Cycle<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function cycle(): Cycle;

    /**
     * @return Fuse<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function fuse(): Fuse;

    /**
     * @template U
     * @param U $init
     * @param callable(U, T):U $fold
     * @return U
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function fold($init, callable $fold);

    /** @psalm-suppress PossiblyUnusedMethod */
    public function count(): int;

    /**
     * @param callable(T):bool $all
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function all(callable $all): bool;

    /**
     * @param callable(T):bool $any
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function any(callable $any): bool;

    /**
     * @return Option<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function max(): Option;

    /**
     * @return Option<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function min(): Option;

    /**
     * @param callable(T):void $inspect
     * @return Inspector<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function inspect(callable $inspect): Inspector;

    /**
     * @param callable(T):void $forEach
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function forEach(callable $forEach): void;

    /**
     * @return Traversable<T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getIterator(): Traversable;

    /**
     * @return array<int, T>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function toArray(): array;

    /**
     * @return array<mixed, mixed>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function toAssocArray(): array;
}
