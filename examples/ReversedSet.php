<?php

/**
 * ReversedSet example
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2015 Christophe Demko. All rights reserved.
 *
 * @license     http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

require __DIR__ . '/../vendor/autoload.php';

use chdemko\SortedCollection\TreeSet;
use chdemko\SortedCollection\ReversedSet;

$set = TreeSet::create()->put([1, 9, 5, 2, 6, 3, 0, 8, 7, 4]);
$reversed = ReversedSet::create($set);

// Print [9,8,7,6,5,4,3,2,1,0]
echo $reversed . PHP_EOL;

// Print [8,7,6,5,4,3,2,1,0]
unset($set[9]);
echo $reversed . PHP_EOL;
