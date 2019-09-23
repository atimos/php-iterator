<?php declare(strict_types=1);
namespace Iterator;

class ArrayKeyIter
{
    use Iterator;

    private $inner;

    public function __construct(array $inner)
    {
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $key = key($this->inner);
        if ($key === null) {
            return Item::createEmpty();
        }

        next($this->inner);

        return Item::createFromValue($key);
    }
}
