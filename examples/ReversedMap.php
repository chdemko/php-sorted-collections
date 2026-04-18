<?php

/**
 * ReversedMap example
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2024 Christophe Demko. All rights reserved.
 *
 * @license     BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

require __DIR__ . '/../vendor/autoload.php';

use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;

$tree = TreeMap::create()->put(array(1 => 1, 9 => 9, 5 => 5, 2 => 2, 6 => 6, 3 => 3, 0 => 0, 8 => 8, 7 => 7, 4 => 4));
$reversed = ReversedMap::create($tree);

// Print {"9":9,"8":8,"7":7,"6":6,"5":5,"4":4,"3":3,"2":2,"1":1,"0":0}
echo $reversed . PHP_EOL;

// Print {"8":8,"7":7,"6":6,"5":5,"4":4,"3":3,"2":2,"1":1,"0":0}
unset($tree[9]);
echo $reversed . PHP_EOL;
