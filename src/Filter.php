<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

use function DeepCopy\deep_copy;

class Filter implements Iter
{
    use IterImpl;

    /** @var callable */
    private $filter;
    /** @var Iter */
    private $inner;

    public function __construct(Iter $inner, callable $filter)
    {
        $this->filter = $filter;
        $this->inner = $inner;
    }

    public function next(): Option
    {
        $item = $this->inner->next();

        while ($item->isDefined()) {
            if (($this->filter)(deep_copy($item->get()))) {
                return $item;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
