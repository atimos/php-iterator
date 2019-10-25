<?php

declare(strict_types=1);

namespace LazyIter\Test\UnitTest;

use LazyIter\IterableIter;
use PhpOption\{Some, None};
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class FunctionsTest extends TestCase
{
    /** @test */
    public function findChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->find(function ($item) {
            $item->key = 5;
            return false;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function positionChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->position(function ($item) {
            $item->key = 5;
            return false;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function foldChangingItemShouldNotChangeSource()
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->fold(true, function ($_, $item) {
            $item->key = 4;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function foldChangingResultShouldNotChangeSource()
    {
        $result = (object) ['key' => 1];

        (new IterableIter([1]))->fold($result, function ($result) {
            $result->key = 2;
        });

        $this->assertEquals((object) ['key' => 1], $result);
    }

    /** @test */
    public function allSomeAreFalseShouldShortCircuit(): void
    {
        $iterationValues = [];

        $result = (new IterableIter([true, false, true]))->all(function ($item) use (&$iterationValues) {
            $iterationValues[] = $item;
            return $item;
        });

        $this->assertFalse($result);
        $this->assertEquals([true, false], $iterationValues);
    }

    /** @test */
    public function allChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->all(function ($item) {
            $item->key = 5;
            return true;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function anySecondIsTrueShouldShortCircuit(): void
    {
        $iterationValues = [];

        $result = (new IterableIter([false, true, false, true]))->any(function ($item) use (&$iterationValues) {
            $iterationValues[] = $item;
            return $item;
        });

        $this->assertTrue($result);
        $this->assertEquals([false, true], $iterationValues);
    }

    /** @test */
    public function anyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->any(function ($item) {
            $item->key = 5;
            return false;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function forEachChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->forEach(function ($item) {
            $item->key = 5;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }
}
