<?php

namespace PhpOption;

use IteratorAggregate;

/** @template I */
abstract class Option implements IteratorAggregate
{
    /**
     * @throws \RuntimeException
     * @return I
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
     * @template N
     * @param callable(I):N $callable
     * @return Option<N>
     */
    abstract public function map($callable);
}
