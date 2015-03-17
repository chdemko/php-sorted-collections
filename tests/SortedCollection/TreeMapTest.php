<?php

/**
 * chdemko\SortedCollection\TreeMapTest class
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
 * TreeMap class test
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 */
class TreeMapTest extends \PHPUnit_Framework_TestCase
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
			[[], null, null],
			[[0, 1, 2, 3, 4, 5, 6, 7, 8, 9], 3, null],
			[
				[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
				3,
				function ($key1, $key2)
				{
					return $key1 - $key2;
				}
			]
		];
	}

	/**
	 * Tests  TreeMap::create
	 *
	 * @param   array     $values      Initial values
	 * @param   mixed     $key         Expected root key
	 * @param   callable  $comparator  Comparator
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::__construct
	 * @covers  chdemko\SortedCollection\TreeMap::create
	 * @covers  chdemko\SortedCollection\TreeMap::put
	 * @covers  chdemko\SortedCollection\TreeMap::initialise
	 *
	 * @dataProvider  cases_create
	 *
	 * @since   1.0.0
	 */
	public function test_create($values, $key, $comparator)
	{
		$tree = TreeMap::create($comparator)->initialise($values);

		if ($comparator !== null)
		{
			$this->assertEquals(
				$comparator,
				$tree->comparator
			);
		}
		else
		{
			$this->assertTrue(
				is_callable($tree->comparator)
			);
		}

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		if ($values)
		{
			$this->assertEquals(
				$key,
				$root->getValue($tree)->key
			);
		}
		else
		{
			$this->assertEquals(
				null,
				$root->getValue($tree)
			);
		}
	}

	/**
	 * Tests  TreeMap::clear
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::clear
	 *
	 * @since   1.0.0
	 */
	public function test_clear()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			$tree,
			$tree->clear()
		);

		$this->assertEquals(
			null,
			$root->getValue($tree)
		);
	}

	/**
	 * Tests  TreeMap::__clone
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::__clone
	 *
	 * @since   1.0.0
	 */
	public function test_clone()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$clone = clone $tree;
		$tree->clear();
		$this->assertEquals(
			10,
			count($clone)
		);
	}

	/**
	 * Tests  TreeMap::comparator
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::comparator
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_comparator()
	{
		$comparator = function ($key1, $key2)
		{
			return $key1 - $key2;
		};
		$tree = TreeMap::create($comparator)->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			$comparator,
			$tree->comparator
		);
	}

	/**
	 * Tests  TreeMap::first
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::first
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 * @covers  chdemko\SortedCollection\AbstractMap::firstKey
	 * @covers  chdemko\SortedCollection\AbstractMap::firstValue
	 *
	 * @since   1.0.0
	 */
	public function test_first()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			0,
			$tree->firstKey
		);
		$this->assertEquals(
			0,
			$tree->firstValue
		);
		$this->assertEquals(
			0,
			$tree->first->key
		);
		$tree->clear();
		$this->setExpectedException('OutOfBoundsException');
		$key = $tree->firstKey;
	}

	/**
	 * Tests  TreeMap::last
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::last
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 * @covers  chdemko\SortedCollection\AbstractMap::lastKey
	 * @covers  chdemko\SortedCollection\AbstractMap::lastValue
	 *
	 * @since   1.0.0
	 */
	public function test_last()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			9,
			$tree->lastKey
		);
		$this->assertEquals(
			9,
			$tree->lastValue
		);
		$this->assertEquals(
			9,
			$tree->last->key
		);
		$tree->clear();
		$this->setExpectedException('OutOfBoundsException');
		$key = $tree->lastKey;
	}

	/**
	 * Tests  TreeMap::predecessor
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::predecessor
	 * @covers  chdemko\SortedCollection\AbstractMap::predecessor
	 *
	 * @since   1.0.0
	 */
	public function test_predecessor()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			8,
			$tree->predecessor($tree->last)->key
		);
		$this->setExpectedException('OutOfBoundsException');
		$predecessor = $tree->predecessor($tree->first);
	}

	/**
	 * Tests  TreeMap::successor
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::successor
	 * @covers  chdemko\SortedCollection\AbstractMap::successor
	 *
	 * @since   1.0.0
	 */
	public function test_successor()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			1,
			$tree->successor($tree->first)->key
		);
		$this->setExpectedException('OutOfBoundsException');
		$successor = $tree->successor($tree->last);
	}

	/**
	 * Tests  AbstractMap::keys
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::keys
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 * @covers  chdemko\SortedCollection\Iterator::keys
	 * @covers  chdemko\SortedCollection\Iterator::rewind
	 * @covers  chdemko\SortedCollection\Iterator::key
	 * @covers  chdemko\SortedCollection\Iterator::current
	 * @covers  chdemko\SortedCollection\Iterator::next
	 * @covers  chdemko\SortedCollection\Iterator::valid
	 *
	 * @since   1.0.0
	 */
	public function test_keys()
	{
		$empty = true;
		$tree = TreeMap::create();

		foreach ($tree->keys as $key)
		{
			$empty = false;
		}

		$this->assertEquals(true, $empty);

		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$i = 0;

		foreach ($tree->keys as $index => $key)
		{
			$this->assertEquals($i, $index);
			$this->assertEquals($i, $key);
			$i++;
		}
	}

	/**
	 * Tests  AbstractMap::values
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::values
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 * @covers  chdemko\SortedCollection\Iterator::values
	 * @covers  chdemko\SortedCollection\Iterator::rewind
	 * @covers  chdemko\SortedCollection\Iterator::key
	 * @covers  chdemko\SortedCollection\Iterator::current
	 * @covers  chdemko\SortedCollection\Iterator::next
	 * @covers  chdemko\SortedCollection\Iterator::valid
	 *
	 * @since   1.0.0
	 */
	public function test_values()
	{
		$empty = true;
		$tree = TreeMap::create();

		foreach ($tree->values as $values)
		{
			$empty = false;
		}

		$this->assertEquals(true, $empty);

		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$i = 0;

		foreach ($tree->values as $value)
		{
			$this->assertEquals($i, $value);
			$i++;
		}
	}

	/**
	 * Tests  TreeMap::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get_unexisting()
	{
		$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->setExpectedException('RuntimeException');
		$unexisting = $tree->unexisting;
	}

	/**
	 * Data provider for test_lower
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_lower()
	{
		return [
			[[], 10, null, 'OutOfBoundsException'],
			[[1 => 1], 1, null, 'OutOfBoundsException'],
			[[1 => 1, 0 => 0], 0, null, 'OutOfBoundsException'],
			[[2 => 2, 1 => 1], 0, null, 'OutOfBoundsException'],
			[[0 => 0, 1 => 1], 1, 0, null],
			[[0 => 0, 1 => 1], 2, 1, null],
		];
	}

	/**
	 * Tests  TreeMap::lower
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key/value
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::lower
	 * @covers  chdemko\SortedCollection\AbstractMap::lowerKey
	 * @covers  chdemko\SortedCollection\AbstractMap::lowerValue
	 *
	 * @dataProvider  cases_lower
	 *
	 * @since   1.0.0
	 */
	public function test_lower($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$tree->lowerKey($key)
		);
		$this->assertEquals(
			$expected,
			$tree->lowerValue($key)
		);
	}

	/**
	 * Data provider for test_floor
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_floor()
	{
		return [
			[[], 10, null, 'OutOfBoundsException'],
			[[1 => 1], 1, 1, null],
			[[1 => 1, 0 => 0], 0, 0, null],
			[[2 => 2, 1 => 1], 0, null, 'OutOfBoundsException'],
			[[0 => 0, 1 => 1], 1, 1, null],
			[[0 => 0, 1 => 1], 2, 1, null],
		];
	}

	/**
	 * Tests  TreeMap::floor
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key/value
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::floor
	 * @covers  chdemko\SortedCollection\AbstractMap::floorKey
	 * @covers  chdemko\SortedCollection\AbstractMap::floorValue
	 *
	 * @dataProvider  cases_floor
	 *
	 * @since   1.0.0
	 */
	public function test_floor($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$tree->floorKey($key)
		);
		$this->assertEquals(
			$expected,
			$tree->floorValue($key)
		);
	}

	/**
	 * Tests  TreeMap::find
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::find
	 * @covers  chdemko\SortedCollection\AbstractMap::findKey
	 * @covers  chdemko\SortedCollection\AbstractMap::findValue
	 *
	 * @since   1.0.0
	 */
	public function test_find()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			0,
			$tree->findKey(0)
		);
		$this->assertEquals(
			0,
			$tree->findValue(0)
		);

		$tree->clear();
		$this->setExpectedException('OutOfBoundsException');

		$key = $tree->findKey(10);
	}

	/**
	 * Data provider for test_ceiling
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_ceiling()
	{
		return [
			[[], 10, null, 'OutOfBoundsException'],
			[[1 => 1], 1, 1, null],
			[[1 => 1, 0 => 0], 0, 0, null],
			[[2 => 2, 1 => 1], 0, 1, null],
			[[0 => 0, 1 => 1], 1, 1, null],
			[[0 => 0, 1 => 1], 2, null, 'OutOfBoundsException'],
		];
	}

	/**
	 * Tests  TreeMap::ceiling
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key/value
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::ceiling
	 * @covers  chdemko\SortedCollection\AbstractMap::ceilingKey
	 * @covers  chdemko\SortedCollection\AbstractMap::ceilingValue
	 *
	 * @dataProvider  cases_ceiling
	 *
	 * @since   1.0.0
	 */
	public function test_ceiling($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$tree->ceilingKey($key)
		);
		$this->assertEquals(
			$expected,
			$tree->ceilingValue($key)
		);
	}

	/**
	 * Data provider for test_higher
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_higher()
	{
		return [
			[[], 10, null, 'OutOfBoundsException'],
			[[1 => 1], 1, null, 'OutOfBoundsException'],
			[[1 => 1, 0 => 0], 0, 1, null],
			[[2 => 2, 1 => 1], 0, 1, null],
			[[0 => 0, 1 => 1], 1, null, 'OutOfBoundsException'],
			[[0 => 0, 1 => 1], 2, null, 'OutOfBoundsException'],
		];
	}

	/**
	 * Tests  TreeMap::higher
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key/value
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::higher
	 * @covers  chdemko\SortedCollection\AbstractMap::higherKey
	 * @covers  chdemko\SortedCollection\AbstractMap::higherValue
	 *
	 * @dataProvider  cases_higher
	 *
	 * @since   1.0.0
	 */
	public function test_higher($values, $key, $expected, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException($exception);
		}

		$tree = TreeMap::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$tree->higherKey($key)
		);
		$this->assertEquals(
			$expected,
			$tree->higherValue($key)
		);
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
		return [
			[[], 10, null, 'OutOfRangeException'],
			[[1 => 1], 1, 1, null],
			[[1 => 1, 0 => 0], 0, 0, null],
			[[2 => 2, 1 => 1], 0, null, 'OutOfRangeException'],
			[[0 => 0, 1 => 1], 1, 1, null],
			[[0 => 0, 1 => 1], 2, null, 'OutOfRangeException'],
		];
	}

	/**
	 * Tests  TreeMap::offsetGet
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $value      Expected value
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::offsetGet
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

		$this->assertEquals(
			$value,
			$tree[$key]
		);
	}

	/**
	 * Tests  TreeMap::offsetSet
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::offsetSet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetSet()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$tree[5] = 6;

		$this->assertEquals(
			6,
			$tree[5]
		);
	}

	/**
	 * Tests  AbstractMap::offsetExists
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::offsetExists
	 *
	 * @since   1.0.0
	 */
	public function test_offsetExists()
	{
		$tree = TreeMap::create();

		$this->assertFalse(
			isset($tree[10])
		);

		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertTrue(
			isset($tree[5])
		);
		$this->assertFalse(
			isset($tree[10])
		);
	}

	/**
	 * Tests  TreeMap::offsetUnset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::offsetUnset
	 *
	 * @since   1.0.0
	 */
	public function test_offsetUnset()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		unset($tree[3]);

		$this->assertEquals(
			9,
			count($tree)
		);

		$this->setExpectedException('OutOfRangeException');
		$value = $tree[3];
	}

	/**
	 * Tests  TreeMap::count
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::count
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_count()
	{
		$tree = TreeMap::create();

		$this->assertEquals(
			0,
			$tree->count
		);

		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			10,
			count($tree)
		);
	}

	/**
	 * Tests  AbstractMap::__toString
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::__toString
	 * @covers  chdemko\SortedCollection\AbstractMap::toArray
	 * @covers  chdemko\SortedCollection\AbstractMap::getIterator
	 * @covers  chdemko\SortedCollection\AbstractMap::jsonSerialize
	 * @covers  chdemko\SortedCollection\Iterator::__construct
	 * @covers  chdemko\SortedCollection\Iterator::create
	 * @covers  chdemko\SortedCollection\Iterator::rewind
	 * @covers  chdemko\SortedCollection\Iterator::key
	 * @covers  chdemko\SortedCollection\Iterator::current
	 * @covers  chdemko\SortedCollection\Iterator::next
	 * @covers  chdemko\SortedCollection\Iterator::valid
	 *
	 * @since   1.0.0
	 */
	public function test___toString()
	{
		$tree = TreeMap::create();

		$this->assertEquals(
			'[]',
			(string) $tree
		);

		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			'[0,1,2,3,4,5,6,7,8,9]',
			(string) $tree
		);
	}

	/**
	 * Tests  TreeMap::jsonSerialize
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeMap::jsonSerialize
	 *
	 * @since   1.0.0
	 */
	public function test_jsonSerialize()
	{
		$tree = TreeMap::create();

		$this->assertEquals(
			'{"TreeMap":[]}',
			json_encode($tree)
		);

		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			'{"TreeMap":[0,1,2,3,4,5,6,7,8,9]}',
			json_encode($tree)
		);
	}
}
