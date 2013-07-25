Example usage
-------------

#Syntax
    # member arrays are copied
    $m = new AssocArrayMapper($func_callback, $arr1, $arr2, ..);

    # member arrays are stored as reference
    $m = new AssocArrayMapper($func_callback, &$arr1, &$arr2, ..);

#Simple mapping
    $a = array('a' => 1, 'b' => 2);
    $b = array('a' => 3, 'b' => 4);
    $c = array('a' => 5, 'b' => 6);

    $m = new AssocArrayMapper('AssocArrayMapperUtil::sum', &$a, &$b, &$c); 
    echo $m['a'];
    # 9;

    foreach($m as $k => $v) { 
        echo "$k: $v\n";
    }
    # a: 9
    # b: 12

    iterator_to_array($m);
    # array('a' => 9, 'b' => 12);

#Nested mapping
    $negatives = new AssocArrayMapper('AssocArrayMapperUtil::negate', $b);
    $m = new AssocArrayMapper('AssocArrayMapperUtil::sum', $a, $negatives);

    iterator_to_array($m);
    # array('a' => -2, 'b' => -2);

#Pass arrays as reference to 
    $mem_start = memory_get_usage();
    $large_array1 = array_fill(10000, 20000, 's1');
    $large_array2 = array_fill(10000, 20000, 's2');
    $mem_create_array = memory_get_usage();
    $array_mem = $mem_create_array - $mem_start;

    $m = new AssocArrayMapper('AssocArrayMapperUtil::concat', &$large_array1, &$large_array2);
    $mem_create_mapper = memory_get_usage();
    $mapper_mem = $mem_create_mapper - $mem_create_array;

    echo "array bytes: $array_mem\n";
    echo "mapper bytes: $mapper_mem\n";
    # array bytes: 5325312
    # mapper bytes: 2648
