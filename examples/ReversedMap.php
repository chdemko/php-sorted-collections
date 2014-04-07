<?php

/**
 * ReversedMap example
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2014 Christophe Demko. All rights reserved.
 *
 * @license     http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('chdemko\\SortedCollection\\', __DIR__ . '/SortedCollection');

use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;

$tree = TreeMap::create()->put(array(1 => 1, 9 => 9, 5 => 5, 2 => 2, 6 => 6, 3 => 3, 0 => 0, 8 => 8, 7 => 7, 4 => 4));
$reversed = ReversedMap::create($tree);

// Print {"9":9,"8":8,"7":7,"6":6,"5":5,"4":4,"3":3,"2":2,"1":1,"0":0}
echo $reversed . PHP_EOL;

// Print {"8":8,"7":7,"6":6,"5":5,"4":4,"3":3,"2":2,"1":1,"0":0}
unset($tree[9]);
echo $reversed . PHP_EOL;
