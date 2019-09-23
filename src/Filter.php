<?php declare(strict_types=1);
namespace Iterator;

class Filter implements Iterator
{
    use IteratorImpl;

    private $filter;
    private $inner;

    public function __construct(Iterator $inner, Callable $filter)
    {
        $this->filter = $filter;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $item = $this->inner->next();

        while($item->hasValue()) {
            if (($this->filter)($item->getValue())) {
                break;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
