<?php

/**
 * chdemko\SortedCollection\ReversedSetTest class
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
 * ReversedSet class test
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @since       1.0.0
 */
class ReversedSetTest extends \PHPUnit_Framework_TestCase
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
		return [
			[[], null, null, '[]'],
			[[0, 1, 2, 3, 4, 5, 6, 7, 8, 9], 3, null, '[9,8,7,6,5,4,3,2,1,0]'],
			[
				[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
				3,
				function ($key1, $key2)
				{
					return $key1 - $key2;
				},
				'[9,8,7,6,5,4,3,2,1,0]'
			]
		];
	}

	/**
	 * Tests  ReversedSet::create
	 *
	 * @param   array     $values      Initial values
	 * @param   mixed     $key         Expected root key
	 * @param   callable  $comparator  Comparator
	 * @param   callable  $string      String representation
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedSet::__construct
	 * @covers  chdemko\SortedCollection\ReversedSet::create
	 *
	 * @dataProvider  cases_create
	 *
	 * @since   1.0.0
	 */
	public function test_create($values, $key, $comparator, $string)
	{
		$set = TreeSet::create($comparator)->initialise($values);
		$reversed = ReversedSet::create($set);
		$this->assertEquals(
			$string,
			(string) $reversed
		);
	}

	/**
	 * Tests  ReversedSet::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedSet::__get
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get()
	{
		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$reversed = ReversedSet::create($set);
		$this->assertEquals(
			$set,
			$reversed->set
		);
		$this->assertEquals(
			9,
			$reversed->first
		);
	}

	/**
	 * Tests  ReversedSet::offsetSet
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedSet::offsetSet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetSet()
	{
		$this->setExpectedException('RuntimeException');

		$set = TreeSet::create();
		$reversed = ReversedSet::create($set);
		$reversed[0] = 0;
	}

	/**
	 * Tests  AbstractSet::offsetUnset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::offsetUnset
	 *
	 * @since   1.0.0
	 */
	public function test_offsetUnset()
	{
		$this->setExpectedException('RuntimeException');

		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$reversed = ReversedSet::create($set);
		unset($reversed[0]);
	}

	/**
	 * Tests  ReversedSet::jsonSerialize
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedSet::jsonSerialize
	 *
	 * @since   1.0.0
	 */
	public function test_jsonSerialize()
	{
		$set = TreeSet::create();
		$reversed = ReversedSet::create($set);

		$this->assertEquals(
			'{"ReversedSet":{"TreeSet":[]}}',
			json_encode($reversed)
		);

		$set->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			'{"ReversedSet":{"TreeSet":[0,1,2,3,4,5,6,7,8,9]}}',
			json_encode($reversed)
		);
	}
}
