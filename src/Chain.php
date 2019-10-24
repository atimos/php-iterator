<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;

/** @template I */
class Chain implements Iter
{
    use IterImpl;

    /** @var Iter<I> */
    private $inner;
    /** @var Iter<I> */
    private $other;

    public function __construct(Iter $inner, Iter $other)
    {
        $this->inner = $inner;
        $this->other = $other;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isEmpty()) {
            $item = $this->other->next();
        }

        return $item;
    }
}
