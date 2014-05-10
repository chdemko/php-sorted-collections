<?php

/**
 * chdemko\SortedCollection\TreeSetTest class
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
 * TreeSet class test
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @since       1.0.0
 */
class TreeSetTest extends \PHPUnit_Framework_TestCase
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
	 * Tests  TreeSet::create
	 *
	 * @param   array     $values      Initial values
	 * @param   mixed     $key         Expected root key
	 * @param   callable  $comparator  Comparator
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeSet::__construct
	 * @covers  chdemko\SortedCollection\TreeSet::create
	 * @covers  chdemko\SortedCollection\TreeSet::put
	 * @covers  chdemko\SortedCollection\TreeSet::initialise
	 *
	 * @dataProvider  cases_create
	 *
	 * @since   1.0.0
	 */
	public function test_create($values, $key, $comparator)
	{
		$set = TreeSet::create($comparator)->initialise($values);

		if ($comparator !== null)
		{
			$this->assertEquals(
				$comparator,
				$set->comparator
			);
		}
		else
		{
			$this->assertTrue(
				is_callable($set->comparator)
			);
		}

		// Set the map property accessible
		$map = (new \ReflectionClass($set))->getMethod('getMap');
		$map->setAccessible(true);
		$map2 = $map->invoke($set);

		// Set the root property accessible
		$root = (new \ReflectionClass($map2))->getProperty('root');
		$root->setAccessible(true);

		if ($values)
		{
			$this->assertEquals(
				$key,
				$root->getValue($map2)->key
			);
		}
		else
		{
			$this->assertEquals(
				null,
				$root->getValue($map2)
			);
		}
	}

	/**
	 * Tests  TreeSet::clear
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeSet::clear
	 *
	 * @since   1.0.0
	 */
	public function test_clear()
	{
		$set = TreeSet::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		// Set the map property accessible
		$map = (new \ReflectionClass($set))->getMethod('getMap');
		$map->setAccessible(true);
		$map2 = $map->invoke($set);

		// Set the root property accessible
		$root = (new \ReflectionClass($map2))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			$set,
			$set->clear()
		);

		$this->assertEquals(
			null,
			$root->getValue($map2)
		);
	}

	/**
	 * Tests  TreeSet::__clone
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeSet::__clone
	 *
	 * @since   1.0.0
	 */
	public function test_clone()
	{
		$set = TreeSet::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$clone = clone $set;
		$set->clear();
		$this->assertEquals(
			10,
			count($clone)
		);
	}

	/**
	 * Tests  AbstractSet::comparator
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::comparator
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test_comparator()
	{
		$comparator = function ($key1, $key2)
		{
			return $key1 - $key2;
		};
		$set = TreeSet::create($comparator)->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			$comparator,
			$set->comparator
		);
	}

	/**
	 * Tests  AbstractSet::first
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::first
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test_first()
	{
		$set = TreeSet::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			0,
			$set->first
		);
		$set->clear();
		$this->setExpectedException('OutOfBoundsException');
		$key = $set->first;
	}

	/**
	 * Tests  AbstractSet::last
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::last
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test_last()
	{
		$set = TreeSet::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->assertEquals(
			9,
			$set->last
		);
		$set->clear();
		$this->setExpectedException('OutOfBoundsException');
		$key = $set->last;
	}

	/**
	 * Tests  AbstractSet::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get_unexisting()
	{
		$set = TreeSet::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$this->setExpectedException('OutOfBoundsException');
		$unexisting = $set->unexisting;
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
			[[1], 1, null, 'OutOfBoundsException'],
			[[0, 1], 0, null, 'OutOfBoundsException'],
			[[1, 2], 0, null, 'OutOfBoundsException'],
			[[0, 1], 1, 0, null],
			[[0, 1], 2, 1, null],
		];
	}

	/**
	 * Tests  AbstractSet::lower
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::lower
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

		$set = TreeSet::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$set->lower($key)
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
			[[1], 1, 1, null],
			[[0, 1], 0, 0, null],
			[[1, 2], 0, null, 'OutOfBoundsException'],
			[[0, 1], 1, 1, null],
			[[0, 1], 2, 1, null],
		];
	}

	/**
	 * Tests  AbstractSet::floor
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::floor
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

		$set = TreeSet::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$set->floor($key)
		);
	}

	/**
	 * Tests  AbstractSet::find
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::find
	 *
	 * @since   1.0.0
	 */
	public function test_find()
	{
		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			0,
			$set->find(0)
		);

		$set->clear();
		$this->setExpectedException('OutOfBoundsException');

		$key = $set->find(10);
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
			[[1], 1, 1, null],
			[[0, 1], 0, 0, null],
			[[1, 2], 0, 1, null],
			[[0, 1], 1, 1, null],
			[[0, 1], 2, null, 'OutOfBoundsException'],
		];
	}

	/**
	 * Tests  AbstractSet::ceiling
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::ceiling
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

		$set = TreeSet::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$set->ceiling($key)
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
			[[1], 1, null, 'OutOfBoundsException'],
			[[0, 1], 0, 1, null],
			[[1, 2], 0, 1, null],
			[[0, 1], 1, null, 'OutOfBoundsException'],
			[[0, 1], 2, null, 'OutOfBoundsException'],
		];
	}

	/**
	 * Tests  AbstractSet::higher
	 *
	 * @param   array  $values     Values array
	 * @param   mixed  $key        Key to search for     
	 * @param   mixed  $expected   Expected key
	 * @param   mixed  $exception  Exception to be thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::higher
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

		$set = TreeSet::create()->initialise($values);

		$this->assertEquals(
			$expected,
			$set->higher($key)
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
			[[], 0, false],
			[[0], 1, false],
			[[1], 1, true],
			[[0, 1], 0, true],
			[[0, 1], 1, true],
			[[0, 1], 2, false],
		];
	}

	/**
	 * Tests  AbstractSet::offsetGet
	 *
	 * @param   array  $values  Values array
	 * @param   mixed  $key     Key to search for     
	 * @param   mixed  $value   Expected value
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::offsetGet
	 *
	 * @dataProvider  cases_offsetGet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetGet($values, $key, $value)
	{
		$set = TreeSet::create()->initialise($values);

		$this->assertEquals(
			$value,
			$set[$key]
		);
	}

	/**
	 * Tests  TreeSet::offsetSet
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeSet::offsetSet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetSet()
	{
		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$set[5] = false;

		$this->assertEquals(
			false,
			$set[5]
		);
		$this->assertEquals(
			true,
			$set[4]
		);
	}

	/**
	 * Tests  AbstractSet::offsetExists
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::offsetExists
	 *
	 * @since   1.0.0
	 */
	public function test_offsetExists()
	{
		$set = TreeSet::create();

		$this->assertFalse(
			isset($set[10])
		);

		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertTrue(
			isset($set[5])
		);
		$this->assertFalse(
			isset($set[10])
		);
	}

	/**
	 * Tests  TreeSet::offsetUnset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeSet::offsetUnset
	 *
	 * @since   1.0.0
	 */
	public function test_offsetUnset()
	{
		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		unset($set[5]);

		$this->assertEquals(
			false,
			$set[5]
		);
	}

	/**
	 * Tests  AbstractSet::count
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::count
	 * @covers  chdemko\SortedCollection\AbstractSet::__get
	 *
	 * @since   1.0.0
	 */
	public function test_count()
	{
		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			10,
			$set->count
		);
	}

	/**
	 * Tests  AbstractSet::__toString
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractSet::__toString
	 * @covers  chdemko\SortedCollection\AbstractSet::toArray
	 * @covers  chdemko\SortedCollection\AbstractSet::jsonSerialize
	 * @covers  chdemko\SortedCollection\AbstractSet::getIterator
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
		$set = TreeSet::create();

		$this->assertEquals(
			'[]',
			(string) $set
		);

		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			'[0,1,2,3,4,5,6,7,8,9]',
			(string) $set
		);
	}

	/**
	 * Tests  TreeSet::jsonSerialize
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeSet::jsonSerialize
	 *
	 * @since   1.0.0
	 */
	public function test_jsonSerialize()
	{
		$set = TreeSet::create();

		$this->assertEquals(
			'{"TreeSet":[]}',
			json_encode($set)
		);

		$set = TreeSet::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		$this->assertEquals(
			'{"TreeSet":[0,1,2,3,4,5,6,7,8,9]}',
			json_encode($set)
		);
	}
}
