<?php declare(strict_types=1);
namespace Iter;

use PhpOption\Option;

interface Iter extends \IteratorAggregate
{
    public function next() : Option;
    public function last() : Option;
    public function nth(int $nth) : Option;
    public function find(Callable $find) : Option;
    public function position(Callable $position) : Option;

    public function peekable() : Peekable;
    public function enumerate() : Enumerate;
    public function map(Callable $mapper) : Map;

    public function filter(Callable $filter) : Filter;
    public function stepBy(int $step) : StepBy;
    public function skip(int $skip) : Skip;
    public function skipWhile(Callable $skipWhile) : SkipWhile;
    public function take(int $take) : Take;
    public function takeWhile(Callable $takeWhile) : TakeWhile;

    public function zip(Iter $other) : Zip;
    public function chain(Iter $other) : Chain;
    public function cycle() : Cycle;
    public function fuse() : Fuse;

    public function fold($init, Callable $fold);
    public function count() : int;
    public function all(Callable $all) : bool;
    public function any(Callable $any) : bool;
    public function max() : Option;
    public function maxBy(Callable $maxBy) : Option;
    public function maxByKey() : Option;
    public function min() : Option;
    public function minBy(Callable $minBy) : Option;
    public function minByKey() : Option;

    public function inspect(Callable $inspect) : Inspector;
    public function forEach(Callable $forEach) : void;

    public function getIterator() : \Traversable;
    public function toArray() : array;
}
