<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

use function DeepCopy\deep_copy;

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
        return $this->inner->next()
            ->map(function ($item) {
                ($this->inspect)(deep_copy($item));
                return $item;
            });
    }
}
