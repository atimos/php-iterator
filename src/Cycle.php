<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\{None, Option};

use function count;
use function DeepCopy\deep_copy;

class Cycle implements Iter
{
    use IterImpl;

    /** @var array<int, mixed> */
    private $sourceCycle;
    /** @var array<int, mixed> */
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
