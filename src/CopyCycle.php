<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{None, Option};

use function count;
use function DeepCopy\deep_copy;

/** @template I */
class CopyCycle implements Iter
{
    use IterImpl;

    /** @var array<int, I> */
    private $sourceCycle;
    /** @var array<int, I> */
    private $cycle;
    /** @var Iter<I> */
    private $inner;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->sourceCycle = [];
        $this->cycle = [];
    }

    /** @return Option<I> */
    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            array_unshift($this->sourceCycle, deep_copy($item));
            return $item;
        }

        if (count($this->sourceCycle) === 0) {
            return None::create();
        }

        if (count($this->cycle) === 0) {
            $this->cycle = $this->sourceCycle;
        }

        return array_pop($this->cycle);
    }
}
