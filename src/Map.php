<?php declare(strict_types=1);
namespace Iterator;

class Map
{
    use Iterator;

    private $mapper;
    private $inner;

    public function __construct(Iterator $inner, Callable $mapper)
    {
        $this->mapper = $mapper;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $item = $this->inner->next();

        if ($item->hasValue()) {
            $item->replaceWithValue($this->mapper($item->getValue()));
        }

        return $item;
    }
}
