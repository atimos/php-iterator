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
    public function lastWithValues(): void
    {
        $this->assertEquals(Some::create(5), (new IterableIter([0, 1, 2, 3, 4, 5]))->last());
    }

    /** @test */
    public function lastWithoutValues(): void
    {
        $this->assertEquals(None::create(), (new IterableIter([]))->last());
    }

    /** @test */
    public function nthWithValues(): void
    {
        $this->assertEquals(Some::create(2), (new IterableIter([0, 1, 2, 3, 4, 5]))->nth(2));
    }

    /** @test */
    public function nthWithoutValues(): void
    {
        $this->assertEquals(None::create(), (new IterableIter([]))->nth(1));
    }

    /** @test */
    public function findFound(): void
    {
        $needle = 4;

        $result = (new IterableIter([1, 2, 3, 4, 5, 6]))->find(function ($item) use ($needle) {
            return $item === $needle;
        });

        $this->assertEquals(Some::create($needle), $result);
    }

    /** @test */
    public function findNotFound(): void
    {
        $needle = 99;

        $result = (new IterableIter([1, 2, 3, 4, 5, 6]))->find(function ($item) use ($needle) {
            return $item === $needle;
        });

        $this->assertEquals(None::create(), $result);
    }

    /** @test */
    public function findNoValues(): void
    {
        $result = (new IterableIter([]))->find(function ($_) {
            return true;
        });

        $this->assertEquals(None::create(), $result);
    }

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
    public function positionFound(): void
    {
        $needle = 4;

        $result = (new IterableIter([1, 2, 3, 4, 5, 6]))->position(function ($item) use ($needle) {
            return $item === $needle;
        });

        $this->assertEquals(Some::create(3), $result);
    }

    /** @test */
    public function positionNotFound(): void
    {
        $needle = 99;

        $result = (new IterableIter([1, 2, 3, 4, 5, 6]))->position(function ($item) use ($needle) {
            return $item === $needle;
        });

        $this->assertEquals(None::create(), $result);
    }

    /** @test */
    public function positionNoValues(): void
    {
        $result = (new IterableIter([]))->position(function ($_) {
            return true;
        });

        $this->assertEquals(None::create(), $result);
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
    public function fold()
    {
        $result = (new IterableIter([1]))->fold(0, function ($result, $item) {
            $this->assertEquals(0, $result);
            $this->assertEquals(1, $item);
            return $item;
        });

        $this->assertEquals(1, $result);
    }

    /** @test */
    public function foldNoValues()
    {
        $result = (new IterableIter([]))->fold(false, function () {
            return true;
        });
        $this->assertFalse($result);
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
    public function testCount(): void
    {
        $this->assertCount(1, (new IterableIter([1])));
    }

    /** @test */
    public function countNoValues(): void
    {
        $this->assertCount(0, (new IterableIter([])));
    }

    /** @test */
    public function allAllAreTrue(): void
    {
        $this->assertTrue((new IterableIter([true, true]))->all(function ($item) {
            $this->assertTrue($item);
            return $item;
        }));
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
    public function allNoValues(): void
    {
        $this->assertFalse((new IterableIter([]))->all(function () {
            return true;
        }));
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
    public function anyNoneAreTrue(): void
    {
        $this->assertFalse((new IterableIter([false, false]))->any(function ($item) {
            return $item;
        }));
    }

    /** @test */
    public function anyNoValues(): void
    {
        $this->assertFalse((new IterableIter([]))->any(function ($_) {
            return true;
        }));
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
    public function max(): void
    {
        $this->assertEquals(Some::create(3), (new IterableIter([1, 3, 2]))->max());
    }

    /** @test */
    public function maxNoValues(): void
    {
        $this->assertEquals(None::create(), (new IterableIter([]))->max());
    }

    /** @test */
    public function min(): void
    {
        $this->assertEquals(Some::create(1), (new IterableIter([3, 1, 2]))->min());
    }

    /** @test */
    public function minNoValues(): void
    {
        $this->assertEquals(None::create(), (new IterableIter([]))->min());
    }

    /** @test */
    public function forEach(): void
    {
        $iterationValues = [];

        (new IterableIter([1, 2, 3, 4, 5, 6]))->forEach(function ($item) use (&$iterationValues) {
            $iterationValues[] = $item;
        });

        $this->assertEquals([1, 2, 3, 4, 5, 6], $iterationValues);
    }

    /** @test */
    public function forEachNoValues(): void
    {
        $iterationValues = [];

        (new IterableIter([]))->forEach(function ($item) use (&$iterationValues) {
            $iterationValues[] = $item;
        });

        $this->assertEquals([], $iterationValues);
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

    /** @test */
    public function toArray(): void
    {
        $this->assertEquals([1, 2, 3], (new IterableIter([1, 2, 3]))->toArray());
    }

    /** @test */
    public function toArrayNoItems(): void
    {
        $this->assertEquals([], (new IterableIter([]))->toArray());
    }


    /** @test */
    public function toAssocArray(): void
    {
        $this->assertEquals(
            ['key1' => 1, 'key2' => 2, 'key3' => 3],
            (new IterableIter([['key1', 1], ['key2', 2], ['key3', 3]]))->toAssocArray()
        );
    }

    /** @test */
    public function toAssocArrayNoItems(): void
    {
        $this->assertEquals([], (new IterableIter([]))->toAssocArray());
    }
}
