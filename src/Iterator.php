<?php declare(strict_types=1);
namespace Iterator;

interface Iterator extends \IteratorAggregate
{
    public static function from(\Traversable $iter) : Iterator;
    public function next() : Item;
    public function map(Callable $mapper) : Map;
    public function filter(Callable $filter) : Filter;
    public function zip(Iterator $other) : Zip;
    public function chain(Iterator $other) : Chain;
    public function inspect(Callable $callback) : Inspector;
    public function getIterator() : \Traversable;
    public function forEach(Callable $callback) : void;
    public function fold($init, Callable $callback);
    public function toArray() : array;
}
