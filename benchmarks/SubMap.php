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
use chdemko\SortedCollection\SubMap;

date_default_timezone_set('UTC');
printf('SubMap benchmarking run on ' . date('r') . PHP_EOL . PHP_EOL);
printf('%25s %10s %10s %10s' . PHP_EOL, 'Operation', 'n', 'seconds', 'μs/(n log(n))');
printf('-------------------------------------------------------------' . PHP_EOL);

$tree = TreeMap::create();
$sub = SubMap::create($tree, null, null);

foreach ([100, 1000, 10000, 100000] as $count)
{
	$count = 2 * $count;
	$sub->fromKey = (int) (0.25 * $count);
	$sub->toKey = (int) (0.75 * $count);

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	for ($i = $sub->fromKey; $i < $sub->toKey; $i++)
	{
		$value = $sub[$i];
	}

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Search all elements',
		$count / 2,
		$end - $start,
		($end - $start) / ($count * log($count)) * 1000000
	);

	$tree->clear();
}

foreach ([100, 1000, 10000, 100000] as $count)
{
	$count = 2 * $count;
	$sub->fromKey = (int) (0.25 * $count);
	$sub->toKey = (int) (0.75 * $count);

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	foreach ($sub as $key => $value)
	{
	}

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Loop on all elements',
		$count / 2,
		$end - $start,
		($end - $start) / ($count * log($count)) * 1000000
	);

	$tree->clear();
}

foreach ([100, 1000, 10000, 100000] as $count)
{
	$count = 2 * $count;
	$sub->fromKey = (int) (0.25 * $count);
	$sub->toKey = (int) (0.75 * $count);

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$start = microtime(true);

	$value = count($sub);

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Count all elements',
		$count / 2,
		$end - $start,
		($end - $start) / ($count * log($count)) * 1000000
	);

	$tree->clear();
}
