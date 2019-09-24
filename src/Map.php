<?php declare(strict_types=1);
namespace Iter;

class Map implements Iter
{
    use IterImpl;

    private $mapper;
    private $inner;

    public function __construct(Iter $inner, Callable $mapper)
    {
        $this->mapper = $mapper;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $item = $this->inner->next();

        if ($item->hasValue()) {
            $item->replaceWithValue(($this->mapper)($item->getValue()));
        }

        return $item;
    }
}
