<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\None;

class Take implements Iter
{
    use IterImpl;

    private $take;
    private $inner;

    public function __construct(Iter $inner, int $take)
    {
        $this->take = $take;
        $this->inner = $inner;
    }

    public function next(): Option
    {
        if ($this->take > 0) {
            $this->take -= 1;
            return $this->inner->next();
        }
        return None::create();
    }
}
