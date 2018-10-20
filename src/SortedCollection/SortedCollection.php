<?php

/**
 * chdemko\SortedCollection\SortedCollection interface
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2018 Christophe Demko. All rights reserved.
 *
 * @license    BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

/**
 * The SortedCollection interface is the root of the hierarchy. It extends:
 * 
 * * :php:class:`ArrayAccess`
 * * :php:class:`IteratorAggregate`
 * * :php:class:`JsonSerializable`
 * * :php:class:`Countable`
 *
 * And it is implemented by two classes: :php:class:`chdemko\\SortedCollection\\SortedMap`
 * and :php:class:`chdemko\\SortedCollection\\SortedSet`
 *
 * @package SortedCollection
 *
 * @since 1.0.0
 */
interface SortedCollection extends \ArrayAccess, \Countable, \IteratorAggregate, \JsonSerializable
{
	/**
	 * Get the comparator
	 *
	 * @return callable The comparator
	 *
	 * @since 1.0.0
	 */
	public function comparator();

	/**
	 * Get the first element or throw an exception if there is no element
	 *
	 * @return mixed The first element
	 *
	 * @throws \OutOfBoundsException If there is no element
	 *
	 * @since   1.0.0
	 */
	public function first();

	/**
	 * Get the last element or throw an exception if there is no element
	 *
	 * @return mixed The last element
	 *
	 * @throws \OutOfBoundsException If there is no element
	 *
	 * @since 1.0.0
	 */
	public function last();

	/**
	 * Returns the greatest element lesser than the given key or throw an exception if there is no such element
	 *
	 * @param mixed $key The searched key
	 *
	 * @return mixed The found node
	 *
	 * @throws \OutOfBoundsException If there is no lower element
	 *
	 * @since 1.0.0
	 */
	public function lower($key);

	/**
	 * Returns the greatest element lesser than or equal to the given key or throw an exception if there is no such element
	 *
	 * @param mixed $key The searched key
	 *
	 * @return mixed The found node
	 *
	 * @throws \OutOfBoundsException If there is no floor element
	 *
	 * @since 1.0.0
	 */
	public function floor($key);

	/**
	 * Returns the element equal to the given key or throw an exception if there is no such element
	 *
	 * @param mixed $key The searched key
	 *
	 * @return mixed The found node
	 *
	 * @throws \OutOfBoundsException If there is no such element
	 *
	 * @since 1.0.0
	 */
	public function find($key);

	/**
	 * Returns the lowest element greater than or equal to the given key or throw an exception if there is no such element
	 *
	 * @param mixed $key The searched key
	 *
	 * @return mixed The found node
	 *
	 * @throws \OutOfBoundsException If there is no ceiling element
	 *
	 * @since 1.0.0
	 */
	public function ceiling($key);

	/**
	 * Returns the lowest element greater than to the given key or throw an exception if there is no such element
	 *
	 * @param mixed $key The searched key
	 *
	 * @return mixed The found node
	 *
	 * @throws \OutOfBoundsException If there is no higher element
	 *
	 * @since 1.0.0
	 */
	public function higher($key);
}
