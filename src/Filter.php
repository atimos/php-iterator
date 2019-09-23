<?php declare(strict_types=1);
namespace Iterator;

class Filter implements Iterator
{
    use IteratorImpl;

    private $filter;
    private $inner;

    public function __construct(Iterator $inner, Callable $filter)
    {
        $this->filter = $filter;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $value = $this->inner->next();

        if ($value->hasValue()) {
            $innerValue = $value->getValue();

            if (!$this->filter($innerValue)) {
                $value->replaceWithEmpty();
            }
        }

        return $value;
    }
}
