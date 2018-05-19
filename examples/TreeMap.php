<?php

/**
 * TreeMap example
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2018 Christophe Demko. All rights reserved.
 *
 * @license     BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

require __DIR__ . '/../vendor/autoload.php';

use chdemko\SortedCollection\TreeMap;

$tree = TreeMap::create()->put(array(1 => 1, 9 => 9, 5 => 5, 2 => 2, 6 => 6, 3 => 3, 0 => 0, 8 => 8, 7 => 7, 4 => 4));

// Print [0,1,2,3,4,5,6,7,8,9]
echo $tree . PHP_EOL;

// Print 0
echo $tree->firstKey . PHP_EOL;

// Print 9
echo $tree->lastValue . PHP_EOL;

// Print 10
echo count($tree) . PHP_EOL;

// Print 5
echo $tree[5] . PHP_EOL;

// Change value for $tree[5]
$tree[5] = 10;

// Print [0,1,2,3,4,10,6,7,8,9]
echo $tree . PHP_EOL;

// Unset $tree[5]
unset($tree[5]);

// Print {"0":0,"1":1,"2":2,"3":3,"4":4,"6":6,"7":7,"8":8,"9":9}
echo $tree . PHP_EOL;

// Print 0-0;1-1;2-2;3-3;4-4;6-6;7-7;8-8;9-9;
foreach ($tree as $key => $value)
{
	echo $key . '-' . $value . ';';
}

echo PHP_EOL;
