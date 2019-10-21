<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\Option;
use PhpOption\Some;
use PhpOption\None;

function forEachItem(Iter $iter, callable $forEach): void
{
    $item = $iter->next();

    while ($item->isDefined()) {
        $forEach(cloneOption($item)->get());
        $item = $iter->next();
    }
}

/**
 * @return mixed
 * @param mixed $init
 */
function fold(Iter $iter, $init, callable $fold)
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

function count(Iter $iter): int
{
    return nonCloneFold($iter, 0, static function ($count) {
        return $count + 1;
    });
}

function last(Iter $iter): Option
{
    return nonCloneFold($iter, None::create(), static function ($_, $item) {
        return Some::create($item);
    });
}

function nth(Iter $iter, int $nth): Option
{
    return $iter->skip($nth)->next();
}

function find(Iter $iter, callable $find): Option
{
    $item = $iter->next();

    while ($item->isDefined()) {
        if (($find)(cloneOption($item)->get())) {
            return $item;
        }
        $item = $iter->next();
    }

    return $item;
}

function position(Iter $iter, callable $find): Option
{
    $count = 0;
    $item = $iter->next();

    while ($item->isDefined()) {
        if (($find)(cloneOption($item)->get())) {
            return Some::create($count);
        }
        $count += 1;
        $item = $iter->next();
    }

    return $item;
}

function all(Iter $iter, callable $all): bool
{
    $result = false;
    $item = $iter->next();

    while ($item->isDefined()) {
        if (!($all)(cloneOption($item)->get())) {
            return false;
        }
        $result = true;
        $item = $iter->next();
    }

    return $result;
}

function any(Iter $iter, callable $any): bool
{
    $item = $iter->next();

    while ($item->isDefined()) {
        if (($any)(cloneOption($item)->get())) {
            return true;
        }
        $item = $iter->next();
    }

    return false;
}

function max(Iter $iter): Option
{
    return nonCloneFold($iter, None::create(), static function ($result, $item) {
        if ($result->isEmpty() || $result->get() < $item) {
            return Some::create($item);
        }
        return $result;
    });
}

function min(Iter $iter): Option
{
    return nonCloneFold($iter, None::create(), static function ($result, $item) {
        if ($result->isEmpty() || $result->get() > $item) {
            return Some::create($item);
        }
        return $result;
    });
}

/**
 * @return array<mixed>
 */
function toArray(Iter $iter): array
{
    return nonCloneFold($iter, [], static function ($result, $item) {
        $result[] = $item;
        return $result;
    });
}

/**
 * @return array<mixed>
 */
function toAssocArray(Iter $iter): array
{
    return nonCloneFold($iter, [], static function ($result, $item) {
        if (!is_array($item) || \count($item) !== 2) {
            throw new RuntimeException('item has to be an array with two items');
        }
        $result[$item[0]] = $item[1];
        return $result;
    });
}

function cloneOption(Option $option): Option
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

/**
 * @return mixed
 * @param mixed $init
 */
function nonCloneFold(Iter $iter, $init, callable $fold)
{
    $item = $iter->next();
    $result = $init;

    while ($item->isDefined()) {
        $result = $fold($result, $item->get());
        $item = $iter->next();
    }

    return $result;
}
