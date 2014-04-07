<?php

/**
 * SubSet example
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
use chdemko\SortedCollection\SubSet;

$set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
$reversed = ReversedSet::create($set);
$sub = SubSet::create($reversed, 7, 2);

// Print [7,6,5,4,3]
echo $sub . PHP_EOL;

// Print [7,6,5,3]
unset($set[4]);
echo $sub . PHP_EOL;

// Print [9,8,7,6,5,3]
unset($sub->from);
echo $sub . PHP_EOL;
