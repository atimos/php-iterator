<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\Some;
use PhpOption\None;

class Zip implements Iter
{
    use IterImpl;

    /** @var Iter */
    private $first;
    /** @var Iter */
    private $second;

    public function __construct(Iter $first, Iter $second)
    {
        $this->first = $first;
        $this->second = $second;
    }

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
