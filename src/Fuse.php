<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\None;

class Fuse implements Iter
{
    use IterImpl;

    private $inner;
    private $done;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->done = false;
    }

    public function next(): Option
    {
        if ($this->done === true) {
            return None::create();
        }

        $item = $this->inner->next();

        if ($item->isEmpty()) {
            $this->done = true;
        }

        return $item;
    }
}
