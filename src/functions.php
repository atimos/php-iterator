<?php declare(strict_types=1);
namespace Iterator;

function for_each(Iterator $iter, Callable $callback) : void
{
    $item = $this->next();

    while ($item->hasValue()) {
        $this->callback($item->getValue());
        $item = $iter->next();
    }
}

function to_array(Iterator $iter) : array
{
    $item = $this->next();
    $values = [];

    while ($item->hasValue()) {
        $values[] = $item->getValue();
        $item = $iter->next();
    }

    return $values;
}

function fold(Iterator $iter, mixed $init, Callable $callback) : mixed
{
    $item = $this->next();
    $result = $init;

    while ($item->hasValue()) {
        $result = $this->callback(clone $result, $item->getValue());
        $item = $this->next();
    }

    return $result;
}
