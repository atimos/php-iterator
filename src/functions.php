<?php declare(strict_types=1);
namespace Iter;

function for_each(Iter $iter, Callable $callback) : void
{
    $item = $iter->next();

    while ($item->hasValue()) {
        $callback($item->getValue());
        $item = $iter->next();
    }
}

function fold(Iter $iter, $init, Callable $callback)
{
    $item = $iter->next();
    $result = $init;

    while ($item->hasValue()) {
        if (is_object($result)) {
            $result = clone $result;
        }
        $result = $callback($result, $item->getValue());
        $item = $iter->next();
    }

    return $result;
}
