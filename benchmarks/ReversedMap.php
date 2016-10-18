<?php

/**
 * ReversedMap beanchmark
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2016 Christophe Demko. All rights reserved.
 *
 * @license     http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

require __DIR__ . '/../vendor/autoload.php';

use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;

date_default_timezone_set('UTC');
printf('ReversedMap benchmarking run on ' . date('r') . PHP_EOL . PHP_EOL);
printf('%25s %10s %10s %10s' . PHP_EOL, 'Operation', 'n', 'seconds', 'μs/(n log(n))');
printf('-------------------------------------------------------------' . PHP_EOL);

$tree = TreeMap::create();
$reversed = ReversedMap::create($tree);

foreach ([100, 1000, 10000, 100000] as $count)
{
	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	for ($i = 0; $i < $count; $i++)
	{
		$value = $reversed[$i];
	}

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Search all elements',
		$count,
		$end - $start,
		($end - $start) / ($count * log($count)) * 1000000
	);

	$tree->clear();
}

foreach ([100, 1000, 10000, 100000] as $count)
{
	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	foreach ($reversed as $key => $value)
	{
	}

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Loop on all elements',
		$count,
		$end - $start,
		($end - $start) / ($count * log($count)) * 1000000
	);

	$tree->clear();
}

foreach ([100, 1000, 10000, 100000] as $count)
{
	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	$value = count($reversed);

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Count all elements',
		$count,
		$end - $start,
		($end - $start) / ($count * log($count)) * 1000000
	);

	$tree->clear();
}
