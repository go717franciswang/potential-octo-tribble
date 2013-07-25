<?php

require_once dirname(__FILE__) . '/../assoc_array_mapper.php';

$a = array('a' => 1, 'b' => 2);
$b = array('a' => 3, 'b' => 4);
$c = array('a' => 5, 'b' => 6);

$m = new AssocArrayMapper('AssocArrayMapperUtil::sum', $a, $b, $c); 
$a = iterator_to_array($m, true);
print_r($a);
