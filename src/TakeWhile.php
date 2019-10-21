<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\None;

class TakeWhile implements Iter
{
    use IterImpl;

    /** @var callable */
    private $takeWhile;
    /** @var Iter */
    private $inner;
    /** @var bool */
    private $done;

    public function __construct(Iter $inner, callable $takeWhile)
    {
        $this->takeWhile = $takeWhile;
        $this->inner = $inner;
        $this->done = false;
    }

    public function next(): Option
    {
        if ($this->done === true) {
            return None::create();
        }

        $item = $this->inner->next();

        if ($item->isDefined()) {
            if (!($this->takeWhile)(cloneOption($item)->get())) {
                $this->done = true;
                return None::create();
            }
        }

        return $item;
    }
}
