<?php

declare(strict_types=1);

namespace Iter;

use ArrayIterator;
use PhpOption\{None, Option, Some};

class IterableKeyIter implements Iter
{
    use IterImpl;

    /** @var iterable<mixed> */
    private $inner;

    /** @param iterable<mixed> $inner */
    public function __construct(iterable $inner)
    {
        if (is_array($inner)) {
            $inner = new ArrayIterator($inner);
        }
        $this->inner = $inner;
    }

    public function next(): Option
    {
        if (!$this->inner->valid()) {
            return None::create();
        }
        $key = $this->inner->key();
        $this->inner->next();
        return Some::create($key);
    }
}
