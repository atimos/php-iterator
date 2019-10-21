<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

class Inspector implements Iter
{
    use IterImpl;

    /** @var callable */
    private $inspect;
    /** @var Iter */
    private $inner;

    public function __construct(Iter $inner, callable $inspect)
    {
        $this->inspect = $inspect;
        $this->inner = $inner;
    }

    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            ($this->inspect)(cloneOption($item)->get());
        }

        return $item;
    }
}
