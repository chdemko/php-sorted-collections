<?php

/**
 * chdemko\SortedCollection\TreeMap class
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2015 Christophe Demko. All rights reserved.
 *
 * @license    http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

/**
 * Tree map
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 *
 * @property-read  callable   $comparator  The key comparison function
 * @property-read  TreeNode   $first       The first element of the map
 * @property-read  mixed      $firstKey    The first key of the map
 * @property-read  mixed      $firstValue  The first value of the map
 * @property-read  TreeNode   $last        The last element of the map
 * @property-read  mixed      $lastKey     The last key of the map
 * @property-read  mixed      $lastValue   The last value of the map
 * @property-read  Iterator   $keys        The keys iterator
 * @property-read  Iterator   $values      The values iterator
 * @property-read  integer    $count       The number of elements in the map
 */
class TreeMap extends AbstractMap
{
	/**
	 * @var     TreeNode  Root of the tree
	 *
	 * @since   1.0.0
	 */
	private $root;

	/**
	 * @var     Callable  Comparator function
	 *
	 * @param   mixed  $key1  First key
	 * @param   mixed  $key2  Second key
	 *
	 * @return  integer  negative if $key1 is lesser than $key2,
	 *                   0 if $key1 is equal to $key2,
	 *                   positive if $key1 is greater than $key2
	 *
	 * @since   1.0.0
	 */
	private $comparator;

	/**
	 * Constructor
	 *
	 * @param   Callable  $comparator  Comparison function
	 *
	 * @since   1.0.0
	 */
	protected function __construct($comparator = null)
	{
		if ($comparator == null)
		{
			$this->comparator = function ($key1, $key2)
			{
				return $key1 - $key2;
			};
		}
		else
		{
			$this->comparator = $comparator;
		}
	}

	/**
	 * Create
	 *
	 * @param   Callable  $comparator  Comparison function
	 *
	 * @return  TreeMap  A new TreeMap
	 *
	 * @since   1.0.0
	 */
	static public function create($comparator = null)
	{
		return new static($comparator);
	}

	/**
	 * Get the comparator
	 *
	 * @return  callable  The comparator
	 *
	 * @since   1.0.0
	 */
	public function comparator()
	{
		return $this->comparator;
	}

	/**
	 * Get the first element or throw an exception if there is no such element
	 *
	 * @return  mixed  The first element
	 *
	 * @throws  \OutOfBoundsException  If there is no element
	 *
	 * @since   1.0.0
	 */
	public function first()
	{
		if ($this->root)
		{
			return $this->root->first;
		}
		else
		{
			throw new \OutOfBoundsException('First element unexisting');
		}
	}

	/**
	 * Get the last element or throw an exception if there is no such element
	 *
	 * @return  mixed  The last element
	 *
	 * @throws  \OutOfBoundsException  If there is no element
	 *
	 * @since   1.0.0
	 */
	public function last()
	{
		if ($this->root)
		{
			return $this->root->last;
		}
		else
		{
			throw new \OutOfBoundsException('Last element unexisting');
		}
	}

	/**
	 * Get the predecessor element or throw an exception if there is no such element
	 *
	 * @param   TreeNode  $element  A tree node member of the underlying TreeMap
	 *
	 * @return  mixed  The predecessor element
	 *
	 * @throws  \OutOfBoundsException  If there is no predecessor
	 *
	 * @since   1.0.0
	 */
	public function predecessor($element)
	{
		$predecessor = $element->predecessor;

		if ($predecessor)
		{
			return $predecessor;
		}
		else
		{
			throw new \OutOfBoundsException('Predecessor element unexisting');
		}
	}

	/**
	 * Get the successor element or throw an exception if there is no such element
	 *
	 * @param   TreeNode  $element  A tree node member of the underlying TreeMap
	 *
	 * @return  mixed  The successor element
	 *
	 * @throws  \OutOfBoundsException  If there is no successor
	 *
	 * @since   1.0.0
	 */
	public function successor($element)
	{
		$successor = $element->successor;

		if ($successor)
		{
			return $successor;
		}
		else
		{
			throw new \OutOfBoundsException('Successor element unexisting');
		}
	}

	/**
	 * Returns the element whose key is the greatest key lesser than the given key or throw an exception if there is no such element
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found element
	 *
	 * @throws  \OutOfBoundsException  If there is no lower element
	 *
	 * @since   1.0.0
	 */
	public function lower($key)
	{
		if ($this->root)
		{
			$lower = $this->root->find($key, $this->comparator, -2);
		}
		else
		{
			$lower = null;
		}

		if ($lower)
		{
			return $lower;
		}
		else
		{
			throw new \OutOfBoundsException('Lower element unexisting');
		}
	}

