<?php declare(strict_types=1);
namespace Iterator;

class Item
{
    protected $hasValue = false;
    protected $value = null;

    private function __construct(mixed $value, bool $hasValue)
    {
        $this->value = $value;
        $this->hasValue = $hasValue;
    }

    public static function createEmpty() : Self
    {
        return new Self(null, false);
    }

    public static function createWithValue(mixed $value) : Self
    {
        return new Self($value, true);
    }

    public function replaceWithValue(mixed $value)
    {
        $this->hasValue = true;
        $this->value = clone $value;
    }

    public function replaceWithEmpty()
    {
        $this->hasValue = false;
        $this->value = null;
    }

    public function isEmpty() : bool
    {
        return !$this->hasValue;
    }

    public function hasValue() : bool
    {
        return $this->hasValue;
    }

    public function getValue() : mixed
    {
        if ($this->hasValue) {
            return clone $this->value;
        }

        throw new \RuntimeException('has no value');
    }
}
