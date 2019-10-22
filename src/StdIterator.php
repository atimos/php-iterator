<?php

declare(strict_types=1);

namespace LazyIter;

use Iterator;
use PhpOption\Option;

/** @template I */
class StdIterator implements Iterator
{
    /** @var Iter<I> */
    private $inner;
    /** @var Option<I> */
    private $item;
    /** @var int */
    private $idx = 0;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->item = $inner->next();
    }

    public function rewind(): void
    {
    }

    public function next(): void
    {
        $this->idx += 1;
        $this->item = $this->inner->next();
    }

    public function valid(): bool
    {
        return $this->item->isDefined();
    }

    /** @return Option<I> */
    public function current()
    {
        assert($this->valid());

        return $this->item->get();
    }

    public function key(): ?int
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->idx;
    }
}
