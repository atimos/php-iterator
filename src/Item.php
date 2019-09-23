<?php declare(strict_types=1);
namespace Iterator;

class Item
{
    protected $hasValue = false;
    protected $value = null;

    private function __construct($value, $hasValue)
    {
        $this->value = $value;
        $this->hasValue = $hasValue;
    }

    public static function createEmpty()
    {
        return new Self(null, false);
    }

    public static function createWithValue($value)
    {
        return new Self($value, true);
    }

    public function replaceWithValue($value)
    {
        $this->hasValue = true;
        $this->value = clone $value;
    }

    public function replaceWithEmpty()
    {
        $this->hasValue = false;
        $this->value = null;
    }

    public function isEmpty()
    {
        return !$this->hasValue;
    }

    public function hasValue()
    {
        return $this->hasValue;
    }

    public function getValue()
    {
        if ($this->hasValue) {
            return clone $this->value;
        }

        throw new \RuntimeException('has no value');
    }
}
