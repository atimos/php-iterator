<?php

namespace PhpOption;

use IteratorAggregate;

/**
 * @template T
 */
abstract class Option implements IteratorAggregate
{
    /**
     * @throws \RuntimeException
     * @return T
     */
    abstract public function get();

    /**
     * @return boolean
     */
    abstract public function isEmpty();

    /**
     * @return boolean
     */
    abstract public function isDefined();

    /**
     * @template U
     * @param callable(T):U $callable
     * @return Option<U>
     */
    abstract public function map($callable);
}