	/**
	 * Returns the element whose key is the greatest key lesser than or equal to the given key or throw an exception if there is no such element
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found element
	 *
	 * @throws  \OutOfBoundsException  If there is no floor element
	 *
	 * @since   1.0.0
	 */
	public function floor($key)
	{
		if ($this->root)
		{
			$floor = $this->root->find($key, $this->comparator, -1);
		}
		else
		{
			$floor = null;
		}

		if ($floor)
		{
			return $floor;
		}
		else
		{
			throw new \OutOfBoundsException('Floor element unexisting');
		}
	}

	/**
	 * Returns the element whose key is equal to the given key or throw an exception if there is no such element
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found element
	 *
	 * @throws  \OutOfBoundsException  If there is no such element
	 *
	 * @since   1.0.0
	 */
	public function find($key)
	{
		if ($this->root)
		{
			$find = $this->root->find($key, $this->comparator, 0);
		}
		else
		{
			$find = null;
		}

		if ($find)
		{
			return $find;
		}
		else
		{
			throw new \OutOfBoundsException('Element unexisting');
		}
	}

	/**
	 * Returns the element whose key is the lowest key greater than or equal to the given key or throw an exception if there is no such element
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found element
	 *
	 * @throws  \OutOfBoundsException  If there is no ceiling element
	 *
	 * @since   1.0.0
	 */
	public function ceiling($key)
	{
		if ($this->root)
		{
			$ceiling = $this->root->find($key, $this->comparator, 1);
		}
		else
		{
			$ceiling = null;
		}

		if ($ceiling)
		{
			return $ceiling;
		}
		else
		{
			throw new \OutOfBoundsException('Ceiling element unexisting');
		}
	}

	/**
	 * Returns the element whose key is the lowest key greater than to the given key or throw an exception if there is no such element
	 *
	 * @param   mixed  $key  The searched key
	 *
	 * @return  mixed  The found element
	 *
	 * @throws  \OutOfBoundsException  If there is no higher element
	 *
	 * @since   1.0.0
	 */
	public function higher($key)
	{
		if ($this->root)
		{
			$higher = $this->root->find($key, $this->comparator, 2);
		}
		else
		{
			$higher = null;
		}

		if ($higher)
		{
			return $higher;
		}
		else
		{
			throw new \OutOfBoundsException('Higher element unexisting');
		}
	}

	/**
	 * Put values in the map
	 *
	 * @param   \Traversable  $traversable  Values to put in the map
	 *
	 * @return  TreeMap  $this for chaining
	 *
	 * @since   1.0.0
	 */
	public function put($traversable = [])
	{
		foreach ($traversable as $key => $value)
		{
			$this[$key] = $value;
		}

		return $this;
	}

	/**
	 * Clear the map
	 *
	 * @return  TreeMap  $this for chaining
	 *
	 * @since   1.0.0
	 */
	public function clear()
	{
		$this->root = null;

		return $this;
	}

	/**
	 * Initialise the map
	 *
	 * @param   \Traversable  $traversable  Values to initialise the map
	 *
	 * @return  TreeMap  $this for chaining
	 *
	 * @since   1.0.0
	 */
	public function initialise($traversable = [])
	{
		return $this->clear()->put($traversable);
	}

	/**
	 * Clone the map
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function __clone()
	{
		if ($this->root != null)
		{
			$root = $this->root;
			$this->root = null;
			$node = $root->first;

			while ($node != null)
			{
				$this[$node->key] = $node->value;
				$node = $node->successor;
			}
		}
	}

	/**
	 * Serialize the object
	 *
	 * @return  array  Array of values
	 *
	 * @since   1.0.0
	 */
	public function jsonSerialize()
	{
		$array = [];

		foreach ($this as $key => $value)
		{
			$array[$key] = $value;
		}

		return ['TreeMap' => $array];
	}

	/**
	 * Set the value for a key
	 *
	 * @param   mixed  $key    The key
	 * @param   mixed  $value  The value
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function offsetSet($key, $value)
	{
		if ($this->root)
		{
			$this->root = $this->root->insert($key, $value, $this->comparator);
		}
		else
		{
			$this->root = TreeNode::create($key, $value);
		}
	}

	/**
	 * Unset the existence of a key
	 *
	 * @param   mixed  $key  The key
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function offsetUnset($key)
	{
		if ($this->root)
		{
			$this->root = $this->root->remove($key, $this->comparator);
		}
	}

	/**
	 * Count the number of key/value pairs
	 *
	 * @return  integer
	 *
	 * @since   1.0.0
	 */
	public function count()
	{
		if ($this->root)
		{
			return count($this->root);
		}
		else
		{
			return 0;
		}
	}
}
