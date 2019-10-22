<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\Option;

use function DeepCopy\deep_copy;

/** @template I */
class SkipWhile implements Iter
{
    use IterImpl;

    /** @var callable(I):bool */
    private $skipWhile;
    /** @var Iter<I> */
    private $inner;
    /** @var bool */
    private $found;

    public function __construct(Iter $inner, callable $skipWhile)
    {
        $this->skipWhile = $skipWhile;
        $this->inner = $inner;
        $this->found = false;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        if ($this->found) {
            return $this->inner->next();
        }
        $item = $this->inner->next();

        while ($item->isDefined()) {
            if (!($this->skipWhile)(deep_copy($item->get()))) {
                $this->found = true;
                return $item;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
