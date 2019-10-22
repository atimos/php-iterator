<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{None, Option, Some};

/** @template I */
class Peekable implements Iter
{
    use IterImpl;

    /** @var Iter<I> */
    private $inner;
    /** @var Option<I> */
    private $peeked;

    public function __construct(Iter $inner)
    {
        $this->inner = $inner;
        $this->peeked = None::create();
    }

    /** @return Option<I> */
    public function next(): Option
    {
        if ($this->peeked->isDefined()) {
            $item = $this->peeked->get();
            $this->peeked = None::create();
            return $item;
        }

        return $this->inner->next();
    }

    /**
     * @return Option<I>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function peek(): Option
    {
        if (!$this->peeked->isDefined()) {
            $this->peeked = Some::create($this->inner->next());
        }
        return $this->peeked->get();
    }
}
