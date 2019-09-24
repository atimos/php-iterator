<?php declare(strict_types=1);
namespace Iter;

class Inspector implements Iter
{
    use IterImpl;

    private $callback;
    private $inner;

    public function __construct(Iter $inner, Callable $callback)
    {
        $this->callback = $callback;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $item = $this->inner->next();

        if ($item->hasValue()) {
            ($this->callback)($item->getValue());
        }

        return $item;
    }
}
