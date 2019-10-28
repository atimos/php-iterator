<?php

declare(strict_types=1);

namespace LazyIter\Test\UnitTest;

use LazyIter\{
    IterableIter,
    IterableKeyIter,
    IterableKeyValueIter,
    Test\MalfunctioningIter
};
use PhpOption\{Some, None};
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class IteratorsTest extends TestCase
{
    /** @test */
    public function stdIterator(): void
    {
        $expectedValues = [1, 2, 3];
        $expectedKeys = [0, 1, 2];

        foreach (new IterableIter([1, 2, 3]) as $key => $value) {
            $this->assertEquals(array_shift($expectedKeys), $key);
            $this->assertEquals(array_shift($expectedValues), $value);
        }

        $this->assertCount(0, $expectedKeys, 'not all keys where iterated over');
    }

    /** @test */
    public function stdIteratorNoValues(): void
    {
        $stdIter = (new IterableIter([]))->getIterator();
        $this->assertNull($stdIter->key());
        $this->assertNull($stdIter->current());
    }

    /** @test */
    public function stdIteratorCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1], (object) ['key' => 2]];
        $expected = [(object) ['key' => 1], (object) ['key' => 2]];

        foreach ((new IterableIter($source))->getIteratorCopy() as $value) {
            $value->key = 5;
        }

        $this->assertEquals($expected, $source);
    }

    /** @test */
    public function mapCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->mapCopy(function ($item) {
            $item->key = 5;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function filterCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->filterCopy(function ($item) {
            $item->key = 5;
            return true;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function skipWhileCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->skipWhileCopy(function ($item) {
            $item->key = 5;
            return true;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function takeWhileShouldNotContinueAfterFirstTake(): void
    {
        $iter = (new IterableIter([1, 2, 3]))->takeWhile(function ($item) {
            return $item !== 2;
        });

        $this->assertEquals(Some::create(1), $iter->next());
        $this->assertEquals(None::create(), $iter->next());
        $this->assertEquals(None::create(), $iter->next());
    }

    /** @test */
    public function takeWhileCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->takeWhileCopy(function ($item) {
            $item->key = 5;
            return true;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function cycleCopyChangingItemShouldNotChangeOutput(): void
    {
        $source = [(object) ['key' => 1], (object) ['key' => 2]];

        $iter = (new IterableIter($source))->cycleCopy();

        $iter->next();
        $iter->next();

        $source[0]->key = 2;
        $source[1]->key = 3;

        $this->assertEquals(Some::create((object) ['key' => 1]), $iter->next());
        $this->assertEquals(Some::create((object) ['key' => 2]), $iter->next());
    }

    /** @test */
    public function inspectCopyChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->inspectCopy(function ($item) {
            $item->key = 5;
        });

        $iter->next();

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
