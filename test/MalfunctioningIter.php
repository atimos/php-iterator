<?php

declare(strict_types=1);

namespace LazyIter\Test;

use LazyIter\{Iter, IterImpl};
use PhpOption\{None, Some, Option};

class MalfunctioningIter implements Iter
{
    use IterImpl;

    private $cycle;

    public function __construct()
    {
        $this->cycle = [
            Some::create(0),
            None::create(),
            Some::create(1),
        ];
    }

    public function next(): Option
    {
        $item = array_shift($this->cycle);
        if ($item === null) {
            return None::create();
        }

        return $item;
    }
}
