<?php

declare(strict_types=1);

namespace Iter;

class StdIterator implements \Iterator
{
    private $inner;
    private $item;
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

    public function current()
    {
        if (!$this->valid()) {
            throw new RuntimeException('Invalid value');
        }

        return $this->item->get();
    }

    public function key(): int
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->idx;
    }
}
