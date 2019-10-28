<?php

declare(strict_types=1);

namespace LazyIter;

use PhpOption\{Option, Some, None};

use function count as std_count;
use function DeepCopy\deep_copy;

/**
 * @template I
 * @param Iter<I> $iter
 * @param callable(I):void $forEach
 */
function for_each(Iter $iter, callable $forEach): void
{
    $item = $iter->next();

    while ($item->isDefined()) {
        $forEach($item->get());
        $item = $iter->next();
    }
}

/**
 * @template I
 * @template R
 * @param Iter<I> $iter
 * @param R $init
 * @param callable(R, I):R $fold
 * @return R
 */
function fold(Iter $iter, $init, callable $fold)
{
    $item = $iter->next();
    $result = $init;

    while ($item->isDefined()) {
        $result = $fold($result, $item->get());
        $item = $iter->next();
    }

    return $result;
}

/**
 * @template I
 * @template R
 * @param Iter<I> $iter
 * @param R $init
 * @param callable(R, I):R $fold
 * @return R
 */
function fold_copy(Iter $iter, $init, callable $fold)
{
    $item = $iter->next();
    $result = $init;

    while ($item->isDefined()) {
        $result = $fold(deep_copy($result), deep_copy($item->get()));
        $item = $iter->next();
    }

    return $result;
}

/**
 * @template I
 * @param Iter<I> $iter
 */
function count(Iter $iter): int
{
    return fold($iter, 0, static function (int $count): int {
        return $count + 1;
    });
}

/**
 * @template I
 * @param Iter<I> $iter
 * @return Option<I>
 */
function last(Iter $iter): Option
{
    return fold(
        $iter,
        None::create(),
        /**
         * @template I
         * @param Option<I> $_
         * @param I $item
         * @return Option<I>
         */
        static function ($_, $item) {
            return Some::create($item);
        }
    );
}

/**
 * @template I
 * @param Iter<I> $iter
 * @return Option<I>
 */
function nth(Iter $iter, int $nth): Option
{
    return $iter->skip($nth)->next();
}

/**
 * @template I
 * @param Iter<I> $iter
 * @param callable(I):bool $find
 * @return Option<I>
 */
function find(Iter $iter, callable $find): Option
{
    $item = $iter->next();

    while ($item->isDefined()) {
        if (($find)($item->get())) {
            return $item;
        }
        $item = $iter->next();
    }

    return $item;
}

/**
 * @template I
 * @param Iter<I> $iter
 * @param callable(I):bool $find
 * @return Option<int>
 */
function position(Iter $iter, callable $find): Option
{
    $count = 0;
    $item = $iter->next();

    while ($item->isDefined()) {
        if (($find)($item->get())) {
            return Some::create($count);
        }
        $count += 1;
        $item = $iter->next();
    }

    return $item;
}

/**
 * @template I
 * @param Iter<I> $iter
 * @param callable(I):bool $all
 */
function all(Iter $iter, callable $all): bool
{
    $result = false;
    $item = $iter->next();

    while ($item->isDefined()) {
        if (!($all)($item->get())) {
            return false;
        }
        $result = true;
        $item = $iter->next();
    }

    return $result;
}

/**
 * @template I
 * @param Iter<I> $iter
 * @param callable(I):bool $any
 */
function any(Iter $iter, callable $any): bool
{
    $item = $iter->next();

    while ($item->isDefined()) {
        if (($any)($item->get())) {
            return true;
        }
        $item = $iter->next();
    }

    return false;
}

/**
 * @template I
 * @param Iter<I> $iter
 * @return Option<I>
 */
function max(Iter $iter): Option
{
    return fold(
        $iter,
        None::create(),
        /**
         * @template I
         * @param Option<I> $result
         * @param I $item
         * @return Option<I>
         */
        static function ($result, $item) {
            if ($result->isEmpty() || $result->get() < $item) {
                return Some::create($item);
            }
            return $result;
        }
    );
}

/**
 * @template I
 * @param Iter<I> $iter
 * @return Option<I>
 */
function min(Iter $iter): Option
{
    return fold(
        $iter,
        None::create(),
        /**
         * @template I
         * @param Option<I> $result
         * @param I $item
         * @return Option<I>
         */
        static function ($result, $item) {
            if ($result->isEmpty() || $result->get() > $item) {
                return Some::create($item);
            }
            return $result;
        }
    );
}

/**
 * @template I
 * @param Iter<I> $iter
 * @return array<I>
 */
function to_array(Iter $iter): array
{
    return fold(
        $iter,
        [],
        /**
         * @template I
         * @param array<I> $result
         * @param I $item
         * @return array<I>
         */
        static function ($result, $item) {
            $result[] = $item;
            return $result;
        }
    );
}

/**
 * @template V
 * @param Iter<array{0: array-key, 1: V}> $iter
 * @return array<array-key, V>
 */
function to_assoc_array(Iter $iter): array
{
    return fold(
        $iter,
        [],
        /**
         * @template V
         * @param array<array-key, V> $result
         * @param array{0: array-key, 1: V} $item
         * @return array<array-key, V>
         */
        static function ($result, $item) {
            $result[$item[0]] = $item[1];
            return $result;
        }
    );
}
