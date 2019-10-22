<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;

/**
 * @template T
 * @implements Iter<T>
 */
class Chain implements Iter
{
    use IterImpl;

    /** @var Iter */
    private $inner;
    /** @var Iter */
    private $other;

    public function __construct(Iter $inner, Iter $other)
    {
        $this->inner = $inner;
        $this->other = $other;
    }

    /** @return Option<T> */
    public function next(): Option
    {
        return $this->inner->next()->orElse($this->other->next());
    }
}
