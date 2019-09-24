<?php declare(strict_types=1);
namespace Iter;

use PhpOption\Option;
use PhpOption\Some;
use PhpOption\None;

class IterableKeyIter implements Iter
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

    public function next() : Option
    {
        if (!$this->inner->valid()) {
            return None::create();
        }
        $key = $this->inner->key();
        $this->inner->next();
        return Some::create($key);
    }
}
