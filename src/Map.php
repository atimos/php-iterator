<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\{Option, Some};

class Map implements Iter
{
    use IterImpl;

    /** @var callable */
    private $map;
    /** @var Iter */
    private $inner;

    public function __construct(Iter $inner, callable $map)
    {
        $this->map = $map;
        $this->inner = $inner;
    }

    public function next(): Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            $item = Some::create(($this->map)(cloneOption($item)->get()));
        }

        return $item;
    }
}
