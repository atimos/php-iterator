<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\Some;
use PhpOption\None;
use ArrayIterator;

class IterableKeyValueIter implements Iter
{
    use IterImpl;

    private $inner;

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
        $value = $this->inner->current();
        $key = $this->inner->key();
        $this->inner->next();
        return Some::create([$key, $value]);
    }
}
