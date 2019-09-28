<?php declare(strict_types=1);
namespace Test\Prop;

use PHPUnit\Framework\TestCase;
use Eris\Generator;
use Eris\TestTrait as PropTestTrait;
use Iter;

class FizzBuzzTest extends TestCase
{
    use PropTestTrait;

    /**
     * @test
     */
    public function fizzBuzz()
    {
        $this->forAll(Generator\pos())
            ->then(function($number) {
                $expectedValue = $this->rosettaImplementation($number);
                $actualValue = $this->iterImplementation($number);
                $this->assertTrue($actualValue->isDefined());
                $this->assertEquals(
                    $expectedValue,
                    $actualValue->get(),
                    "number $number should be $expectedValue"
                );
            });
    }

    private function iterImplementation($number)
    {
        return (new Iter\IterableIter(['', '', 'Fizz']))->cycle()
            ->zip((new Iter\IterableIter(['', '', '', '', 'Buzz']))->cycle())
            ->map(function($item) { return trim(implode(' ', $item)); })
            ->zip(new Iter\GeneratorIter(function() {
                $number = 0;
                while (true) {
                    yield (string) $number += 1;
                }
            }))
            ->map(function($data) { return max($data); })
            ->nth($number - 1);
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
