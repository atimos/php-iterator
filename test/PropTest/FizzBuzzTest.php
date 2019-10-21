<?php

declare(strict_types=1);

namespace Test\PropTest;

use Eris\Generator;
use Eris\TestTrait;
use Iter\{IterableIter, GeneratorIter};
use PhpOption\Some;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{
    use TestTrait;

    /**
     * @test
     */
    public function testFizzBuzzPattern(): void
    {
        $this->forAll(Generator\pos())->then(function ($n): void {
            $expected = Some::create($this->rosettaImplementation($n));

            $actual = (new IterableIter(['', '', 'Fizz']))->cycle()
                ->zip((new IterableIter(['', '', '', '', 'Buzz']))->cycle())
                ->map(static function ($item) {
                    return trim(implode('', $item));
                })
                ->zip(new GeneratorIter(static function () {
                    $number = 0;
                    while (true) {
                        yield (string) $number += 1;
                    }
                }))
                ->map(static function ($data) {
                    return max($data);
                })
                ->nth($n - 1);

            $this->assertEquals($expected, $actual, "$n should result in Some({$expected->get()})");
        });
    }

    private function rosettaImplementation(int $number): string
    {
        $str = "";
        if (!($number % 3)) {
            $str .= "Fizz";
        }

        if (!($number % 5)) {
            $str .= "Buzz";
        }

        if (strlen($str) === 0) {
            $str = (string) $number;
        }

        return $str;
    }
}
