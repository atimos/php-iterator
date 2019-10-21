<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

class StepBy implements Iter
{
    use IterImpl;

    /** @var int */
    private $step;
    /** @var Iter */
    private $inner;
    /** @var bool */
    private $firstReturned;

    public function __construct(Iter $inner, int $step)
    {
        $this->step = $step;
        $this->inner = $inner;
        $this->firstReturned = false;
    }

    public function next(): Option
    {
        $step = $this->step - 1;
        $item = $this->inner->next();

        if (!$this->firstReturned) {
            $this->firstReturned = true;
            return $item;
        }

        while ($item->isDefined()) {
            if ($step <= 0) {
                return $item;
            }
            $step -= 1;
            $item = $this->inner->next();
        }

        return $item;
    }
}
