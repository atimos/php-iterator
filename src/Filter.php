<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;

use function DeepCopy\deep_copy;

/** @template I */
class Filter implements Iter
{
    use IterImpl;

    /** @var callable(I):bool */
    private $filter;
    /** @var Iter<I> */
    private $inner;

    public function __construct(Iter $inner, callable $filter)
    {
        $this->filter = $filter;
        $this->inner = $inner;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        $item = $this->inner->next();

        while ($item->isDefined()) {
            if (($this->filter)(deep_copy($item->get()))) {
                return $item;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
