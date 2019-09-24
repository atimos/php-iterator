<?php declare(strict_types=1);
namespace Iter;

use PhpOption\Option;

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

    public function next() : Option
    {
        $item = $this->inner->next();

        while($item->isDefined()) {
            if (($this->filter)(cloneOption($item)->get())) {
                break;
            }
            $item = $this->inner->next();
        }

        return $item;
    }
}
