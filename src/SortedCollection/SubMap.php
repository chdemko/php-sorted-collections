<?php

/**
 * chdemko\SortedCollection\SubMap class
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
 * Sub map
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 *
 * @property       mixed      $fromKey        The from key
 * @property       boolean    $fromInclusive  The from inclusive flag
 * @property       mixed      $toKey          The to key
 * @property       boolean    $toInclusive    The to inclusive flag
 * @property-read  callable   $comparator     The key comparison function
 * @property-read  TreeNode   $first          The first element of the map
 * @property-read  mixed      $firstKey       The first key of the map
 * @property-read  TreeNode   $last           The last element of the map
 * @property-read  mixed      $lastKey        The last key of the map
 * @property-read  generator  $keys           The keys generator
 * @property-read  generator  $values         The values generator
 * @property-read  integer    $count          The number of elements in the map
 * @property-read  SortedMap  $map            The underlying map
 */
class SubMap extends AbstractMap
{
	/**
	 * When the from or to key is unused
	 *
	 * @since  1.0.0
	 */
	const UNUSED = 0;

	/**
	 * When the from or to key is inclusive
	 *
	 * @since  1.0.0
	 */
	const INCLUSIVE = 1;

	/**
	 * When the from or to key is exclusive
	 *
	 * @since  1.0.0
	 */
	const EXCLUSIVE = 2;

	/**
	 * @var     SortedMap  Internal map
	 *
	 * @since   1.0.0
	 */
	protected $map;

	/**
	 * @var     integer  from option
	 *
	 * @since  1.0.0
	 */
	protected $fromOption;

	/**
	 * @var     mixed  from key
	 *
	 * @since  1.0.0
	 */
	protected $fromKey;

	/**
	 * @var     integer  to option
	 *
	 * @since  1.0.0
	 */
	protected $toOption;

	/**
	 * @var     mixed  to key
	 *
	 * @since  1.0.0
	 */
	protected $toKey;

	/**
	 * @var     boolean  Empty flag
	 *
	 * @since  1.0.0
	 */
	protected $empty;

	/**
	 * Magic get method
	 *
	 * @param   string  $property  The property
	 *
	 * @throws  \OutOfBoundsException  If the property does not exist
	 *
	 * @return  mixed  The value associated to the property
	 *
	 * @since  1.0.0
	 */
	public function __get($property)
	{
		switch ($property)
		{
			case 'fromKey':
				if ($this->fromOption == self::UNUSED)
				{
					throw new \OutOfBoundsException('Undefined property');
				}
				else
				{
					return $this->fromKey;
				}
			break;
			case 'toKey':
				if ($this->toOption == self::UNUSED)
				{
					throw new \OutOfBoundsException('Undefined property');
				}
				else
				{
					return $this->toKey;
				}
			break;
			case 'fromInclusive':
				if ($this->fromOption == self::UNUSED)
				{
					throw new \OutOfBoundsException('Undefined property');
				}
				else
				{
					return $this->fromOption == self::INCLUSIVE;
				}
			break;
			case 'toInclusive':
				if ($this->toOption == self::UNUSED)
				{
					throw new \OutOfBoundsException('Undefined property');
				}
				else
				{
					return $this->toOption == self::INCLUSIVE;
				}
			break;
			case 'map':
				return $this->map;
			break;
			default:
				return parent::__get($property);
			break;
		}
	}

	/**
	 * Magic set method
	 *
	 * @param   string  $property  The property
	 * @param   mixed   $value     The new value
	 *
	 * @throws  \OutOfBoundsException  If the property does not exist
	 *
	 * @return  void
	 *
	 * @since  1.0.0
	 */
	public function __set($property, $value)
	{
		switch ($property)
		{
			case 'fromKey':
				$this->fromKey = $value;

				if ($this->fromOption == self::UNUSED)
				{
					$this->fromOption = self::INCLUSIVE;
				}
			break;
			case 'toKey':
				$this->toKey = $value;

				if ($this->toOption == self::UNUSED)
				{
					$this->toOption = self::EXCLUSIVE;
				}
			break;
			case 'fromInclusive':
				if ($this->fromOption == self::UNUSED)
				{
					throw new \OutOfBoundsException('Undefined property');
				}
				else
				{
					$this->fromOption = $value ? self::INCLUSIVE : self::EXCLUSIVE;
				}
			break;
			case 'toInclusive':
				if ($this->toOption == self::UNUSED)
				{
					throw new \OutOfBoundsException('Undefined property');
				}
				else
				{
					$this->toOption = $value ? self::INCLUSIVE : self::EXCLUSIVE;
				}
			break;
			default:
				throw new \OutOfBoundsException('Undefined property');
			break;
		}
	}

