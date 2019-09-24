<?php declare(strict_types=1);
namespace Iterator;

function for_each(Iterator $iter, Callable $callback) : void
{
    $item = $iter->next();

    while ($item->hasValue()) {
        $callback($item->getValue());
        $item = $iter->next();
    }
}

function fold(Iterator $iter, $init, Callable $callback)
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
