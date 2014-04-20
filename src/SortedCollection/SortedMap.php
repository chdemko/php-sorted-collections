<?php

/**
 * chdemko\SortedCollection\SortedMap interface
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2014 Christophe Demko. All rights reserved.
 *
 * @license    http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

/**
 * SortedMap
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 */
interface SortedMap extends SortedCollection
{
	/**
	 * Get the first key or throw an exception if there is no element
	 *
	 * @return  mixed  The first key
	 *
	 * @throws  \OutOfBoundsException  If there is no element
	 *
	 * @since   1.0.0
	 */
	public function firstKey();

	/**
	 * Get the last key or throw an exception if there is no element
	 *
	 * @return  mixed  The last key
	 *
	 * @throws  \OutOfBoundsException  If there is no element
	 *
	 * @since   1.0.0
	 */
	public function lastKey();

	/**
	 * Returns the greatest key lesser than the given key or throw an exception if there is no such key
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found key
	 *
	 * @throws  \OutOfBoundsException  If there is no lower element
	 *
	 * @since   1.0.0
	 */
	public function lowerKey($key);

	/**
	 * Returns the greatest key lesser than or equal to the given key or throw an exception if there is no such key
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found key
	 *
	 * @throws  \OutOfBoundsException  If there is no floor element
	 *
	 * @since   1.0.0
	 */
	public function floorKey($key);

	/**
	 * Returns the key equal to the given key or throw an exception if there is no such key
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found key
	 *
	 * @throws  \OutOfBoundsException  If there is no such element
	 *
	 * @since   1.0.0
	 */
	public function findKey($key);

	/**
	 * Returns the lowest key greater than or equal to the given key or throw an exception if there is no such key
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found key
	 *
	 * @throws  \OutOfBoundsException  If there is no ceiling element
	 *
	 * @since   1.0.0
	 */
	public function ceilingKey($key);

	/**
	 * Returns the lowest key greater than to the given key or throw an exception if there is no such key
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found key
	 *
	 * @throws  \OutOfBoundsException  If there is no higher element
	 *
	 * @since   1.0.0
	 */
	public function higherKey($key);

	/**
	 * Get the predecessor node
	 *
	 * @param   TreeNode  $node  A tree node member of the underlying TreeMap
	 *
	 * @return  mixed  The predecessor node
	 *
	 * @since   1.0.0
	 */
	public function predecessor($node);

	/**
	 * Get the successor node
	 *
	 * @param   TreeNode  $node  A tree node member of the underlying TreeMap
	 *
	 * @return  mixed  The successor node
	 *
	 * @since   1.0.0
	 */
	public function successor($node);

	/**
	 * Keys generator
	 *
	 * @return  mixed  The keys generator
	 *
	 * @since   1.0.0
	 */
	public function keys();

	/**
	 * Values generator
	 *
	 * @return  mixed  The values generator
	 *
	 * @since   1.0.0
	 */
	public function values();
}
