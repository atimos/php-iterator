<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;
use Traversable;

trait IterImpl
{
    public function peekable(): Peekable
    {
        return new Peekable($this);
    }

    public function enumerate(): Enumerate
    {
        return new Enumerate($this);
    }

    public function map(callable $mapper): Map
    {
        return new Map($this, $mapper);
    }

    public function filter(callable $filter): Filter
    {
        return new Filter($this, $filter);
    }

    public function stepBy(int $step): StepBy
    {
        return new StepBy($this, $step);
    }

    public function skip(int $skip): Skip
    {
        return new Skip($this, $skip);
    }

    public function skipWhile(callable $skipWhile): SkipWhile
    {
        return new SkipWhile($this, $skipWhile);
    }

    public function take(int $take): Take
    {
        return new Take($this, $take);
    }

    public function takeWhile(callable $takeWhile): TakeWhile
    {
        return new TakeWhile($this, $takeWhile);
    }

    public function zip(Iter $other): Zip
    {
        return new Zip($this, $other);
    }

    public function chain(Iter $other): Chain
    {
        return new Chain($this, $other);
    }

    public function cycle(): Cycle
    {
        return new Cycle($this);
    }

    public function fuse(): Fuse
    {
        return new Fuse($this);
    }

    public function inspect(callable $inspect): Inspector
    {
        return new Inspector($this, $inspect);
    }

    /** @psalm-suppress PossiblyUnusedMethod */
    public function getIterator(): Traversable
    {
        return new StdIterator($this);
    }

    public function last(): Option
    {
        return last($this);
    }

    public function nth(int $nth): Option
    {
        return nth($this, $nth);
    }

    public function find(callable $find): Option
    {
        return find($this, $find);
    }

    /** @return Option<int> */
    public function position(callable $find): Option
    {
        return position($this, $find);
    }

    public function fold($init, callable $fold)
    {
        return fold($this, $init, $fold);
    }

    /** @psalm-suppress PossiblyUnusedMethod */
    public function count(): int
    {
        return count($this);
    }

    public function all(callable $all): bool
    {
        return all($this, $all);
    }

    public function any(callable $any): bool
    {
        return any($this, $any);
    }

    public function max(): Option
    {
        return max($this);
    }

    public function min(): Option
    {
        return min($this);
    }

    public function forEach(callable $forEach): void
    {
        for_each($this, $forEach);
    }

    /** @return array<int, mixed> */
    public function toArray(): array
    {
        return to_array($this);
    }

    /** @return array<array-key, mixed> */
    public function toAssocArray(): array
    {
        return to_assoc_array($this);
    }
}
