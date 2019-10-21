<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

class Skip implements Iter
{
    use IterImpl;

    /** @var int */
    private $skip;
    /** @var Iter */
    private $inner;
    /** @var int */
    private $current;

    public function __construct(Iter $inner, int $skip)
    {
        $this->skip = $skip;
        $this->inner = $inner;
        $this->current = 0;
    }

    public function next(): Option
    {
        while ($this->current < $this->skip) {
            $this->inner->next();
            $this->current += 1;
        }
        return $this->inner->next();
    }
}
