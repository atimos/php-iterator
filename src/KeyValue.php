<?php
namespace Iterator;

class KeyValue {
    public $key;
    public $value;

    public static function mapKey() : Callable
    {
        return function(KeyValue $item) {
            return $item->key;
        };
    }

    public static function mapValue() : Callable
    {
        return function(KeyValue $item) {
            return $item->value;
        };
    }

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
