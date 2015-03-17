<?php

/**
 * TreeMap beanchmark
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @author      Christophe Demko <chdemko@gmail.com>
 * @copyright   Copyright (C) 2012-2015 Christophe Demko. All rights reserved.
 *
 * @license     http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

require __DIR__ . '/../vendor/autoload.php';

use chdemko\SortedCollection\TreeMap;

printf('TreeMap benchmarking run on ' . date('r') . PHP_EOL . PHP_EOL);
printf('%25s %10s %10s %10s' . PHP_EOL, 'Operation', 'n', 'seconds', 'μs/(n log(n))');
printf('-------------------------------------------------------------' . PHP_EOL);

$tree = TreeMap::create();

foreach ([100, 1000, 10000, 100000] as $count)
{
	$start = microtime(true);

	for ($i = 0; $i < $count; $i++)
	{
		$tree[$i] = $i;
	}

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Insert all elements',
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

	for ($i = 0; $i < $count; $i++)
	{
		unset($tree[$i]);
	}

	$end = microtime(true);

	printf(
		'%25s %10d %10.2f %10.2f' . PHP_EOL,
		'Remove all elements',
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

	for ($i = 0; $i < $count; $i++)
	{
		$value = $tree[$i];
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

	foreach ($tree as $key => $value)
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

	$value = count($tree);

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
