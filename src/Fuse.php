<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{None, Option};

/** @template I */
class Fuse implements Iter
{
    use IterImpl;

    /** @var Iter<I> */
    private $inner;
    /** @var bool */
    private $done;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->done = false;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        if ($this->done === true) {
            return None::create();
        }

        $item = $this->inner->next();

        if ($item->isEmpty()) {
            $this->done = true;
        }

        return $item;
    }
}
