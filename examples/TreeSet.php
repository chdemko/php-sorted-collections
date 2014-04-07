<?php

/**
 * TreeSet example
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

$set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

// Print [0,1,2,3,4,5,6,7,8,9]
echo $set . PHP_EOL;

// Print 0
echo $set->first . PHP_EOL;

// Print 9
echo $set->last . PHP_EOL;

// Print 10
echo count($set) . PHP_EOL;

// Print 1
echo $set[5] . PHP_EOL;

// Change value for $set[5]
$set[5] = false;

// Print [0,1,2,3,4,6,7,8,9]
echo $set . PHP_EOL;

// Unset $set[6]
unset($set[6]);

// Print [0,1,2,3,4,7,8,9]
echo $set . PHP_EOL;

// Print 0-0;1-1;2-2;3-3;4-4;5-7;6-8;7-9;
foreach ($set as $key => $value)
{
	echo $key . '-' . $value . ';';
}

echo PHP_EOL;
