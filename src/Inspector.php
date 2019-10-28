<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;

/**
 * @template I
 */
class Inspector implements Iter
{
    use IterImpl;

    /** @var callable(I):void */
    private $inspect;
    /** @var Iter<I> */
    private $inner;

    public function __construct(Iter $inner, callable $inspect)
    {
        $this->inspect = $inspect;
        $this->inner = $inner;
    }

    public function next(): Option
    {
        return $this->inner->next() ->map(
            /** @param I $item @return I */
            function ($item) {
                ($this->inspect)($item);
                return $item;
            }
        );
    }
}
