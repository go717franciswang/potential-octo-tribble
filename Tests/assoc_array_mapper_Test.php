<?php

require_once dirname(__FILE__) . "/../assoc_array_mapper.php";

class AssocArrayMapperTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->a = array('a' => 1, 'b' => 2);
        $this->b = array('a' => 3, 'b' => 4);
        $this->c = array('a' => 5, 'b' => 6);
    }

    public function testSumValues()
    {
        $m = new AssocArrayMapper('AssocArrayMapperUtil::sum', $this->a, $this->b, $this->c); 
        $this->assertEquals(9, $m['a']);
        $this->assertEquals(12, $m['b']);

        $a = iterator_to_array($m, true);
        $this->assertEquals(array('a' => 9, 'b' => 12), $a);
    }

    public function testNegateValues()
    {
        $negatives = new AssocArrayMapper('AssocArrayMapperUtil::negate', $this->b);
        $a = iterator_to_array($negatives, true);
        $this->assertEquals(array('a' => -3, 'b' => -4), $a);
    }

    public function testNestedMappers()
    {
        $negatives = new AssocArrayMapper('AssocArrayMapperUtil::negate', $this->b);
        $m = new AssocArrayMapper('AssocArrayMapperUtil::sum', $this->a, $negatives);

        $a = iterator_to_array($m, true);
        $this->assertEquals(array('a' => -2, 'b' => -2), $a);
    }

    public function testMemoryUsage()
    {
        $mem_start = memory_get_usage();
        $large_array1 = array_fill(10000, 20000, 's1');
        $large_array2 = array_fill(10000, 20000, 's2');
        $mem_create_array = memory_get_usage();
        $array_mem = $mem_create_array - $mem_start;

        $m = new AssocArrayMapper('AssocArrayMapperUtil::concat', &$large_array1, &$large_array2);
        $mem_create_mapper = memory_get_usage();
        $mapper_mem = $mem_create_mapper - $mem_create_array;

        $this->assertLessThan($array_mem * 0.01, $mapper_mem);
    }

    public function testMemoryUsageNested()
    {
        $mem_start = memory_get_usage();
        $large_array1 = array_fill(10000, 20000, 1);
        $large_array2 = array_fill(10000, 20000, 2);
        $mem_create_array = memory_get_usage();
        $array_mem = $mem_create_array - $mem_start;

        $negatives = new AssocArrayMapper('AssocArrayMapperUtil::negate', &$large_array2);
        $m = new AssocArrayMapper('AssocArrayMapperUtil::sum', &$large_array1, $negatives);
        $mem_create_mapper = memory_get_usage();
        $mapper_mem = $mem_create_mapper - $mem_create_array;

        $this->assertLessThan($array_mem * 0.01, $mapper_mem);
    }
}
