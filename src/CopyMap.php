<?php

declare(strict_types=1);

namespace LazyIter;

class CopyMap extends Map
{
    public function __construct(Iter $inner, callable $map)
    {
        parent::__construct($inner->map('DeepCopy\deep_copy'), $map);
    }
}
