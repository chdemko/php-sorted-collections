<?php

/**
 * ReversedSet example
 *
 * @package     SortedCollection
 * @subpackage  Set
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

use chdemko\SortedCollection\TreeSet;
use chdemko\SortedCollection\ReversedSet;

$set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
$reversed = ReversedSet::create($set);

// Print [9,8,7,6,5,4,3,2,1,0]
echo $reversed . PHP_EOL;

// Print [8,7,6,5,4,3,2,1,0]
unset($set[9]);
echo $reversed . PHP_EOL;