	/**
	 * Magic unset method
	 *
	 * @param   string  $property  The property
	 *
	 * @throws  \OutOfBoundsException  If the property does not exist
	 *
	 * @return  void
	 *
	 * @since  1.0.0
	 */
	public function __unset($property)
	{
		switch ($property)
		{
			case 'fromKey':
			case 'fromInclusive':
				$this->fromOption = self::UNUSED;
			break;
			case 'toKey':
			case 'toInclusive':
				$this->toOption = self::UNUSED;
			break;
		}
	}

	/**
	 * Magic isset method
	 *
	 * @param   string  $property  The property
	 *
	 * @throws  \OutOfBoundsException  If the property does not exist
	 *
	 * @return  void
	 *
	 * @since  1.0.0
	 */
	public function __isset($property)
	{
		switch ($property)
		{
			case 'fromKey':
			case 'fromInclusive':
				return $this->fromOption != self::UNUSED;
			break;
			case 'toKey':
			case 'toInclusive':
				return $this->toOption != self::UNUSED;
			break;
			default:
				return false;
			break;
		}
	}

	/**
	 * Constructor
	 *
	 * @param   SortedMap  $map         Internal map
	 * @param   mixed      $fromKey     The from key
	 * @param   integer    $fromOption  The option for from (SubMap::UNUSED, SubMap::INCLUSIVE or SubMap::EXCLUSIVE)
	 * @param   mixed      $toKey       The to key
	 * @param   integer    $toOption    The option for to (SubMap::UNUSED, SubMap::INCLUSIVE or SubMap::EXCLUSIVE)
	 *
	 * @since   1.0.0
	 */
	protected function __construct(SortedMap $map, $fromKey, $fromOption, $toKey, $toOption)
	{
		$this->map = $map;
		$this->fromKey = $fromKey;
		$this->fromOption = $fromOption;
		$this->toKey = $toKey;
		$this->toOption = $toOption;

		if ($fromOption != self::UNUSED && $toOption != self::UNUSED)
		{
			$cmp = call_user_func($map->comparator(), $fromKey, $toKey);

			$this->empty = $cmp > 0 || $cmp == 0 && ($fromOption == self::EXCLUSIVE || $toOption == self::EXCLUSIVE);
		}
		else
		{
			$this->empty = false;
		}
	}

	/**
	 * Create
	 *
	 * @param   SortedMap  $map            A sorted map
	 * @param   mixed      $fromKey        The from key
	 * @param   mixed      $toKey          The to key
	 * @param   boolean    $fromInclusive  The inclusive flag for from
	 * @param   boolean    $toInclusive    The inclusive flag for to
	 *
	 * @return  SubMap  A new sub map
	 *
	 * @since  1.0.0
	 */
	static public function create(SortedMap $map, $fromKey, $toKey, $fromInclusive = true, $toInclusive = false)
	{
		return new static($map, $fromKey, $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE, $toKey, $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE);
	}

	/**
	 * Return a head portion of a sorted map
	 *
	 * @param   SortedMap  $map          A sorted map
	 * @param   mixed      $toKey        The to key
	 * @param   boolean    $toInclusive  The inclusive flag for to
	 *
	 * @return  SubMap  A new head map
	 *
	 * @since  1.0.0
	 */
	static public function head(SortedMap $map, $toKey, $toInclusive = false)
	{
		return new static($map, null, self::UNUSED, $toKey, $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE);
	}

	/**
	 * Return a tail portion of a sorted map
	 *
	 * @param   SortedMap  $map            A sorted map
	 * @param   mixed      $fromKey        The from key
	 * @param   boolean    $fromInclusive  The inclusive flag for from
	 *
	 * @return  SubMap  A new tail map
	 *
	 * @since  1.0.0
	 */
	static public function tail(SortedMap $map, $fromKey, $fromInclusive = true)
	{
		return new static($map, $fromKey, $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE, null, self::UNUSED);
	}

	/**
	 * Return a view of the map
	 *
	 * @param   SortedMap  $map  A sorted map
	 *
	 * @return  SubMap  A new sub map
	 *
	 * @since  1.0.0
	 */
	static public function view(SortedMap $map)
	{
		return new static($map, null, self::UNUSED, null, self::UNUSED);
	}

