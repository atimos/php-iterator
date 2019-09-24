<?php declare(strict_types=1);
namespace Iter;

class Item
{
    protected $hasValue = false;
    protected $value = null;

    private function __construct($value, bool $hasValue)
    {
        $this->value = $value;
        $this->hasValue = $hasValue;
    }

    public static function createEmpty() : Self
    {
        return new Self(null, false);
    }

    public static function createFromValue($value) : Self
    {
        if (is_object($value)) {
            $value = clone $value;
        }
        return new Self($value, true);
    }

    public function replaceWithValue($value)
    {
        if (is_object($value)) {
            $value = clone $value;
        }
        $this->hasValue = true;
        $this->value = $value;
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

    public function getValue()
    {
        if ($this->hasValue) {
            $value = $this->value;
            if (is_object($value)) {
                $value = clone $value;
            }
            return $value;
        }

        throw new \RuntimeException('has no value');
    }
}
