<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\{None, Option, Some};

class Peekable implements Iter
{
    use IterImpl;

    /** @var Iter */
    private $inner;
    /** @var Option */
    private $peeked;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->peeked = None::create();
    }

    public function next(): Option
    {
        if ($this->peeked->isDefined()) {
            $item = $this->peeked->get();
            $this->peeked = None::create();
            return $item;
        }

        return $this->inner->next();
    }

    public function peek(): Option
    {
        if (!$this->peeked->isDefined()) {
            $this->peeked = Some::create($this->inner->next());
        }
        return $this->peeked->get();
    }
}
