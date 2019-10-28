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
    public function findCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->findCopy(function ($item) {
            $item->key = 5;
            return false;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function positionCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->positionCopy(function ($item) {
            $item->key = 5;
            return false;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function foldCopyChangingItemShouldNotChangeItems()
    {
        $source = [(object) ['key' => 1]];
        $result = (object) ['key' => 1];

        (new IterableIter($source))->foldCopy($result, function ($result, $item) {
            $item->key = 4;
            $result->key = 4;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
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
    public function allCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->allCopy(function ($item) {
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
    public function anyCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->anyCopy(function ($item) {
            $item->key = 5;
            return false;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function forEachCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        (new IterableIter($source))->forEachCopy(function ($item) {
            $item->key = 5;
        });

        $this->assertEquals([(object) ['key' => 1]], $source);
    }
}
