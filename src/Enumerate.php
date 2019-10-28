<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{Option, Some};

/** @template I */
class Enumerate implements Iter
{
    use IterImpl;

    /** @var Iter<I> */
    private $inner;
    /** @var int */
    private $idx;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->idx = 0;
    }

    /** @return Option<array{0: int, 1: I}> */
    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            $item = Some::create([$this->idx, $item->get()]);
        }

        $this->idx += 1;
        return $item;
    }
}
