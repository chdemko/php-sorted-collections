<?php

/**
 * chdemko\SortedCollection\SubSetTest class
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
 * SubSet class test
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @since       1.0.0
 */
class SubSetTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Data provider for test_create
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_create()
	{
		return array(
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 2, 7, true, false, '[2,3,4,5,6]'),
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 2, 7, true, true, '[2,3,4,5,6,7]'),
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 2, 7, false, false, '[3,4,5,6]'),
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 2, 7, false, true, '[3,4,5,6,7]'),
		);
	}

	/**
	 * Tests  SubSet::create
	 *
	 * @param   array     $values         Initial values
	 * @param   mixed     $from           From element
	 * @param   mixed     $to             To element
	 * @param   boolean   $fromInclusive  From inclusive flag
	 * @param   boolean   $toInclusive    To inclusive flag
	 * @param   callable  $string         String representation
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__construct
	 * @covers  chdemko\SortedCollection\SubSet::create
	 *
	 * @dataProvider  cases_create
	 *
	 * @since   1.0.0
	 */
	public function test_create($values, $from, $to, $fromInclusive, $toInclusive, $string)
	{
		$set = TreeSet::create()->initialise($values);
		$sub = SubSet::create($set, $from, $to, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$string,
			(string) $sub
		);
	}

	/**
	 * Data provider for test_head
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_head()
	{
		return array(
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 7, false, '[0,1,2,3,4,5,6]'),
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 7, true, '[0,1,2,3,4,5,6,7]'),
		);
	}

	/**
	 * Tests  SubSet::head
	 *
	 * @param   array     $values       Initial values
	 * @param   mixed     $to           To element
	 * @param   boolean   $toInclusive  To inclusive flag
	 * @param   callable  $string       String representation
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__construct
	 * @covers  chdemko\SortedCollection\SubSet::head
	 *
	 * @dataProvider  cases_head
	 *
	 * @since   1.0.0
	 */
	public function test_head($values, $to, $toInclusive, $string)
	{
		$set = TreeSet::create()->initialise($values);
		$head = SubSet::head($set, $to, $toInclusive);
		$this->assertEquals(
			$string,
			(string) $head
		);
	}

	/**
	 * Data provider for test_tail
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_tail()
	{
		return array(
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 2, false, '[3,4,5,6,7,8,9]'),
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 2, true, '[2,3,4,5,6,7,8,9]'),
		);
	}

	/**
	 * Tests  SubSet::tail
	 *
	 * @param   array     $values         Initial values
	 * @param   mixed     $from           To element
	 * @param   boolean   $fromInclusive  To inclusive flag
	 * @param   callable  $string         String representation
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__construct
	 * @covers  chdemko\SortedCollection\SubSet::tail
	 *
	 * @dataProvider  cases_tail
	 *
	 * @since   1.0.0
	 */
	public function test_tail($values, $from, $fromInclusive, $string)
	{
		$set = TreeSet::create()->initialise($values);
		$tail = SubSet::tail($set, $from, $fromInclusive);
		$this->assertEquals(
			$string,
			(string) $tail
		);
	}

	/**
	 * Tests  SubSet::view
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__construct
	 * @covers  chdemko\SortedCollection\SubSet::view
	 *
	 * @since   1.0.0
	 */
	public function test_view()
	{
		$set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$view = SubSet::view($set);
		$this->assertEquals(
			(string) $set,
			(string) $view
		);
	}

	/**
	 * Tests  SubSet::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__get
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get()
	{
		$set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 8, 9));
		$sub = SubSet::create($set, 2, 7);
		$this->assertEquals(
			$set,
			$sub->set
		);
		$this->assertEquals(
			2,
			$sub->first
		);
		$this->assertEquals(
			2,
			$sub->from
		);
		$this->assertEquals(
			7,
			$sub->to
		);
		$this->assertEquals(
			true,
			$sub->fromInclusive
		);
		$this->assertEquals(
			false,
			$sub->toInclusive
		);
	}

	/**
	 * Tests  SubSet::__set
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__set
	 *
	 * @since   1.0.0
	 */
	public function test___set()
	{
		$set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 8, 9));
		$sub = SubSet::create($set, 2, 7);
		$sub->from = 3;
		$sub->fromInclusive = false;
		$sub->to = 6;
		$sub->toInclusive = true;
		$this->assertEquals(
			3,
			$sub->from
		);
		$this->assertEquals(
			6,
			$sub->to
		);
		$this->assertEquals(
			false,
			$sub->fromInclusive
		);
		$this->assertEquals(
			true,
			$sub->toInclusive
		);

		$this->setExpectedException('OutOfBoundsException');
		$sub->unexisting = true;
	}

	/**
	 * Generates a sub set
	 *
	 * @param   mixed  $from           The from element
	 * @param   mixed  $to             The to element
	 * @param   mixed  $fromInclusive  The from inclusive flag
	 * @param   mixed  $toInclusive    The to inclusive flag	 
	 *
	 * @return  SubMap  A sub map
	 *
	 * @since   1.0.0
	 */
	protected function createSub($from, $to, $fromInclusive, $toInclusive)
	{
		$set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		if ($fromInclusive === null)
		{
			if ($toInclusive === null)
			{
				$sub = SubSet::view($set);
			}
			else
			{
				$sub = SubSet::head($set, $to, $toInclusive);
			}
		}
		elseif ($toInclusive === null)
		{
			$sub = SubSet::tail($set, $from, $fromInclusive);
		}
		else
		{
			$sub = SubSet::create($set, $from, $to, $fromInclusive, $toInclusive);
		}

		return $sub;
	}

	/**
	 * Tests  SubSet::__unset and SubSet::__isset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::__unset
	 * @covers  chdemko\SortedCollection\SubSet::__isset
	 *
	 * @since   1.0.0
	 */
	public function test___unset_isset()
	{
		$set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 8, 9));
		$sub = SubSet::create($set, 2, 7);
		unset($sub->from);
		unset($sub->fromInclusive);
		unset($sub->to);
		unset($sub->toInclusive);
		$this->assertEquals(
			false,
			isset($sub->from)
		);
		$this->assertEquals(
			false,
			isset($sub->to)
		);
		$this->assertEquals(
			false,
			isset($sub->fromInclusive)
		);
		$this->assertEquals(
			false,
			isset($sub->toInclusive)
		);
		$this->assertEquals(
			false,
			isset($sub->unexisting)
		);
	}

	/**
	 * Data provider for test_jsonSerialize
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_jsonSerialize()
	{
		return array(
			array(
				2,
				7,
				true,
				false,
				'{"SubSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"from":2,"fromInclusive":true,"to":7,"toInclusive":false}}'
			),
			array(
				2,
				7,
				false,
				false,
				'{"SubSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"from":2,"fromInclusive":false,"to":7,"toInclusive":false}}'
			),
			array(
				2,
				7,
				false,
				true,
				'{"SubSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"from":2,"fromInclusive":false,"to":7,"toInclusive":true}}'
			),
			array(
				2,
				7,
				true,
				true,
				'{"SubSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"from":2,"fromInclusive":true,"to":7,"toInclusive":true}}'
			),
			array(
				9,
				-1,
				true,
				false,
				'{"SubSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"from":9,"fromInclusive":true,"to":-1,"toInclusive":false}}'
			),
			array(
				null,
				7,
				null,
				true,
				'{"HeadSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"to":7,"toInclusive":true}}'
			),
			array(
				2,
				null,
				true,
				null,
				'{"TailSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]},"from":2,"fromInclusive":true}}'
			),
			array(
				null,
				null,
				null,
				null,
				'{"ViewSet":{"set":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]}}}'
			),
		);
	}

	/**
	 * Tests  SubSet::jsonSerialize
	 *
	 * @param   mixed  $fromKey        The from key
	 * @param   mixed  $toKey          The to key
	 * @param   mixed  $fromInclusive  The from inclusive flag
	 * @param   mixed  $toInclusive    The to inclusive flag
	 * @param   mixed  $string         The expected string
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubSet::jsonSerialize
	 *
	 * @dataProvider  cases_jsonSerialize
	 *
	 * @since   1.0.0
	 */
	public function test_jsonSerialize($fromKey, $toKey, $fromInclusive, $toInclusive, $string)
	{
		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$string,
			json_encode($sub)
		);
	}
}