	/**
	 * Get the comparator
	 *
	 * @return  The comparator
	 *
	 * @since   1.0.0
	 */
	public function comparator()
	{
		return $this->map->comparator();
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
		if ($this->empty)
		{
			throw new \OutOfBoundsException('First element unexisting');
		}

		switch ($this->fromOption)
		{
			case self::INCLUSIVE:
				$first = $this->map->ceiling($this->fromKey);
			break;
			case self::EXCLUSIVE:
				$first = $this->map->higher($this->fromKey);
			break;
			default:
				$first = $this->map->first();
			break;
		}

		return $first;
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
		if ($this->empty)
		{
			throw new \OutOfBoundsException('Last element unexisting');
		}

		switch ($this->toOption)
		{
			case self::INCLUSIVE:
				$last = $this->map->floor($this->toKey);
			break;
			case self::EXCLUSIVE:
				$last = $this->map->lower($this->toKey);
			break;
			default:
				$last = $this->map->last();
			break;
		}

		return $last;
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
		$predecessor = $this->map->predecessor($element);

		if ($predecessor)
		{
			switch ($this->fromOption)
			{
				case self::INCLUSIVE:
					if (call_user_func($this->map->comparator(), $predecessor->key, $this->fromKey) < 0)
					{
						throw new \OutOfBoundsException('Predecessor element unexisting');
					}
				break;
				case self::EXCLUSIVE:
					if (call_user_func($this->map->comparator(), $predecessor->key, $this->fromKey) <= 0)
					{
						throw new \OutOfBoundsException('Predecessor element unexisting');
					}
				break;
			}
		}

		return $predecessor;
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
		$successor = $this->map->successor($element);

		if ($successor)
		{
			switch ($this->toOption)
			{
				case self::INCLUSIVE:
					if (call_user_func($this->map->comparator(), $successor->key, $this->toKey) > 0)
					{
						throw new \OutOfBoundsException('Successor element unexisting');
					}
				break;
				case self::EXCLUSIVE:
					if (call_user_func($this->map->comparator(), $successor->key, $this->toKey) >= 0)
					{
						throw new \OutOfBoundsException('Successor element unexisting');
					}
				break;
			}
		}

		return $successor;
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
		if ($this->empty)
		{
			throw new \OutOfBoundsException('Lower element unexisting');
		}

		switch ($this->fromOption)
		{
			case self::UNUSED:
				$lower = $this->map->lower($key);
			break;
			default:
				if (call_user_func($this->map->comparator(), $key, $this->fromKey) <= 0)
				{
					throw new \OutOfBoundsException('Lower element unexisting');
				}
				else
				{
					$lower = $this->map->lower($key);

					if ($this->fromOption == self::EXCLUSIVE && call_user_func($this->map->comparator(), $lower->key, $this->fromKey) <= 0)
					{
						throw new \OutOfBoundsException('Lower element unexisting');
					}
				}
			break;
		}

		if ($lower)
		{
			switch ($this->toOption)
			{
				case self::INCLUSIVE:
					if (call_user_func($this->map->comparator(), $lower->key, $this->toKey) > 0)
					{
						$lower = $this->last();
					}
				break;
				case self::EXCLUSIVE:
					if (call_user_func($this->map->comparator(), $lower->key, $this->toKey) >= 0)
					{
						$lower = $this->last();
					}
				break;
			}
		}

		return $lower;
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
		if ($this->empty)
		{
			throw new \OutOfBoundsException('Floor element unexisting');
		}

		switch ($this->fromOption)
		{
			case self::INCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->fromKey) < 0)
				{
					throw new \OutOfBoundsException('Floor element unexisting');
				}
				else
				{
					$floor = $this->map->floor($key);
				}
			break;
			case self::EXCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->fromKey) <= 0)
				{
					throw new \OutOfBoundsException('Floor element unexisting');
				}
				else
				{
					$floor = $this->map->floor($key);
				}
			break;
			default:
				$floor = $this->map->floor($key);
			break;
		}

		if ($floor)
		{
			switch ($this->toOption)
			{
				case self::INCLUSIVE:
					if (call_user_func($this->map->comparator(), $floor->key, $this->toKey) > 0)
					{
						$floor = $this->last();
					}
				break;
				case self::EXCLUSIVE:
					if (call_user_func($this->map->comparator(), $floor->key, $this->toKey) >= 0)
					{
						$floor = $this->last();
					}
				break;
			}
		}

		return $floor;
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
		switch ($this->fromOption)
		{
			case self::INCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->fromKey) < 0)
				{
					throw new \OutOfBoundsException('Element unexisting');
				}
			break;
			case self::EXCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->fromKey) <= 0)
				{
					throw new \OutOfBoundsException('Element unexisting');
				}
			break;
		}

		switch ($this->toOption)
		{
			case self::INCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->toKey) > 0)
				{
					throw new \OutOfBoundsException('Element unexisting');
				}
			break;
			case self::EXCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->toKey) >= 0)
				{
					throw new \OutOfBoundsException('Element unexisting');
				}
			break;
		}

		return $this->map->find($key);
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
		if ($this->empty)
		{
			throw new \OutOfBoundsException('Ceiling element unexisting');
		}

		switch ($this->toOption)
		{
			case self::INCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->toKey) > 0)
				{
					throw new \OutOfBoundsException('Ceiling element unexisting');
				}
				else
				{
					$ceiling = $this->map->ceiling($key);
				}
			break;
			case self::EXCLUSIVE:
				if (call_user_func($this->map->comparator(), $key, $this->toKey) >= 0)
				{
					throw new \OutOfBoundsException('Ceiling element unexisting');
				}
				else
				{
					$ceiling = $this->map->ceiling($key);
				}
			break;
			default:
				$ceiling = $this->map->ceiling($key);
			break;
		}

		if ($ceiling)
		{
			switch ($this->fromOption)
			{
				case self::INCLUSIVE:
					if (call_user_func($this->map->comparator(), $ceiling->key, $this->fromKey) < 0)
					{
						$ceiling = $this->first();
					}
				break;
				case self::EXCLUSIVE:
					if (call_user_func($this->map->comparator(), $ceiling->key, $this->fromKey) <= 0)
					{
						$ceiling = $this->first();
					}
				break;
			}
		}

		return $ceiling;
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
		if ($this->empty)
		{
			throw new \OutOfBoundsException('Higher element unexisting');
		}

		switch ($this->toOption)
		{
			case self::UNUSED:
				$higher = $this->map->higher($key);
			break;
			default:
				if (call_user_func($this->map->comparator(), $key, $this->toKey) >= 0)
				{
					throw new \OutOfBoundsException('Higher element unexisting');
				}
				else
				{
					$higher = $this->map->higher($key);

					if ($this->toOption == self::EXCLUSIVE && call_user_func($this->map->comparator(), $higher->key, $this->toKey) >= 0)
					{
					throw new \OutOfBoundsException('Higher element unexisting');
					}
				}
			break;
		}

		if ($higher)
		{
			switch ($this->fromOption)
			{
				case self::INCLUSIVE:
					if (call_user_func($this->map->comparator(), $higher->key, $this->fromKey) < 0)
					{
						$higher = $this->first();
					}
				break;
				case self::EXCLUSIVE:
					if (call_user_func($this->map->comparator(), $higher->key, $this->fromKey) <= 0)
					{
						$higher = $this->first();
					}
				break;
			}
		}

		return $higher;
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
		if ($this->fromOption == self::UNUSED)
		{
			if ($this->toOption == self::UNUSED)
			{
				return array(
					'ViewMap' => array(
						'map' => $this->map->jsonSerialize(),
					)
				);
			}
			else
			{
				return array(
					'HeadMap' => array(
						'map' => $this->map->jsonSerialize(),
						'toKey' => $this->toKey,
						'toInclusive' => $this->toOption == self::INCLUSIVE,
					)
				);
			}
		}
		else
		{
			if ($this->toOption == self::UNUSED)
			{
				return array(
					'TailMap' => array(
						'map' => $this->map->jsonSerialize(),
						'fromKey' => $this->fromKey,
						'fromInclusive' => $this->fromOption == self::INCLUSIVE,
					)
				);
			}
			else
			{
				return array(
					'SubMap' => array(
						'map' => $this->map->jsonSerialize(),
						'fromKey' => $this->fromKey,
						'fromInclusive' => $this->fromOption == self::INCLUSIVE,
						'toKey' => $this->toKey,
						'toInclusive' => $this->toOption == self::INCLUSIVE,
					)
				);
			}
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
		$count = 0;

		foreach ($this as $value)
		{
			$count++;
		}

		return $count;
	}
}
