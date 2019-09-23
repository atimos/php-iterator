<?php declare(strict_types=1);
namespace Iterator;

class Chain implements Iterator
{
    use IteratorImpl;

    private $inner;
    private $other;

    public function __construct(Iterator $inner, Iterator $other)
    {
        $this->inner = $inner;
        $this->other = $other;
    }

    public function next() : Item
    {
        $innerItem = $this->inner->next();

        if ($innerItem->hasValue()) {
            return $innerItem;
        }

        return $this->other->next();
    }
}
