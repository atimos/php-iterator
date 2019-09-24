<?php declare(strict_types=1);
namespace Iter;

class IterableKeyValueIter implements Iter
{
    use IterImpl;

    private $inner;

    public function __construct(Iterable $inner)
    {
        if (is_array($inner)) {
            $inner = new \ArrayIterator($inner);
        }
        $this->inner = $inner;
    }

    public function next() : Item
    {
        if (!$this->inner->valid()) {
            return Item::createEmpty();
        }
        $value = $this->inner->current();
        $key = $this->inner->key();
        $this->inner->next();
        return Item::createFromValue([$key, $value]);
    }
}
