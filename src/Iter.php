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

    /** @return Option<T> */
    public function last(): Option;

    /** @return Option<T> */
    public function nth(int $nth): Option;

    /** @return Option<T> */
    public function find(callable $find): Option;

    /** @return Option<int> */
    public function position(callable $find): Option;

    /** @return Peekable<T> */
    public function peekable(): Peekable;

    /** @return Enumerate<T> */
    public function enumerate(): Enumerate;

    /**
     * @template U
     * @param callable(T):U $mapper
     * @return Map<U>
     */
    public function map(callable $mapper): Map;

    /**
     * @param callable(T):bool $filter
     * @return Filter<T>
     */
    public function filter(callable $filter): Filter;

    /**
     * @return StepBy<T>
     */
    public function stepBy(int $step): StepBy;

    /**
     * @return Skip<T>
     */
    public function skip(int $skip): Skip;

    /**
     * @param callable(T):bool $skipWhile
     * @return SkipWhile<T>
     */
    public function skipWhile(callable $skipWhile): SkipWhile;

    /**
     * @return Take<T>
     */
    public function take(int $take): Take;

    /**
     * @param callable(T):bool $takeWhile
     * @return TakeWhile<T>
     */
    public function takeWhile(callable $takeWhile): TakeWhile;

    /**
     * @template U
     * @param Iter<U> $other
     * @return Zip<T, U>
     */
    public function zip(Iter $other): Zip;

    /**
     * @template U
     * @param Iter<U> $other
     * @return Chain<T, U>
     */
    public function chain(Iter $other): Chain;

    /** @return Cycle<T> */
    public function cycle(): Cycle;

    /** @return Fuse<T> */
    public function fuse(): Fuse;

    /**
     * @template U
     * @param U $init
     * @param callable(U, T):U $fold
     * @return U
     */
    public function fold($init, callable $fold);

    public function count(): int;

    /**
     * @param callable(T):bool $all
     */
    public function all(callable $all): bool;

    /**
     * @param callable(T):bool $any
     */
    public function any(callable $any): bool;

    /** @return Option<T> */
    public function max(): Option;

    /** @return Option<T> */
    public function min(): Option;

    /**
     * @param callable(T):void $inspect
     * @return Inspector<T>
     */
    public function inspect(callable $inspect): Inspector;

    /** @param callable(T):void $forEach */
    public function forEach(callable $forEach): void;

    /** @return Traversable<T> */
    public function getIterator(): Traversable;

    /** @return array<int, T> */
    public function toArray(): array;

    /** @return array<mixed, mixed> */
    public function toAssocArray(): array;
}
