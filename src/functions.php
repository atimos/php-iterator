<?php declare(strict_types=1);
namespace Iter;

use PhpOption\Option;
use PhpOption\Some;

function forEachItem(Iter $iter, Callable $forEach) : void
{
    $item = $iter->next();

    while ($item->isDefined()) {
        $forEach(cloneOption($item)->get());
        $item = $iter->next();
    }
}

function fold(Iter $iter, $init, Callable $fold)
{
    $item = $iter->next();
    $result = $init;

    while ($item->isDefined()) {
        if (is_object($result)) {
            $result = clone $result;
        }
        $result = $fold($result, cloneOption($item)->get());
        $item = $iter->next();
    }

    return $result;
}

function cloneOption(Option $option) : Option
{
    if ($option->isDefined()) {
        $value = $option->get();
        if (is_object($value)) {
            $value = clone $value;
        }
        return Some::create($value);
    }
    return $option;
}
