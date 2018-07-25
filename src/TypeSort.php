<?php

namespace WebInvest;

/**
 * Class TypeSort
 * @package WebInvest
 */
class TypeSort {

    const __default = self::Asc;

    const Asc = '1';
    const Desc = '2';

    private $value;

    /**
     * TypeSort constructor.
     * @param $value
     * @throws \ReflectionException
     */
    function __construct($value)
    {
        $reflection = new \ReflectionClass(get_called_class());
        if (in_array($value, array_values($reflection->getConstants()))) {
            $this->value = $value;
        } else {
            throw new \InvalidArgumentException("Invalid enumeration");
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

}