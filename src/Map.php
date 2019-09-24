<?php declare(strict_types=1);
namespace Iter;

use PhpOption\Option;
use PhpOption\Some;

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

    public function next() : Option
    {
        $item = $this->inner->next();

        if ($item->isDefined()) {
            $item = Some::create(cloneOption($item)->get());
        }

        return $item;
    }
}
