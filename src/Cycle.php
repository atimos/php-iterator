<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\None;

use function count;

class Cycle implements Iter
{
    use IterImpl;

    /** @var array<mixed> */
    private $sourceCycle;
    /** @var array<mixed> */
    private $cycle;
    /** @var Iter */
    private $inner;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->sourceCycle = [];
        $this->cycle = [];
    }

    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            array_unshift($this->sourceCycle, clone $item);
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
