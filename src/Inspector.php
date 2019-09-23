<?php declare(strict_types=1);
namespace Iterator;

class Inspector implements Iterator
{
    use IteratorImpl;

    private $callback;
    private $inner;

    public function __construct(Iterator $inner, Callable $callback)
    {
        $this->callback = $callback;
        $this->inner = $inner;
    }

    public function next() : Item
    {
        $value = $this->inner->next();

        if ($value->hasValue()) {
            $this->callback($value->getValue());
        }

        return $value;
    }
}
