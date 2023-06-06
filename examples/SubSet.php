<?php

/**
 * SubSet example
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2023 Christophe Demko. All rights reserved.
 *
 * @license     BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

require __DIR__ . '/../vendor/autoload.php';

use chdemko\SortedCollection\TreeSet;
use chdemko\SortedCollection\ReversedSet;
use chdemko\SortedCollection\SubSet;

$set = TreeSet::create()->put(array(1, 9, 5, 2, 6, 3, 0, 8, 7, 4));
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
