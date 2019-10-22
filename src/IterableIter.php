<?php

declare(strict_types=1);

namespace LazyIter;

use ArrayIterator;
use Iterator;
use PhpOption\{None, Option, Some};

/**
 * @template I
 * @psalm-suppress UnusedClass
 */
class IterableIter implements Iter
{
    use IterImpl;

    /** @var Iterator<mixed, I> */
    private $inner;

    /** @param array<mixed, I>|Iterator<mixed, I> $inner */
    public function __construct(iterable $inner)
    {
        if (is_array($inner)) {
            $inner = new ArrayIterator($inner);
        }
        $this->inner = $inner;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        if (!$this->inner->valid()) {
            return None::create();
        }
        $value = $this->inner->current();
        $this->inner->next();
        return Some::create($value);
    }
}
