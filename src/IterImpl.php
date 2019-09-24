<?php declare(strict_types=1);
namespace Iter;

trait IterImpl
{
    public function last() : Option { return last($this); }
    public function nth() : Option { return nth($this); }
    public function position(Callable $find) : Option { return find($this, $find); }

    public function peekable() : Peekable { return new Peekable($this); }
    public function enumerate() : Enumerate { return new Enumerate($this); }
    public function map(Callable $mapper) : Map { return new Map($this, $mapper); }

    public function filter(Callable $filter) : Filter { return new Filter($this, $filter); }
    public function stepBy(int $step) : StepBy { return new StepBy($this, $step); }
    public function skip(int $skip) : Skip { return new Skip($this); }
    public function skipWhile(Callable $skipWhile) : SkipWhile { return new SkipWhile($this, $skipWhile); }
    public function take(int $take) : Take { return new Take($this, $take); }
    public function takeWhile(Callable $takeWhile) : TakeWhile { return new TakeWhile($this, $takeWhile); }

    public function zip(Iter $other) : Zip { return new Zip($this, $other); }
    public function chain(Iter $other) : Chain { return new Chain($this, $other); }
    public function cycle() : Cycle { return new Cycle($this); }
    public function fuse() : Fuse { return new Fuse($this); }

    public function fold($init, Callable $fold) : Fold { return fold($this, $init, $fold); }
    public function count() : int { return count($this); }
    public function all(Callable $all) : bool { return all($this, $all); }
    public function any(Callable $any) : bool { return any($this, $all); }
    public function max() : Option { return max($this); }
    public function maxBy(Callable $maxBy) : Option { return maxBy($this, $maxBy); }
    public function maxByKey() : Option { return maxByKey($this); }
    public function min() : Option { return min($this); }
    public function minBy(Callable $minBy) : Option { return minBy($this, $minBy); }
    public function minByKey() : Option { return minByKey($this); }

    public function inspect(Callable $inspect) : Inspector { return new Inspector($this, $inspect); }
    public function forEach(Callable $forEach) : void { forEachItem($this, $forEach); }

    public function getIterator() : \Traversable { return new StdIterator($this); }
    public function toArray() : array { return toArray($this); }
}
