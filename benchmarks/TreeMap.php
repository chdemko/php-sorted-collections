<?php

/**
 * TreeMap beanchmark
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

require __DIR__ . "/../vendor/autoload.php";

use chdemko\SortedCollection\TreeMap;

$tree = TreeMap::create();

echo 'Insertion' . PHP_EOL;

foreach (array(100, 1000, 10000, 100000) as $count)
{
	$tree->clear();

	$start = microtime(true);

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$end = microtime(true);

	echo $count . ': ' . ($end - $start) . ' ms' . PHP_EOL;
}

echo PHP_EOL;
echo 'Search' . PHP_EOL;

foreach (array(100, 1000, 10000, 100000) as $count)
{
	$tree->clear();

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	for ($i = 0; $i < $count; $i++)
	{
		$value = $tree[$i];
	}

	$end = microtime(true);

	echo $count . ': ' . ($end - $start) . ' ms' . PHP_EOL;
}

echo PHP_EOL;
echo 'Remove' . PHP_EOL;

foreach (array(100, 1000, 10000, 100000) as $count)
{
	$tree->clear();

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	for ($i = 0; $i < $count; $i++)
	{
		unset($tree[$i]);
	}

	$end = microtime(true);

	echo $count . ': ' . ($end - $start) . ' ms' . PHP_EOL;
}
