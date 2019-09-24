<?php declare(strict_types=1);
namespace Iter;

use PhpOption\Option;
use PhpOption\Some;
use PhpOption\None;

class Zip implements Iter
{
    use IterImpl;

    private $inner;
    private $other;

    public function __construct(Iter $inner, Iter $other)
    {
        $this->inner = $inner;
        $this->other = $other;
    }

    public function next() : Option
    {
        $innerOption = $this->inner->next();
        $otherOption = $this->inner->next();

        if ($innerOption->isDefined() && $otherOption->isDefined()) {
            return Some::create([
                $innerOption->get(),
                $otherOption->get(),
            ]);
        }

        return None::create();
    }
}
