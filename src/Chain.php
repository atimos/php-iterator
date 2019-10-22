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
        return $this->inner->next()->orElse($this->other->next());
    }
}
