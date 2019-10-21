<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

interface Iter extends \IteratorAggregate
{
    public function next(): Option;
    public function last(): Option;
    public function nth(int $nth): Option;
    public function find(callable $find): Option;
    public function position(callable $find): Option;

    public function peekable(): Peekable;
    public function enumerate(): Enumerate;
    public function map(callable $mapper): Map;

    public function filter(callable $filter): Filter;
    public function stepBy(int $step): StepBy;
    public function skip(int $skip): Skip;
    public function skipWhile(callable $skipWhile): SkipWhile;
    public function take(int $take): Take;
    public function takeWhile(callable $takeWhile): TakeWhile;

    public function zip(Iter $other): Zip;
    public function chain(Iter $other): Chain;
    public function cycle(): Cycle;
    public function fuse(): Fuse;

    public function fold($init, callable $fold);
    public function count(): int;
    public function all(callable $all): bool;
    public function any(callable $any): bool;
    public function max(): Option;
    public function min(): Option;

    public function inspect(callable $inspect): Inspector;
    public function forEach(callable $forEach): void;

    public function getIterator(): \Traversable;
    public function toArray(): array;
    public function toAssocArray(): array;
}
