<?php

/**
 * SubMap example
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
use chdemko\SortedCollection\SubMap;

$tree = TreeMap::create()->put(array(1 => 1, 9 => 9, 5 => 5, 2 => 2, 6 => 6, 3 => 3, 0 => 0, 8 => 8, 7 => 7, 4 => 4));
$reversed = ReversedMap::create($tree);
$sub = SubMap::create($reversed, 7, 2);

// Print {"7":7,"6":6,"5":5,"4":4,"3":3}
echo $sub . PHP_EOL;

// Print {"7":7,"6":6,"5":5,"3":3}
unset($tree[4]);
echo $sub . PHP_EOL;

// Print {"9":9,"8":8,"7":7,"6":6,"5":5,"3":3}
unset($sub->fromKey);
echo $sub . PHP_EOL;
