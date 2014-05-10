<?php

/**
 * chdemko\SortedCollection\ReversedSet class
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
 * Reversed set
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @since       1.0.0
 *
 * @property-read  callable   $comparator  The element comparison function
 * @property-read  mixed      $first       The first element of the set
 * @property-read  mixed      $last        The last element of the set
 * @property-read  integer    $count       The number of elements in the set
 * @property-read  SortedSet  $set         The underlying set
 */
class ReversedSet extends AbstractSet
{
	/**
	 * @var     SortedSet  Internal set
	 *
	 * @since   1.0.0
	 */
	private $set;

	/**
	 * Constructor
	 *
	 * @param   SortedSet  $set  Internal set
	 *
	 * @since   1.0.0
	 */
	protected function __construct(SortedSet $set)
	{
		$this->setMap(ReversedMap::create($set->getMap()))->set = $set;
	}

	/**
	 * Create
	 *
	 * @param   SortedSet  $set  Internal set
	 *
	 * @return  ReversedSet  A new reversed set
	 *
	 * @since   1.0.0
	 */
	static public function create(SortedSet $set)
	{
		return new static($set);
	}

	/**
	 * Magic get method
	 *
	 * @param   string  $property  The property
	 *
	 * @return  mixed  The value associated to the property
	 *
	 * @since   1.0.0
	 */
	public function __get($property)
	{
		switch ($property)
		{
			case 'set':
				return $this->set;
			break;
			default:
				return parent::__get($property);
			break;
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
		return ['ReversedSet' => $this->set->jsonSerialize()];
	}
}
