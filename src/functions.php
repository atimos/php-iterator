<?php

declare(strict_types=1);

namespace Iter;

use PhpOption\{Option, Some, None};

use function count as stdcount;
use function DeepCopy\deep_copy;

function for_each(Iter $iter, callable $forEach): void
{
    $item = $iter->next();

    while ($item->isDefined()) {
        $forEach(deep_copy($item->get()));
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
        $result = $fold(deep_copy($result), deep_copy($item->get()));
        $item = $iter->next();
    }

    return $result;
}

function count(Iter $iter): int
{
    return non_copy_fold($iter, 0, static function ($count) {
        return $count + 1;
    });
}

function last(Iter $iter): Option
{
    return non_copy_fold($iter, None::create(), static function ($_, $item) {
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
        if (($find)(deep_copy($item->get()))) {
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
        if (($find)(deep_copy($item->get()))) {
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
        if (!($all)(deep_copy($item->get()))) {
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
        if (($any)(deep_copy($item->get()))) {
            return true;
        }
        $item = $iter->next();
    }

    return false;
}

function max(Iter $iter): Option
{
    return non_copy_fold($iter, None::create(), static function ($result, $item) {
        if ($result->isEmpty() || $result->get() < $item) {
            return Some::create($item);
        }
        return $result;
    });
}

function min(Iter $iter): Option
{
    return non_copy_fold($iter, None::create(), static function ($result, $item) {
        if ($result->isEmpty() || $result->get() > $item) {
            return Some::create($item);
        }
        return $result;
    });
}

/**
 * @return array<mixed>
 */
function to_array(Iter $iter): array
{
    return non_copy_fold($iter, [], static function ($result, $item) {
        $result[] = $item;
        return $result;
    });
}

/**
 * @return array<mixed>
 */
function to_assoc_array(Iter $iter): array
{
    return non_copy_fold($iter, [], static function ($result, $item) {
        if (!is_array($item) || stdcount($item) !== 2) {
            throw new RuntimeException('item has to be an array with two items');
        }
        $result[$item[0]] = $item[1];
        return $result;
    });
}

/**
 * @return mixed
 * @param mixed $init
 */
function non_copy_fold(Iter $iter, $init, callable $fold)
{
    $item = $iter->next();
    $result = $init;

    while ($item->isDefined()) {
        $result = $fold($result, $item->get());
        $item = $iter->next();
    }

    return $result;
}
