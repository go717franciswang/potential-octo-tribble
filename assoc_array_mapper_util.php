<?php

class AssocArrayMapperUtil
{
    public static function sum()
    {
        return array_sum(func_get_args());
    }

    public static function negate($x)
    {
        return -$x;
    }

    public function product()
    {
        return array_product(func_get_args());
    }

    public static function concat()
    {
        return implode('', func_get_args());
    }

    public static function identity($x)
    {
        return $x;
    }
}
