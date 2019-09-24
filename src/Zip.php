<?php declare(strict_types=1);
namespace Iter;

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

    public function next() : Item
    {
        $innerItem = $this->inner->next();
        $otherItem = $this->inner->next();

        if ($innerItem->hasValue() && $otherItem->hasValue()) {
            return Item::createWithValue([
                $innerItem->getValue(),
                $otherItem->getValue(),
            ]);
        }

        return Item::createEmpty();
    }
}
