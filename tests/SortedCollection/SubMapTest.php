<?php

/**
 * chdemko\SortedCollection\SubMapTest class
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
 * SubMap class test
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 */
class SubMapTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Tests  SubMap::create
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::create
	 * @covers  chdemko\SortedCollection\SubMap::__construct
	 * @covers  chdemko\SortedCollection\SubMap::setEmpty
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 * @covers  chdemko\SortedCollection\SubMap::__set
	 *
	 * @since   1.0.0
	 */
	public function test_create()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::create($tree, 2, 7);

		$this->assertEquals(
			$tree,
			$sub->map
		);
		$this->assertEquals(
			2,
			$sub->fromKey
		);
		$this->assertEquals(
			7,
			$sub->toKey
		);
		$this->assertEquals(
			true,
			$sub->fromInclusive
		);
		$this->assertEquals(
			false,
			$sub->toInclusive
		);

		$sub->fromInclusive = false;
		$sub->toInclusive = true;
		$this->assertEquals(
			false,
			$sub->fromInclusive
		);
		$this->assertEquals(
			true,
			$sub->toInclusive
		);
	}

	/**
	 * Tests  SubMap::head
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::head
	 * @covers  chdemko\SortedCollection\SubMap::__construct
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_head()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$head = SubMap::head($tree, 7);

		$this->assertEquals(
			$tree,
			$head->map
		);
		$this->assertEquals(
			7,
			$head->toKey
		);
		$this->assertEquals(
			false,
			$head->toInclusive
		);
	}

	/**
	 * Tests  SubMap::tail
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::tail
	 * @covers  chdemko\SortedCollection\SubMap::__construct
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_tail()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$tail = SubMap::tail($tree, 2);

		$this->assertEquals(
			$tree,
			$tail->map
		);
		$this->assertEquals(
			2,
			$tail->fromKey
		);
		$this->assertEquals(
			true,
			$tail->fromInclusive
		);
	}

	/**
	 * Tests  SubMap::copy
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::view
	 * @covers  chdemko\SortedCollection\SubMap::__construct
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_copy()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$view = SubMap::view($tree);

		$this->assertEquals(
			$tree,
			$view->map
		);
		$this->assertFalse(
			isset($view->fromKey)
		);
		$this->assertFalse(
			isset($view->toKey)
		);
	}

	/**
	 * Tests  SubMap::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get_fromKey()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$head = SubMap::head($tree, 7);

		$this->setExpectedException('RuntimeException');
		$fromKey = $head->fromKey;
	}

	/**
	 * Tests  SubMap::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get_toKey()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$tail = SubMap::tail($tree, 2);

		$this->setExpectedException('RuntimeException');
		$toKey = $tail->toKey;
	}

	/**
	 * Tests  SubMap::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get_fromInclusive()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$head = SubMap::head($tree, 7);

		$this->setExpectedException('RuntimeException');
		$fromInclusive = $head->fromInclusive;
	}

	/**
	 * Tests  SubMap::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test___get_toInclusive()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$tail = SubMap::tail($tree, 2);

		$this->setExpectedException('RuntimeException');
		$toInclusive = $tail->toInclusive;
	}

	/**
	 * Tests  SubMap::__set
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__set
	 *
	 * @since   1.0.0
	 */
	public function test___set_fromKey()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		$sub->fromKey = 2;
		$this->assertEquals(
			2,
			$sub->fromKey
		);
		$this->assertEquals(
			true,
			$sub->fromInclusive
		);
	}

	/**
	 * Tests  SubMap::__set
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__set
	 *
	 * @since   1.0.0
	 */
	public function test___set_toKey()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::tail($tree, 2);
		$sub->toKey = 7;
		$this->assertEquals(
			7,
			$sub->toKey
		);
		$this->assertEquals(
			false,
			$sub->toInclusive
		);
	}

	/**
	 * Tests  SubMap::__set
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__set
	 *
	 * @since   1.0.0
	 */
	public function test___set_fromInclusive()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		$this->setExpectedException('RuntimeException');
		$sub->fromInclusive = true;
	}

	/**
	 * Tests  SubMap::__set
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__set
	 *
	 * @since   1.0.0
	 */
	public function test___set_toInclusive()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::tail($tree, 2);
		$this->setExpectedException('RuntimeException');
		$sub->toInclusive = true;
	}

	/**
	 * Tests  SubMap::__set
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__set
	 *
	 * @since   1.0.0
	 */
	public function test___set_unexisting()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		$this->setExpectedException('RuntimeException');
		$sub->unexisting = true;
	}

	/**
	 * Tests  SubMap::__unset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__unset
	 *
	 * @since   1.0.0
	 */
	public function test___unset_fromKey()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::tail($tree, 2);
		unset($sub->fromKey);
		$this->setExpectedException('RuntimeException');
		$fromKey = $sub->fromKey;
	}

	/**
	 * Tests  SubMap::__unset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__unset
	 *
	 * @since   1.0.0
	 */
	public function test___unset_toKey()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		unset($sub->toKey);
		$this->setExpectedException('RuntimeException');
		$toKey = $sub->toKey;
	}

	/**
	 * Tests  SubMap::__unset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__unset
	 *
	 * @since   1.0.0
	 */
	public function test___unset_fromInclusive()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		unset($sub->fromInclusive);
		$this->setExpectedException('RuntimeException');
		$fromKey = $sub->fromKey;
	}

	/**
	 * Tests  SubMap::__unset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__unset
	 *
	 * @since   1.0.0
	 */
	public function test___unset_toInclusive()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		unset($sub->toInclusive);
		$this->setExpectedException('RuntimeException');
		$toKey = $sub->toKey;
	}

	/**
	 * Tests  SubMap::__unset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__unset
	 *
	 * @since   1.0.0
	 */
	public function test___unset_unexisting()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::tail($tree, 2);
		$this->setExpectedException('RuntimeException');
		unset($sub->unexisting);
	}

	/**
	 * Tests  SubMap::__isset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__isset
	 *
	 * @since   1.0.0
	 */
	public function test___isset_from()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::tail($tree, 2);
		$this->assertTrue(
			isset($sub->fromKey)
		);
		$this->assertTrue(
			isset($sub->fromInclusive)
		);
		unset($sub->fromKey);
		$this->assertFalse(
			isset($sub->fromKey)
		);
		$this->assertFalse(
			isset($sub->fromInclusive)
		);
	}

	/**
	 * Tests  SubMap::__isset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__isset
	 *
	 * @since   1.0.0
	 */
	public function test___isset_to()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		$this->assertTrue(
			isset($sub->toKey)
		);
		$this->assertTrue(
			isset($sub->toInclusive)
		);
		unset($sub->toKey);
		$this->assertFalse(
			isset($sub->toKey)
		);
		$this->assertFalse(
			isset($sub->toInclusive)
		);
	}

	/**
	 * Tests  SubMap::__isset
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::__isset
	 *
	 * @since   1.0.0
	 */
	public function test___isset_unexisting()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::head($tree, 7);
		$this->assertFalse(
			isset($sub->unexisting)
		);
	}

	/**
	 * Tests  SubMap::comparator
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::comparator
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @since   1.0.0
	 */
	public function test_comparator()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
		$sub = SubMap::create($tree, 2, 7);
		$this->assertEquals(
			$tree->comparator,
			$sub->comparator
		);
	}

	/**
	 * Generates a sub map
	 *
	 * @param   mixed  $fromKey        The from key
	 * @param   mixed  $toKey          The to key
	 * @param   mixed  $fromInclusive  The from inclusive flag
	 * @param   mixed  $toInclusive    The to inclusive flag	 
	 *
	 * @return  SubMap  A sub map
	 *
	 * @since   1.0.0
	 */
	protected function createSub($fromKey, $toKey, $fromInclusive, $toInclusive)
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		if ($fromInclusive === null)
		{
			if ($toInclusive === null)
			{
				$sub = SubMap::view($tree);
			}
			else
			{
				$sub = SubMap::head($tree, $toKey, $toInclusive);
			}
		}
		elseif ($toInclusive === null)
		{
			$sub = SubMap::tail($tree, $fromKey, $fromInclusive);
		}
		else
		{
			$sub = SubMap::create($tree, $fromKey, $toKey, $fromInclusive, $toInclusive);
		}

		return $sub;
	}

	/**
	 * Data provider for test_first
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_first()
	{
		return array(
			array(2, 7, true, false, 2, false),
			array(2, 7, false, false, 3, false),
			array(null, 7, null, false, 0, false),
			array(9, -1, true, false, null, true),
			array(9, -1, true, true, null, true),
		);
	}

	/**
	 * Tests  SubMap::first
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $firstKey       The expected first key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::first
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @dataProvider  cases_first
	 *
	 * @since   1.0.0
	 */
	public function test_first($fromKey, $toKey, $fromInclusive, $toInclusive, $firstKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$this->assertEquals(
			$firstKey,
			$this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive)->firstKey
		);
	}

	/**
	 * Data provider for test_last
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_last()
	{
		return array(
			array(2, 7, true, false, 6, false),
			array(2, 7, true, true, 7, false),
			array(2, null, false, null, 9, false),
			array(9, -1, true, false, null, true),
			array(9, -1, true, true, null, true),
		);
	}

	/**
	 * Tests  SubMap::last
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $lastKey        The expected last key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::last
	 * @covers  chdemko\SortedCollection\SubMap::__get
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @dataProvider  cases_last
	 *
	 * @since   1.0.0
	 */
	public function test_last($fromKey, $toKey, $fromInclusive, $toInclusive, $lastKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$this->assertEquals(
			$lastKey,
			$this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive)->lastKey
		);
	}

	/**
	 * Data provider for test_predecessor
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_predecessor()
	{
		return array(
			array(2, 7, true, false, 6, 5, false),
			array(2, 7, true, false, 2, null, true),
			array(2, 7, false, false, 6, 5, false),
			array(2, 7, false, false, 3, null, true),
		);
	}

	/**
	 * Tests  SubMap::predecessor
	 *
	 * @param   mixed    $fromKey         The from key
	 * @param   mixed    $toKey           The to key
	 * @param   mixed    $fromInclusive   The from inclusive flag
	 * @param   mixed    $toInclusive     The to inclusive flag
	 * @param   mixed    $key             The searched key
	 * @param   mixed    $predecessorKey  The expected predecessor key
	 * @param   boolean  $exception       Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::predecessor
	 *
	 * @dataProvider  cases_predecessor
	 *
	 * @since   1.0.0
	 */
	public function test_predecessor($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $predecessorKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$predecessorKey,
			$sub->predecessor($sub->find($key))->key
		);
	}

	/**
	 * Data provider for test_successor
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_successor()
	{
		return array(
			array(2, 7, false, true, 3, 4, false),
			array(2, 7, false, true, 7, null, true),
			array(2, 7, false, false, 3, 4, false),
			array(2, 7, false, false, 6, null, true),
		);
	}

	/**
	 * Tests  SubMap::successor
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $successorKey   The expected successor key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::successor
	 *
	 * @dataProvider  cases_successor
	 *
	 * @since   1.0.0
	 */
	public function test_successor($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $successorKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$successorKey,
			$sub->successor($sub->find($key))->key
		);
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
		return array(
			array(2, 7, true, false, 0, null, true),
			array(2, 7, true, false, 6, 5, false),
			array(2, 7, true, false, 7, 6, false),
			array(2, 7, true, false, 8, 6, false),
			array(2, 7, true, true, 0, null, true),
			array(2, 7, true, true, 6, 5, false),
			array(2, 7, true, true, 7, 6, false),
			array(2, 7, true, true, 8, 7, false),
			array(2, 7, true, true, 9, 7, false),
			array(2, 7, false, false, 0, null, true),
			array(2, 7, false, false, 2, null, true),
			array(2, 7, false, false, 3, null, true),
			array(2, 7, false, false, 4, 3, false),
			array(2, 7, false, false, 6, 5, false),
			array(2, 7, false, false, 7, 6, false),
			array(2, 7, false, false, 8, 6, false),
			array(2, 7, false, true, 0, null, true),
			array(2, 7, false, true, 2, null, true),
			array(2, 7, false, true, 3, null, true),
			array(2, 7, false, true, 4, 3, false),
			array(2, 7, false, true, 6, 5, false),
			array(2, 7, false, true, 7, 6, false),
			array(2, 7, false, true, 8, 7, false),
			array(null, 7, null, false, 0, null, true),
			array(null, 7, null, false, 1, 0, false),
			array(null, 7, null, false, 7, 6, false),
			array(null, 7, null, false, 8, 6, false),
			array(9, -1, true, false, 0, null, true),
			array(9, -1, true, false, 6, null, true),
		);
	}

	/**
	 * Tests  SubMap::lower
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $lowerKey       The expected lower key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::lower
	 *
	 * @dataProvider  cases_lower
	 *
	 * @since   1.0.0
	 */
	public function test_lower($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $lowerKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$lowerKey,
			$sub->lowerKey($key)
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
		return array(
			array(2, 7, true, false, 0, null, true),
			array(2, 7, true, false, 6, 6, false),
			array(2, 7, true, false, 7, 6, false),
			array(2, 7, true, false, 8, 6, false),
			array(2, 7, true, true, 0, null, true),
			array(2, 7, true, true, 6, 6, false),
			array(2, 7, true, true, 7, 7, false),
			array(2, 7, true, true, 8, 7, false),
			array(2, 7, false, false, 0, null, true),
			array(2, 7, false, false, 2, null, true),
			array(2, 7, false, false, 3, 3, false),
			array(2, 7, false, false, 6, 6, false),
			array(2, 7, false, false, 7, 6, false),
			array(2, 7, false, false, 8, 6, false),
			array(2, 7, false, true, 0, null, true),
			array(2, 7, false, true, 2, null, true),
			array(2, 7, false, true, 3, 3, false),
			array(2, 7, false, true, 6, 6, false),
			array(2, 7, false, true, 7, 7, false),
			array(2, 7, false, true, 8, 7, false),
			array(null, 7, null, false, 0, 0, false),
			array(null, 7, null, false, 7, 6, false),
			array(null, 7, null, false, 8, 6, false),
			array(9, -1, true, false, 0, null, true),
			array(9, -1, true, false, 6, null, true),
		);
	}

	/**
	 * Tests  SubMap::floor
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $floorKey       The expected floor key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::floor
	 *
	 * @dataProvider  cases_floor
	 *
	 * @since   1.0.0
	 */
	public function test_floor($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $floorKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$floorKey,
			$sub->floorKey($key)
		);
	}

	/**
	 * Data provider for test_find
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_find()
	{
		return array(
			array(2, 7, true, false, 0, null, true),
			array(2, 7, true, false, 2, 2, false),
			array(2, 7, true, false, 6, 6, false),
			array(2, 7, true, false, 7, null, true),
			array(2, 7, true, false, 8, null, true),
			array(2, 7, false, false, 0, null, true),
			array(2, 7, false, false, 2, null, true),
			array(2, 7, false, false, 3, 3, false),
			array(2, 7, false, false, 6, 6, false),
			array(2, 7, false, false, 7, null, true),
			array(2, 7, false, false, 8, null, true),
			array(2, 7, false, true, 0, null, true),
			array(2, 7, false, true, 2, null, true),
			array(2, 7, false, true, 3, 3, false),
			array(2, 7, false, true, 6, 6, false),
			array(2, 7, false, true, 7, 7, false),
			array(2, 7, false, true, 8, null, true),
			array(2, 7, true, true, 0, null, true),
			array(2, 7, true, true, 2, 2, false),
			array(2, 7, true, true, 6, 6, false),
			array(2, 7, true, true, 7, 7, false),
			array(2, 7, true, true, 8, null, true),
			array(9, -1, true, false, 0, null, true),
			array(9, -1, true, false, 6, null, true),
		);
	}

	/**
	 * Tests  SubMap::find
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $findKey        The expected find key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::find
	 *
	 * @dataProvider  cases_find
	 *
	 * @since   1.0.0
	 */
	public function test_find($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $findKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$findKey,
			$sub->findKey($key)
		);
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
		return array(
			array(2, 7, false, true, 9, null, true),
			array(2, 7, false, true, 2, 3, false),
			array(2, 7, false, true, 1, 3, false),
			array(2, 7, true, true, 9, null, true),
			array(2, 7, true, true, 7, 7, false),
			array(2, 7, true, true, 3, 3, false),
			array(2, 7, true, true, 2, 2, false),
			array(2, 7, true, true, 1, 2, false),
			array(2, 7, true, true, 0, 2, false),
			array(2, 7, false, false, 9, null, true),
			array(2, 7, false, false, 7, null, true),
			array(2, 7, false, false, 6, 6, false),
			array(2, 7, false, false, 3, 3, false),
			array(2, 7, false, false, 2, 3, false),
			array(2, 7, false, false, 1, 3, false),
			array(2, null, true, null, 10, null, true),
			array(2, null, true, null, 9, 9, false),
			array(2, null, true, null, 2, 2, false),
			array(2, null, true, null, 1, 2, false),
			array(2, null, false, null, 2, 3, false),
			array(2, null, false, null, 1, 3, false),
			array(9, -1, true, false, 0, null, true),
			array(9, -1, true, false, 6, null, true),
		);
	}

	/**
	 * Tests  SubMap::ceiling
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $ceilingKey     The expected ceiling key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::ceiling
	 *
	 * @dataProvider  cases_ceiling
	 *
	 * @since   1.0.0
	 */
	public function test_ceiling($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $ceilingKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$ceilingKey,
			$sub->ceilingKey($key)
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
		return array(
			array(2, 7, false, true, 9, null, true),
			array(2, 7, false, true, 2, 3, false),
			array(2, 7, false, true, 1, 3, false),
			array(2, 7, true, true, 9, null, true),
			array(2, 7, true, true, 7, null, true),
			array(2, 7, true, true, 6, 7, false),
			array(2, 7, true, true, 3, 4, false),
			array(2, 7, true, true, 2, 3, false),
			array(2, 7, true, true, 1, 2, false),
			array(2, 7, true, true, 0, 2, false),
			array(2, 7, false, false, 9, null, true),
			array(2, 7, false, false, 7, null, true),
			array(2, 7, false, false, 6, null, true),
			array(2, 7, false, false, 5, 6, false),
			array(2, 7, false, false, 3, 4, false),
			array(2, 7, false, false, 2, 3, false),
			array(2, 7, false, false, 1, 3, false),
			array(2, null, true, null, 10, null, true),
			array(2, null, true, null, 9, null, true),
			array(2, null, true, null, 8, 9, false),
			array(2, null, true, null, 2, 3, false),
			array(2, null, true, null, 1, 2, false),
			array(2, null, false, null, 2, 3, false),
			array(2, null, false, null, 1, 3, false),
			array(9, -1, true, false, 0, null, true),
			array(9, -1, true, false, 6, null, true),
		);
	}

	/**
	 * Tests  SubMap::higher
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $higherKey      The expected higher key
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::higher
	 *
	 * @dataProvider  cases_higher
	 *
	 * @since   1.0.0
	 */
	public function test_higher($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $higherKey, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfBoundsException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$higherKey,
			$sub->higherKey($key)
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
		return array(
			array(2, 7, true, false, 0, null, true),
			array(2, 7, true, false, 2, 2, false),
			array(2, 7, true, false, 6, 6, false),
			array(2, 7, true, false, 7, null, true),
			array(2, 7, true, false, 8, null, true),
			array(2, 7, false, false, 0, null, true),
			array(2, 7, false, false, 2, null, true),
			array(2, 7, false, false, 3, 3, false),
			array(2, 7, false, false, 6, 6, false),
			array(2, 7, false, false, 7, null, true),
			array(2, 7, false, false, 8, null, true),
			array(2, 7, false, true, 0, null, true),
			array(2, 7, false, true, 2, null, true),
			array(2, 7, false, true, 3, 3, false),
			array(2, 7, false, true, 6, 6, false),
			array(2, 7, false, true, 7, 7, false),
			array(2, 7, false, true, 8, null, true),
			array(2, 7, true, true, 0, null, true),
			array(2, 7, true, true, 2, 2, false),
			array(2, 7, true, true, 6, 6, false),
			array(2, 7, true, true, 7, 7, false),
			array(2, 7, true, true, 8, null, true),
			array(9, -1, true, false, 0, null, true),
			array(9, -1, true, false, 6, null, true),
		);
	}

	/**
	 * Tests  AbstractMap::offsetGet
	 *
	 * @param   mixed    $fromKey        The from key
	 * @param   mixed    $toKey          The to key
	 * @param   mixed    $fromInclusive  The from inclusive flag
	 * @param   mixed    $toInclusive    The to inclusive flag
	 * @param   mixed    $key            The searched key
	 * @param   mixed    $getValue       The expected value
	 * @param   boolean  $exception      Exception thrown
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::offsetGet
	 *
	 * @dataProvider  cases_offsetGet
	 *
	 * @since   1.0.0
	 */
	public function test_offsetGet($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $getValue, $exception)
	{
		if ($exception)
		{
			$this->setExpectedException('OutOfRangeException');
		}

		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$getValue,
			$sub[$key]
		);
	}

	/**
	 * Data provider for test_count
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_count()
	{
		return array(
			array(2, 7, true, false, 5),
			array(2, 7, false, false, 4),
			array(2, 7, false, true, 5),
			array(2, 7, true, true, 6),
			array(9, -1, true, false, 0),
		);
	}

	/**
	 * Tests  SubMap::count
	 *
	 * @param   mixed  $fromKey        The from key
	 * @param   mixed  $toKey          The to key
	 * @param   mixed  $fromInclusive  The from inclusive flag
	 * @param   mixed  $toInclusive    The to inclusive flag
	 * @param   mixed  $count          The expected count
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::count
	 * @covers  chdemko\SortedCollection\AbstractMap::__get
	 *
	 * @dataProvider  cases_count
	 *
	 * @since   1.0.0
	 */
	public function test_count($fromKey, $toKey, $fromInclusive, $toInclusive, $count)
	{
		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$count,
			count($sub)
		);
	}

	/**
	 * Data provider for test___toString
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases___toString()
	{
		return array(
			array(2, 7, true, false, '{"2":2,"3":3,"4":4,"5":5,"6":6}'),
			array(2, 7, false, false, '{"3":3,"4":4,"5":5,"6":6}'),
			array(2, 7, false, true, '{"3":3,"4":4,"5":5,"6":6,"7":7}'),
			array(2, 7, true, true, '{"2":2,"3":3,"4":4,"5":5,"6":6,"7":7}'),
			array(9, -1, true, false, '[]'),
		);
	}

	/**
	 * Tests  AbstractMap::__toString
	 *
	 * @param   mixed  $fromKey        The from key
	 * @param   mixed  $toKey          The to key
	 * @param   mixed  $fromInclusive  The from inclusive flag
	 * @param   mixed  $toInclusive    The to inclusive flag
	 * @param   mixed  $string         The expected string
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\AbstractMap::__toString
	 *
	 * @dataProvider  cases___toString
	 *
	 * @since   1.0.0
	 */
	public function test___toString($fromKey, $toKey, $fromInclusive, $toInclusive, $string)
	{
		$sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
		$this->assertEquals(
			$string,
			(string) $sub
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
				'{"SubMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"fromKey":2,"fromInclusive":true,"toKey":7,"toInclusive":false}}'
			),
			array(
				2,
				7,
				false,
				false,
				'{"SubMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"fromKey":2,"fromInclusive":false,"toKey":7,"toInclusive":false}}'
			),
			array(
				2,
				7,
				false,
				true,
				'{"SubMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"fromKey":2,"fromInclusive":false,"toKey":7,"toInclusive":true}}'
			),
			array(
				2,
				7,
				true,
				true,
				'{"SubMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"fromKey":2,"fromInclusive":true,"toKey":7,"toInclusive":true}}'
			),
			array(
				9,
				-1,
				true,
				false,
				'{"SubMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"fromKey":9,"fromInclusive":true,"toKey":-1,"toInclusive":false}}'
			),
			array(
				null,
				7,
				null,
				true,
				'{"HeadMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"toKey":7,"toInclusive":true}}'
			),
			array(
				2,
				null,
				true,
				null,
				'{"TailMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},"fromKey":2,"fromInclusive":true}}'
			),
			array(
				null,
				null,
				null,
				null,
				'{"ViewMap":{"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]}}}'
			),
		);
	}

	/**
	 * Tests  SubMap::jsonSerialize
	 *
	 * @param   mixed  $fromKey        The from key
	 * @param   mixed  $toKey          The to key
	 * @param   mixed  $fromInclusive  The from inclusive flag
	 * @param   mixed  $toInclusive    The to inclusive flag
	 * @param   mixed  $string         The expected string
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\SubMap::jsonSerialize
	 * @covers  chdemko\SortedCollection\SubMap::setEmpty
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
