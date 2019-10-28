<?php

declare(strict_types=1);

namespace LazyIter;

use IteratorAggregate;
use PhpOption\Option;
use Traversable;
use countable;

/**
 * @template I
 */
interface Iter extends IteratorAggregate, countable
{
    /** @return Option<I> */
    public function next(): Option;

    /**
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function last(): Option;

    /**
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function nth(int $nth): Option;

    /**
     * @param callable(I):bool $find
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function find(callable $find): Option;

    /**
     * @param callable(I):bool $find
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function findCopy(callable $find): Option;

    /**
     * @return Option<int>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function position(callable $find): Option;

    /**
     * @return Option<int>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function positionCopy(callable $find): Option;

    /**
     * @return Peekable<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function peekable(): Peekable;

    /**
     * @return Enumerate<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function enumerate(): Enumerate;

    /**
     * @template U
     * @param callable(I):U $mapper
     * @return Map<U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function map(callable $mapper): Map;

    /**
     * @template U
     * @param callable(I):U $mapper
     * @return CopyMap<U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function mapCopy(callable $mapper): CopyMap;

    /**
     * @param callable(I):bool $filter
     * @return Filter<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function filter(callable $filter): Filter;

    /**
     * @param callable(I):bool $filter
     * @return Filter<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function filterCopy(callable $filter): Filter;

    /**
     * @return StepBy<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function stepBy(int $step): StepBy;

    /**
     * @return Skip<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function skip(int $skip): Skip;

    /**
     * @param callable(I):bool $skipWhile
     * @return SkipWhile<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function skipWhile(callable $skipWhile): SkipWhile;

    /**
     * @param callable(I):bool $skipWhile
     * @return SkipWhile<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function skipWhileCopy(callable $skipWhile): SkipWhile;

    /**
     * @return Take<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function take(int $take): Take;

    /**
     * @param callable(I):bool $takeWhile
     * @return TakeWhile<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function takeWhile(callable $takeWhile): TakeWhile;

    /**
     * @param callable(I):bool $takeWhile
     * @return TakeWhile<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function takeWhileCopy(callable $takeWhile): TakeWhile;

    /**
     * @template U
     * @param Iter<U> $other
     * @return Zip<I, U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function zip(Iter $other): Zip;

    /**
     * @template U
     * @param Iter<U> $other
     * @return Chain<I, U>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function chain(Iter $other): Chain;

    /**
     * @return Cycle<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function cycle(): Cycle;

    /**
     * @return CopyCycle<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function cycleCopy(): CopyCycle;

    /**
     * @return Fuse<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function fuse(): Fuse;

    /**
     * @param callable(I):void $inspect
     * @return Inspector<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function inspect(callable $inspect): Inspector;

    /**
     * @param callable(I):void $inspect
     * @return Inspector<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function inspectCopy(callable $inspect): Inspector;

    /**
     * @template R
     * @param R $init
     * @param callable(R, I):R $fold
     * @return R
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function fold($init, callable $fold);

    /**
     * @template R
     * @param R $init
     * @param callable(R, I):R $fold
     * @return R
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function foldCopy($init, callable $fold);

    /** @psalm-suppress PossiblyUnusedMethod */
    public function count(): int;

    /**
     * @param callable(I):bool $all
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function all(callable $all): bool;

    /**
     * @param callable(I):bool $all
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function allCopy(callable $all): bool;

    /**
     * @param callable(I):bool $any
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function any(callable $any): bool;

    /**
     * @param callable(I):bool $any
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function anyCopy(callable $any): bool;

    /**
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function max(): Option;

    /**
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function min(): Option;

    /**
     * @param callable(I):void $forEach
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function forEach(callable $forEach): void;

    /**
     * @param callable(I):void $forEach
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function forEachCopy(callable $forEach): void;

    /**
     * @return Traversable<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getIterator(): Traversable;

    /**
     * @return Traversable<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getIteratorCopy(): Traversable;

    /**
     * @return array<int, I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function toArray(): array;

    /**
     * @return array<array-key, I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function toAssocArray(): array;
}
