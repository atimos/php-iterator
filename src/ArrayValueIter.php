<?php declare(strict_types=1);
namespace Iterator;

class ArrayValueIter implements Iterator
{
    use IteratorImpl;

    private $inner;

    public function __construct(array $inner)
    {
        $this->inner = $inner;
    }

    public function next() : Item
    {
        if (key($this->inner) === null) {
            return Item::createEmpty();
        }

        $value = current($this->inner);
        next($this->inner);

        return Item::createFromValue($value);
    }
}
