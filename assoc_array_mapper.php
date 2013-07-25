<?php
require_once dirname(__FILE__) . '/assoc_array_mapper_util.php';

class AssocArrayMapper implements Iterator, ArrayAccess
{
    public function __construct(/*variable arguments*/)
    {
        $stack = debug_backtrace();
        $args = $stack[0]['args'];
        $this->func = $args[0];
        $this->arrays = array_slice($args,1);
    }

    public function rewind()
    {
        return reset($this->arrays[0]);
    }

    public function current()
    {
        $key = $this->key();
        return $this->offsetGet($key);
    }

    public function key()
    {
        return key($this->arrays[0]);
    }

    public function next()
    {
        return next($this->arrays[0]);
    }

    public function valid()
    {
        return key($this->arrays[0]) !== null;
    }

    public function offsetExists($offset)
    {
        return isset($this->arrays[0][$offset]);
    }

    public function offsetGet($offset)
    {
        $params = array();
        foreach ($this->arrays as $i => $array) {
            if (!isset($array[$offset])) {
                throw new Exception("failed to get value of $offset in member array [$i]");
            }
            $params[] = $array[$offset];
        }

        return call_user_func_array($this->func, $params);
    }

    public function offsetSet($offset, $value)
    {
        throw new Exception('does not support setting value');
    }

    public function offsetUnset($offset)
    {
        throw new Exception('does not support unsetting value');
    }
}
