<?php

declare(strict_types=1);

namespace Test\PropTest;

use PHPUnit\Framework\TestCase;
use Eris\Generator;
use Eris\TestTrait as PropTestTrait;
use PhpOption\Some;
use Iter;

class FizzBuzzTest extends TestCase
{
    use PropTestTrait;

    /**
     * @test
     */
    public function fizzBuzzPattern()
    {
        $this->forAll(Generator\pos())->then(function ($n) {
            $expected = Some::create($this->rosettaImplementation($n));

            $actual = (new Iter\IterableIter(['', '', 'Fizz']))->cycle()
                ->zip((new Iter\IterableIter(['', '', '', '', 'Buzz']))->cycle())
                ->map(function ($item) {
                    return trim(implode('', $item));
                })
                ->zip(new Iter\GeneratorIter(function () {
                    $number = 0;
                    while (true) {
                        yield (string) $number += 1;
                    }
                }))
                ->map(function ($data) {
                    return max($data);
                })
                ->nth($n - 1);

            $this->assertEquals($expected, $actual, "$n should result in Some({$expected->get()})");
        });
    }

    private function rosettaImplementation($number)
    {
        $str = "";
        if (!($number % 3)) {
            $str .= "Fizz";
        }

        if (!($number % 5)) {
            $str .= "Buzz";
        }

        if (empty($str)) {
            $str = (string) $number;
        }

        return $str;
    }
}
