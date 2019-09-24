<?php declare(strict_types=1);
namespace Iter;

interface Iter extends \IteratorAggregate
{
    public function next() : Item;
    public function map(Callable $mapper) : Map;
    public function filter(Callable $filter) : Filter;
    public function zip(Iter $other) : Zip;
    public function chain(Iter $other) : Chain;
    public function inspect(Callable $callback) : Inspector;
    public function getIterator() : \Traversable;
    public function forEach(Callable $callback) : void;
    public function fold($init, Callable $callback);
    public function toArray() : array;
}
