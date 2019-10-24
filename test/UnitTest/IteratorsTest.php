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
    public function iterableIter(): void
    {
        $this->assertEquals([1, 2, 3], (new IterableIter([1, 2, 3]))->toArray());
    }

    /** @test */
    public function iterableKeyIter(): void
    {
        $this->assertEquals([0, 1, 2], (new IterableKeyIter([1, 2, 3]))->toArray());
    }

    /** @test */
    public function iterableKeyValueIter(): void
    {
        $this->assertEquals([[0, 1], [1, 2], [2, 3]], (new IterableKeyValueIter([1, 2, 3]))->toArray());
    }

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
    public function stdIteratorChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1], (object) ['key' => 2]];
        $expected = [(object) ['key' => 1], (object) ['key' => 2]];

        foreach (new IterableIter($source) as $value) {
            $value->key = 5;
        }

        $this->assertEquals($expected, $source);
    }

    /** @test */
    public function peekable(): void
    {
        $iter = (new IterableIter([1, 2, 3]))->peekable();

        $this->assertEquals(Some::create(1), $iter->next());
        $this->assertEquals(Some::create(2), $iter->peek());
        $this->assertEquals(Some::create(2), $iter->next());
        $this->assertEquals(Some::create(3), $iter->next());
    }

    /** @test */
    public function enumerate(): void
    {
        $this->assertEquals(
            [[0, 1], [1, 2], [2, 3]],
            (new IterableIter([1, 2, 3]))->enumerate()->toArray()
        );
    }

    /** @test */
    public function map(): void
    {
        $iter = (new IterableIter([1, 2, 3]))->map(function ($item) {
            return $item + 1;
        });

        $this->assertEquals([2, 3, 4], $iter->toArray());
    }

    /** @test */
    public function mapChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->map(function ($item) {
            $item->key = 5;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function filter(): void
    {
        $iter = (new IterableIter([0, 1, 2, 3, 4, 5, 6]))->filter(function ($item) {
            return $item % 2;
        });

        $this->assertEquals([1, 3, 5], $iter->toArray());
    }

    /** @test */
    public function filterChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->filter(function ($item) {
            $item->key = 5;
            return true;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function stepBy(): void
    {
        $this->assertEquals([0, 3, 6], (new IterableIter([0, 1, 2, 3, 4, 5, 6]))->stepBy(3)->toArray());
    }

    /** @test */
    public function skip(): void
    {
        $this->assertEquals([4, 5, 6], (new IterableIter([0, 1, 2, 3, 4, 5, 6]))->skip(4)->toArray());
    }

    /** @test */
    public function skipWhile(): void
    {
        $iter = (new IterableIter([1, 2, 3, 4, 5, 6]))->skipWhile(function ($item) {
            return $item !== 3;
        });

        $this->assertEquals([3, 4, 5, 6], $iter->toArray());
    }

    /** @test */
    public function skipWhileChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->skipWhile(function ($item) {
            $item->key = 5;
            return true;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function take(): void
    {
        $this->assertEquals([0, 1, 2, 3], (new IterableIter([0, 1, 2, 3, 4, 5, 6]))->take(4)->toArray());
    }

    /** @test */
    public function takeWhile(): void
    {
        $iter = (new IterableIter([1, 2, 3, 4, 5, 6]))->takeWhile(function ($item) {
            return $item !== 4;
        });

        $this->assertEquals([1, 2, 3], $iter->toArray());
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
    public function takeWhileChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->takeWhile(function ($item) {
            $item->key = 5;
            return true;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }

    /** @test */
    public function zip(): void
    {
        $this->assertEquals(
            [[1, 3], [2, 4], [3, 5], [4, 6]],
            (new IterableIter([1, 2, 3, 4]))->zip(new IterableIter([3, 4, 5, 6]))->toArray()
        );
    }

    /** @test */
    public function chain(): void
    {
        $this->assertEquals(
            [1, 2, 3, 4, 3, 4, 5, 6],
            (new IterableIter([1, 2, 3, 4]))->chain(new IterableIter([3, 4, 5, 6]))->toArray()
        );
    }

    /** @test */
    public function cycle(): void
    {
        $iter = (new IterableIter([1, 2, 3]))->cycle();

        $this->assertEquals(Some::create(1), $iter->next());
        $this->assertEquals(Some::create(2), $iter->next());
        $this->assertEquals(Some::create(3), $iter->next());
        $this->assertEquals(Some::create(1), $iter->next());
        $this->assertEquals(Some::create(2), $iter->next());
        $this->assertEquals(Some::create(3), $iter->next());
    }

    /** @test */
    public function cycleWithNoValues(): void
    {
        $iter = (new IterableIter([]))->cycle();

        $this->assertEquals(None::create(), $iter->next());
        $this->assertEquals(None::create(), $iter->next());
    }

    /** @test */
    public function cycleChangingItemShouldNotChangeOutput(): void
    {
        $source = [(object) ['key' => 1], (object) ['key' => 2]];

        $iter = (new IterableIter($source))->cycle();

        $iter->next();
        $iter->next();

        $source[0]->key = 2;
        $source[1]->key = 3;

        $this->assertEquals(Some::create((object) ['key' => 1]), $iter->next());
        $this->assertEquals(Some::create((object) ['key' => 2]), $iter->next());
    }

    /** @test */
    public function fuse(): void
    {
        $iter = (new MalfunctioningIter())->fuse();

        $this->assertEquals(Some::create(0), $iter->next());
        $this->assertEquals(None::create(), $iter->next());
        $this->assertEquals(None::create(), $iter->next());
        $this->assertEquals(None::create(), $iter->next());
    }

    /** @test */
    public function inspect(): void
    {
        $iterationValues = [];

        $iter = (new IterableIter([1, 2, 3]))->inspect(function ($item) use (&$iterationValues) {
            $iterationValues[] = $item;
            return 1;
        });

        $this->assertEquals([1, 2, 3], $iter->toArray());
        $this->assertEquals([1, 2, 3], $iterationValues);
    }

    /** @test */
    public function inspectChangingItemShouldNotChangeSource(): void
    {
        $source = [(object) ['key' => 1]];

        $iter = (new IterableIter($source))->inspect(function ($item) {
            $item->key = 5;
        });

        $iter->next();

        $this->assertEquals([(object) ['key' => 1]], $source);
    }
}
