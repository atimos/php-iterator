<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

class Chain implements Iter
{
    use IterImpl;

    private $inner;
    private $other;

    public function __construct(Iter $inner, Iter $other)
    {
        $this->inner = $inner;
        $this->other = $other;
    }

    public function next(): Option
    {
        $this->inner->next()->orElse($this->other->next());
    }
}
