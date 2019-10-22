<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;

/** @template I */
class Skip implements Iter
{
    use IterImpl;

    /** @var int */
    private $skip;
    /** @var Iter<I> */
    private $inner;
    /** @var int */
    private $current;

    public function __construct(Iter $inner, int $skip)
    {
        $this->skip = $skip;
        $this->inner = $inner;
        $this->current = 0;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        while ($this->current < $this->skip) {
            $this->inner->next();
            $this->current += 1;
        }
        return $this->inner->next();
    }
}
