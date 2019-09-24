<?php declare(strict_types=1);
namespace Iter;

class Filter implements Iter
{
    use IterImpl;

    private $filter;
    private $inner;

    public function __construct(Iter $inner, Callable $filter)
    {
        $this->filter = $filter;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $item = $this->inner->next();

        while($item->hasValue()) {
            if (($this->filter)($item->getValue())) {
                break;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
