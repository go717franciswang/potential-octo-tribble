<?php
require_once dirname(__FILE__) . '/assoc_array_mapper_util.php';

class AssocArrayMapper implements Iterator, ArrayAccess
{
    public function __construct($callback, 
        &$a1=null, &$a2=null, &$a3=null, &$a4=null, &$a5=null, 
        &$a6=null, &$a7=null, &$a8=null, &$a9=null, &$a10=null)
    {
        $this->func = $callback;
        $this->arrays = array();
        $argc = func_num_args();
        for ($i = 1; $i < $argc; $i++) {
            $name = 'a'.$i;
            $this->arrays[] = &$$name;
        }
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
