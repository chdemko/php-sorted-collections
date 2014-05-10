<?php

/**
 * chdemko\SortedCollection\SubSet class
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
 * Sub set
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @since       1.0.0
 *
 * @property       mixed      $from           The from element
 * @property       boolean    $fromInclusive  The from inclusive flag
 * @property       mixed      $to             The to element
 * @property       boolean    $toInclusive    The to inclusive flag
 * @property-read  callable   $comparator     The element comparison function
 * @property-read  mixed      $first          The first element of the set
 * @property-read  mixed      $last           The last element of the set
 * @property-read  integer    $count          The number of elements in the set
 * @property-read  SortedSet  $set            The underlying set
 */
class SubSet extends AbstractSet
{
	/**
	 * When the from or to value is unused
	 *
	 * @since  1.0.0
	 */
	const UNUSED = 0;

	/**
	 * When the from or to value is inclusive
	 *
	 * @since  1.0.0
	 */
	const INCLUSIVE = 1;

	/**
	 * When the from or to value is exclusive
	 *
	 * @since  1.0.0
	 */
	const EXCLUSIVE = 2;

	/**
	 * @var     SortedSet  Internal set
	 *
	 * @since   1.0.0
	 */
	private $set;

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
			case 'from':
				return $this->getMap()->fromKey;
			break;
			case 'to':
				return $this->getMap()->toKey;
			break;
			case 'fromInclusive':
				return $this->getMap()->fromInclusive;
			break;
			case 'toInclusive':
				return $this->getMap()->toInclusive;
			break;
			case 'set':
				return $this->set;
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
			case 'from':
				$this->getMap()->fromKey = $value;
			break;
			case 'to':
				$this->getMap()->toKey = $value;
			break;
			case 'fromInclusive':
				$this->getMap()->fromInclusive = $value;
			break;
			case 'toInclusive':
				$this->getMap()->toInclusive = $value;
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
			case 'from':
				unset($this->getMap()->fromKey);
			break;
			case 'to':
				unset($this->getMap()->toKey);
			break;
			case 'fromInclusive':
				unset($this->getMap()->fromInclusive);
			break;
			case 'toInclusive':
				unset($this->getMap()->toInclusive);
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
			case 'from':
				return isset($this->getMap()->fromKey);
			break;
			case 'to':
				return isset($this->getMap()->toKey);
			break;
			case 'fromInclusive':
				return isset($this->getMap()->fromInclusive);
			break;
			case 'toInclusive':
				return isset($this->getMap()->toInclusive);
			break;
			default:
				return false;
			break;
		}
	}

	/**
	 * Constructor
	 *
	 * @param   SortedSet  $set         Internal set
	 * @param   mixed      $from        The from element
	 * @param   integer    $fromOption  The option for from (SubSet::UNUSED, SubSet::INCLUSIVE or SubSet::EXCLUSIVE)
	 * @param   mixed      $to          The to element
	 * @param   integer    $toOption    The option for to (SubSet::UNUSED, SubSet::INCLUSIVE or SubSet::EXCLUSIVE)
	 *
	 * @since   1.0.0
	 */
	protected function __construct(SortedSet $set, $from, $fromOption, $to, $toOption)
	{
		if ($fromOption == self::UNUSED)
		{
			if ($toOption == self::UNUSED)
			{
				$this->setMap(SubMap::view($set->getMap()));
			}
			else
			{
				$this->setMap(SubMap::head($set->getMap(), $to, $toOption == self::INCLUSIVE));
			}
		}
		elseif ($toOption == self::UNUSED)
		{
			$this->setMap(SubMap::tail($set->getMap(), $from, $fromOption == self::INCLUSIVE));
		}
		else
		{
			$this->setMap(SubMap::create($set->getMap(), $from, $to, $fromOption == self::INCLUSIVE, $toOption == self::INCLUSIVE));
		}

		$this->set = $set;
	}

	/**
	 * Create
	 *
	 * @param   SortedSet  $set            Internal set
	 * @param   mixed      $from           The from element
	 * @param   mixed      $to             The to element
	 * @param   boolean    $fromInclusive  The inclusive flag for from
	 * @param   boolean    $toInclusive    The inclusive flag for to
	 *
	 * @return  SubSet  A new sub set
	 *
	 * @since   1.0.0
	 */
	static public function create(SortedSet $set, $from, $to, $fromInclusive = true, $toInclusive = false)
	{
		return new static($set, $from, $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE, $to, $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE);
	}

	/**
	 * Head
	 *
	 * @param   SortedSet  $set          Internal set
	 * @param   mixed      $to           The to element
	 * @param   boolean    $toInclusive  The inclusive flag for to
	 *
	 * @return  SubSet  A new head set
	 *
	 * @since   1.0.0
	 */
	static public function head(SortedSet $set, $to, $toInclusive = false)
	{
		return new static($set, null, self::UNUSED, $to, $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE);
	}

	/**
	 * Tail
	 *
	 * @param   SortedSet  $set            Internal set
	 * @param   mixed      $from           The from element
	 * @param   boolean    $fromInclusive  The inclusive flag for from
	 *
	 * @return  SubSet  A new tail set
	 *
	 * @since   1.0.0
	 */
	static public function tail(SortedSet $set, $from, $fromInclusive = true)
	{
		return new static($set, $from, $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE, null, self::UNUSED);
	}

	/**
	 * View
	 *
	 * @param   SortedSet  $set  Internal set
	 *
	 * @return  SubSet  A new sub set
	 *
	 * @since   1.0.0
	 */
	static public function view(SortedSet $set)
	{
		return new static($set, null, self::UNUSED, null, self::UNUSED);
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
		if (isset($this->from))
		{
			if (isset($this->to))
			{
				return [
					'SubSet' => [
						'set' => $this->set->jsonSerialize(),
						'from' => $this->from,
						'fromInclusive' => $this->fromInclusive,
						'to' => $this->to,
						'toInclusive' => $this->toInclusive,
					]
				];
			}
			else
			{
				return [
					'TailSet' => [
						'set' => $this->set->jsonSerialize(),
						'from' => $this->from,
						'fromInclusive' => $this->fromInclusive,
					]
				];
			}
		}
		else
		{
			if (isset($this->to))
			{
				return [
					'HeadSet' => [
						'set' => $this->set->jsonSerialize(),
						'to' => $this->to,
						'toInclusive' => $this->toInclusive,
					]
				];
			}
			else
			{
				return [
					'ViewSet' => [
						'set' => $this->set->jsonSerialize(),
					]
				];
			}
		}
	}
}
