<?php

/**
 * chdemko\SortedCollection\ReversedMapTest class
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
 * ReversedMap class test
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 */
class ReversedMapTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Tests  ReversedMap::__construct
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::__construct
	 * @covers  chdemko\SortedCollection\ReversedMap::create
	 * @covers  chdemko\SortedCollection\ReversedMap::__get
	 * @covers  chdemko\SortedCollection\ReversedMap::comparator
	 *
	 * @since   1.0.0
	 */
	public function test___construct()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			$tree,
			$reversed->map
		);

		$this->assertEquals(
			-call_user_func($tree->comparator, 4, 6),
			call_user_func($reversed->comparator, 4, 6)
		);

		$reversed_reversed = ReversedMap::create($reversed);

		$this->assertEquals(
			$tree,
			$reversed_reversed->map->map
		);

		$this->assertEquals(
			call_user_func($tree->comparator, 4, 6),
			call_user_func($reversed_reversed->comparator, 4, 6)
		);
	}

	/**
	 * Tests  ReversedMap::first
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::first
	 *
	 * @since   1.0.0
	 */
	public function test_first()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			9,
			$reversed->first->key
		);
	}

	/**
	 * Tests  ReversedMap::last
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::last
	 *
	 * @since   1.0.0
	 */
	public function test_last()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			0,
			$reversed->last->key
		);
	}

	/**
	 * Tests  ReversedMap::predecessor
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::predecessor
	 * @covers  chdemko\SortedCollection\AbstractMap::predecessor
	 *
	 * @since   1.0.0
	 */
	public function test_predecessor()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);
		$this->assertEquals(
			1,
			$reversed->predecessor($reversed->last)->key
		);
		$this->setExpectedException('OutOfBoundsException');
		$predecessor = $reversed->predecessor($reversed->first);
	}

	/**
	 * Tests  ReversedMap::successor
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::successor
	 * @covers  chdemko\SortedCollection\AbstractMap::successor
	 *
	 * @since   1.0.0
	 */
	public function test_successor()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);
		$this->assertEquals(
			8,
			$reversed->successor($reversed->first)->key
		);
		$this->setExpectedException('OutOfBoundsException');
		$successor = $reversed->successor($reversed->last);
	}

	/**
	 * Data provider for test_lowerKey
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_lowerKey()
	{
		return array(
			array(array(), 10, null, 'OutOfBoundsException'),
			array(array(1 => 1), 1, null, 'OutOfBoundsException'),
			array(array(1 => 1, 0 => 0), 0, 1, null),
			array(array(2 => 2, 1 => 1), 0, 1, null),
			array(array(0 => 0, 1 => 1), 1, null, 'OutOfBoundsException'),
			array(array(0 => 0, 1 => 1), 2, null, 'OutOfBoundsException'),
		);
	}

	/**
	 * Tests  ReversedMap::lower
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::lower
	 * @covers  chdemko\SortedCollection\AbstractMap::lowerKey
	 *
	 * @dataProvider  cases_lowerKey
	 *
	 * @since   1.0.0
	 */
	public function test_lowerKey($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			$expected,
			$reversed->lowerKey($key)
		);
	}

	/**
	 * Data provider for test_floorKey
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_floorKey()
	{
		return array(
			array(array(), 10, null, 'OutOfBoundsException'),
			array(array(1 => 1), 1, 1, null),
			array(array(1 => 1, 0 => 0), 0, 0, null),
			array(array(2 => 2, 1 => 1), 0, 1, null),
			array(array(0 => 0, 1 => 1), 1, 1, null),
			array(array(0 => 0, 1 => 1), 2, null, 'OutOfBoundsException'),
		);
	}

	/**
	 * Tests  ReversedMap::floor
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $found      Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::floor
	 * @covers  chdemko\SortedCollection\AbstractMap::floorKey
	 *
	 * @dataProvider  cases_floorKey
	 *
	 * @since   1.0.0
	 */
	public function test_floorKey($values, $key, $found, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			$found,
			$reversed->floorKey($key)
		);
	}

	/**
	 * Tests  ReversedMap::find
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::find
	 * @covers  chdemko\SortedCollection\AbstractMap::findKey
	 *
	 * @since   1.0.0
	 */
	public function test_findKey()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			0,
			$reversed->findKey(0)
		);

		$tree->clear();
		$this->setExpectedException('OutOfBoundsException');

		$key = $reversed->findKey(10);
	}

	/**
	 * Data provider for test_ceilingKey
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_ceilingKey()
	{
		return array(
			array(array(), 10, null, 'OutOfBoundsException'),
			array(array(1 => 1), 1, 1, null),
			array(array(1 => 1, 0 => 0), 0, 0, null),
			array(array(2 => 2, 1 => 1), 0, null, 'OutOfBoundsException'),
			array(array(0 => 0, 1 => 1), 1, 1, null),
			array(array(0 => 0, 1 => 1), 2, 1, null),
		);
	}

	/**
	 * Tests  ReversedMap::ceiling
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::ceiling
	 * @covers  chdemko\SortedCollection\AbstractMap::floorKey
	 *
	 * @dataProvider  cases_ceilingKey
	 *
	 * @since   1.0.0
	 */
	public function test_ceilingKey($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			$expected,
			$reversed->ceilingKey($key)
		);
	}

	/**
	 * Data provider for test_higherKey
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_higherKey()
	{
		return array(
			array(array(), 10, null, 'OutOfBoundsException'),
			array(array(1 => 1), 1, null, 'OutOfBoundsException'),
			array(array(1 => 1, 0 => 0), 0, null, 'OutOfBoundsException'),
			array(array(2 => 2, 1 => 1), 0, null, 'OutOfBoundsException'),
			array(array(0 => 0, 1 => 1), 1, 0, null),
			array(array(0 => 0, 1 => 1), 2, 1, null),
		);
	}

	/**
	 * Tests  ReversedMap::higher
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::higher
	 * @covers  chdemko\SortedCollection\AbstractMap::higherKey
	 *
	 * @dataProvider  cases_higherKey
	 *
	 * @since   1.0.0
	 */
	public function test_higherKey($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			$expected,
			$reversed->higherKey($key)
		);
	}

	/**
	 * Tests  ReversedMap::keys
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::keys
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_keys()
	{
		$empty = true;
		$tree = TreeMap::create();
		$reversed = ReversedMap::create($tree);

		foreach ($reversed->keys as $key)
		{
			$empty = false;
		}

		$this->assertEquals(true, $empty);

		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);
		$i = 9;

		foreach ($reversed->keys as $key)
		{
			$this->assertEquals($i, $key);
			$i--;
		}
	}

	/**
	 * Tests  AbstractMap::values
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::values
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_values()
	{
		$empty = true;
		$tree = TreeMap::create();
		$reversed = ReversedMap::create($tree);

		foreach ($reversed->values as $value)
		{
			$empty = false;
		}

		$this->assertEquals(true, $empty);

		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);
		$i = 9;

		foreach ($reversed->values as $value)
		{
			$this->assertEquals($i, $value);
			$i--;
		}
	}

	/**
	 * Data provider for test_offsetGet
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_offsetGet()
	{
		return array(
			array(array(), 10, null, 'OutOfRangeException'),
			array(array(1 => 1), 1, 1, null),
			array(array(1 => 1, 0 => 0), 0, 0, null),
			array(array(2 => 2, 1 => 1), 0, null, 'OutOfRangeException'),
			array(array(0 => 0, 1 => 1), 1, 1, null),
			array(array(0 => 0, 1 => 1), 2, null, 'OutOfRangeException'),
		);
	}

	/**
	 * Tests  AbstractMap::offsetGet
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $value      Expected value
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::offsetGet
	 *
	 * @dataProvider  cases_offsetGet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetGet($values, $key, $value, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			$value,
			$reversed[$key]
		);
	}

	/**
	 * Tests  AbstractMap::offsetSet
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::offsetSet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetSet()
	{
		$this->setExpectedException('RuntimeException');

		$tree = TreeMap::create();
		$reversed = ReversedMap::create($tree);
		$reversed[0] = 0;
	}

	/**
	 * Tests  ReversedMap::offsetExists
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::offsetExists
	 *
	 * @since   1.0.0
	 */
	public function test_offsetExists()
	{
		$tree = TreeMap::create();
		$reversed = ReversedMap::create($tree);

		$this->assertFalse(
			isset($reversed[10])
		);

		$tree->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		$this->assertTrue(
			isset($reversed[5])
		);
		$this->assertFalse(
			isset($reversed[10])
		);
	}

	/**
	 * Tests  AbstractMap::offsetUnset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::offsetUnset
	 *
	 * @since   1.0.0
	 */
	public function test_offsetUnset()
	{
		$this->setExpectedException('RuntimeException');

		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
		$reversed = ReversedMap::create($tree);
		unset($reversed[0]);
	}

	/**
	 * Tests  ReversedMap::count
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::count
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_count()
	{
		$tree = TreeMap::create();
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			0,
			$reversed->count
		);

		$tree->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		$this->assertEquals(
			10,
			count($reversed)
		);
	}

	/**
	 * Tests  ReversedMap::jsonSerialize
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\ReversedMap::jsonSerialize
	 *
	 * @since   1.0.0
	 */
	public function test_jsonSerialize()
	{
		$tree = TreeMap::create();
		$reversed = ReversedMap::create($tree);

		$this->assertEquals(
			'{"ReversedMap":{"TreeMap":[]}}',
			json_encode($reversed)
		);

		$tree->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		$this->assertEquals(
			'{"ReversedMap":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]}}',
			json_encode($reversed)
		);
	}
}
