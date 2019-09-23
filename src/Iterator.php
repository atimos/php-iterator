<?php declare(strict_types=1);
namespace Iterator;

trait Iterator 
{
    abstract public function next() : Item;

    public function map(Callable $mapper) : Map
    {
        return new Map($this, $mapper);
    }

    public function filter(Callable $filter) : Filter
    {
        return new Filter($this, $filter);
    }

    public function zip(Iterator $other) : Zip
    {
        return new Zip($this, $other);
    }

    public function chain(Iterator $other) : Chain
    {
        return new Chain($this, $other);
    }

    public function inspect(Callable $callback) : Inspector
    {
        return new Inspector($this, $callback);
    }

    public function getIterator() : StdIterator
    {
        return new StdIterator($this);
    }

    public function forEach(Callable $callback) : void
    {
        for_each($this, $callback);
    }

    public function fold(mixed $init, Callable $callback) : mixed
    {
        return fold($this, $init, $callback);
    }

    public function toArray() : array
    {
        return to_array($this);
    }
}
