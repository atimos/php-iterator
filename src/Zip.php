<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{None, Option, Some};

/** @template I */
class Zip implements Iter
{
    use IterImpl;

    /** @var Iter<I> */
    private $first;
    /** @var Iter<I> */
    private $second;

    public function __construct(Iter $first, Iter $second)
    {
        $this->first = $first;
        $this->second = $second;
    }

    /** @return Option<I> */
    public function next(): Option
    {
        $firstItem = $this->first->next();
        $secondItem = $this->second->next();

        if ($firstItem->isDefined() && $secondItem->isDefined()) {
            return Some::create([
                $firstItem->get(),
                $secondItem->get(),
            ]);
        }

        return None::create();
    }
}
