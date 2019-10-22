<?php

declare(strict_types=1);

namespace LazyIter;

use Generator;
use PhpOption\{None, Option, Some};

/**
 * @template I
 * @psalm-suppress UnusedClass
 */
class GeneratorIter implements Iter
{
    use IterImpl;

    /** @var Generator<I> */
    private $inner;

    /** @param callable():Generator<I> $inner */
    public function __construct(callable $inner)
    {
        $this->inner = $inner();
    }

    /** @return Option<I> */
    public function next(): Option
    {
        if (!$this->inner->valid()) {
            return None::create();
        }
        $value = $this->inner->current();
        $this->inner->next();
        return Some::create($value);
    }
}
