<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

use function DeepCopy\deep_copy;

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
        return $this->inner->next()
            ->map(function ($item) {
                return ($this->map)(deep_copy($item));
            });
    }
}
