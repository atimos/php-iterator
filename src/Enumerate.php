<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\{Option, Some};

class Enumerate implements Iter
{
    use IterImpl;

    /** @var Iter */
    private $inner;
    /** @var int */
    private $idx;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->idx = 0;
    }

    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            $item = Some::create([$this->idx, $item->get()]);
        }

        $this->idx += 1;
        return $item;
    }
}
