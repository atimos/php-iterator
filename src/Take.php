<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{None, Option};

/** @template I */
class Take implements Iter
{
    use IterImpl;

    /** @var int */
    private $take;
    /** @var Iter<I> */
    private $inner;

    public function __construct(Iter $inner, int $take)
    {
        $this->take = $take;
        $this->inner = $inner;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        if ($this->take > 0) {
            $this->take -= 1;
            return $this->inner->next();
        }
        return None::create();
    }
}
