<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;

use function DeepCopy\deep_copy;

/**
 * @template I
 * @template N
 */
class Map implements Iter
{
    use IterImpl;

    /** @var callable(I): N */
    private $map;
    /** @var Iter<I> */
    private $inner;

    public function __construct(Iter $inner, callable $map)
    {
        $this->map = $map;
        $this->inner = $inner;
    }

    /** @return Option<N> */
    public function next(): Option
    {
        return $this->inner->next()->map(
            /** @param I $item @return N */
            function ($item) {
                return ($this->map)(deep_copy($item));
            },
        );
    }
}
