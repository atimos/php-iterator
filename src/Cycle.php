<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\None;

class Cycle implements Iter
{
    use IterImpl;

    private $sourceCycle;
    private $cycle;
    private $idx;
    private $inner;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->sourceCycle = [];
        $this->cycle = [];
        $this->idx = 0;
    }

    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            array_unshift($this->sourceCycle, clone $item);
            return $item;
        }

        if (\count($this->sourceCycle) === 0) {
            return None::create();
        }

        if (\count($this->cycle) === 0) {
            $this->cycle = $this->sourceCycle;
        }

        return array_pop($this->cycle);
    }
}
