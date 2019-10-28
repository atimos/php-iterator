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

    public function mapCopy(callable $mapper): CopyMap
    {
        return new CopyMap($this, $mapper);
    }

    public function filter(callable $filter): Filter
    {
        return new Filter($this, $filter);
    }

    public function filterCopy(callable $filter): Filter
    {
        return new Filter($this->map('DeepCopy\deep_copy'), $filter);
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

    public function skipWhileCopy(callable $skipWhile): SkipWhile
    {
        return new SkipWhile($this->map('DeepCopy\deep_copy'), $skipWhile);
    }

    public function take(int $take): Take
    {
        return new Take($this, $take);
    }

    public function takeWhile(callable $takeWhile): TakeWhile
    {
        return new TakeWhile($this, $takeWhile);
    }

    public function takeWhileCopy(callable $takeWhile): TakeWhile
    {
        return new TakeWhile($this->map('DeepCopy\deep_copy'), $takeWhile);
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

    public function cycleCopy(): CopyCycle
    {
        return new CopyCycle($this);
    }

    public function fuse(): Fuse
    {
        return new Fuse($this);
    }

    public function inspect(callable $inspect): Inspector
    {
        return new Inspector($this, $inspect);
    }

    public function inspectCopy(callable $inspect): Inspector
    {
        return new Inspector($this->map('DeepCopy\deep_copy'), $inspect);
    }

    /** @psalm-suppress PossiblyUnusedMethod */
    public function getIterator(): Traversable
    {
        return new StdIterator($this);
    }

    /** @psalm-suppress PossiblyUnusedMethod */
    public function getIteratorCopy(): Traversable
    {
        return new StdIterator($this->map('DeepCopy\deep_copy'));
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

    public function findCopy(callable $find): Option
    {
        return find($this->map('DeepCopy\deep_copy'), $find);
    }

    /** @return Option<int> */
    public function position(callable $find): Option
    {
        return position($this, $find);
    }

    /** @return Option<int> */
    public function positionCopy(callable $find): Option
    {
        return position($this->map('DeepCopy\deep_copy'), $find);
    }

    public function fold($init, callable $fold)
    {
        return fold($this, $init, $fold);
    }

    public function foldCopy($init, callable $fold)
    {
        return fold_copy($this, $init, $fold);
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

    public function allCopy(callable $all): bool
    {
        return all($this->map('DeepCopy\deep_copy'), $all);
    }

    public function any(callable $any): bool
    {
        return any($this, $any);
    }

    public function anyCopy(callable $any): bool
    {
        return any($this->map('DeepCopy\deep_copy'), $any);
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

    public function forEachCopy(callable $forEach): void
    {
        for_each($this->map('DeepCopy\deep_copy'), $forEach);
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
