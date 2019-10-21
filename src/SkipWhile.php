<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

class SkipWhile implements Iter
{
    use IterImpl;

    /** @var callable */
    private $skipWhile;
    /** @var Iter */
    private $inner;
    /** @var bool */
    private $found;

    public function __construct(Iter $inner, callable $skipWhile)
    {
        $this->skipWhile = $skipWhile;
        $this->inner = $inner;
        $this->found = false;
    }

    public function next(): Option
    {
        if ($this->found) {
            return $this->inner->next();
        }
        $item = $this->inner->next();

        while ($item->isDefined()) {
            if (!($this->skipWhile)(cloneOption($item)->get())) {
                $this->found = true;
                return $item;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
