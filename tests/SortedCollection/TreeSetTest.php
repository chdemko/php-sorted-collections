<?php

/**
 * chdemko\SortedCollection\TreeSetTest class
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2023 Christophe Demko. All rights reserved.
 *
 * @license    BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * TreeSet class test
 *
 * @package     SortedCollection
 * @subpackage  Set
 *
 * @since       1.0.0
 */
class TreeSetTest extends TestCase
{
    /**
     * Data provider for testCreate
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesCreate()
    {
        return array(
            array(array(), null, null),
            array(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 3, null),
            array(
                array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
                3,
                function ($key1, $key2) {
                    return $key1 - $key2;
                }
            )
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesCreate')]
    #[CoversFunction('chdemko\SortedCollection\TreeSet::__construct')]
    #[CoversFunction('chdemko\SortedCollection\TreeSet::create')]
    #[CoversFunction('chdemko\SortedCollection\TreeSet::put')]
    #[CoversFunction('chdemko\SortedCollection\TreeSet::initialise')]
    public function testCreate($values, $key, $comparator)
    {
        $set = TreeSet::create($comparator)->initialise($values);

        if ($comparator !== null) {
            $this->assertEquals(
                $comparator,
                $set->comparator
            );
        } else {
            $this->assertTrue(
                is_callable($set->comparator)
            );
        }

        // Set the map property accessible
        $getMap = (new \ReflectionClass($set))->getMethod('getMap');
        $getMap->setAccessible(true);
        $map = $getMap->invoke($set);

        // Set the root property accessible
        $root = (new \ReflectionClass($map))->getProperty('root');
        $root->setAccessible(true);

        if ($values) {
            $this->assertEquals(
                $key,
                $root->getValue($map)->key
            );
        } else {
            $this->assertEquals(
                null,
                $root->getValue($map)
            );
        }
    }

    /**
     * Tests  TreeSet::getMap
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::getMap')]
    public function testGetMap()
    {
        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        // Set the map property accessible
        $getMap = (new \ReflectionClass($set))->getMethod('getMap');
        $getMap->setAccessible(true);
        $map = $getMap->invoke($set);

        $this->assertEquals(
            '[true,true,true,true,true,true,true,true,true,true]',
            (string) $map
        );
    }

    /**
     * Tests  TreeSet::setMap
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::setMap')]
    public function testSetMap()
    {
        $set = TreeSet::create();

        // Set the map property accessible
        $setMap = (new \ReflectionClass($set))->getMethod('setMap');
        $setMap->setAccessible(true);
        $setMap->invoke($set, TreeMap::create()->put(array(true, true, true)));

        $getMap = (new \ReflectionClass($set))->getMethod('getMap');
        $getMap->setAccessible(true);
        $map = $getMap->invoke($set);

        $this->assertEquals(
            '[true,true,true]',
            (string) $map
        );
    }

    /**
     * Tests  TreeSet::clear
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeSet::clear')]
    public function testClear()
    {
        $set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        // Set the map property accessible
        $getMap = (new \ReflectionClass($set))->getMethod('getMap');
        $getMap->setAccessible(true);
        $map = $getMap->invoke($set);

        // Set the root property accessible
        $root = (new \ReflectionClass($map))->getProperty('root');
        $root->setAccessible(true);

        $this->assertEquals(
            $set,
            $set->clear()
        );

        $this->assertEquals(
            null,
            $root->getValue($map)
        );
    }

    /**
     * Tests  TreeSet::__clone
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeSet::__clone')]
    public function testClone()
    {
        $set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::comparator')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::__get')]
    public function testComparator()
    {
        $comparator = function ($key1, $key2) {
            return $key1 - $key2;
        };
        $set = TreeSet::create($comparator)->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::first')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::__get')]
    public function testFirst()
    {
        $set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->assertEquals(
            0,
            $set->first
        );
        $set->clear();
        $this->expectException('OutOfBoundsException');
        $key = $set->first;
    }

    /**
     * Tests  AbstractSet::last
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::last')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::__get')]
    public function testLast()
    {
        $set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->assertEquals(
            9,
            $set->last
        );
        $set->clear();
        $this->expectException('OutOfBoundsException');
        $key = $set->last;
    }

    /**
     * Tests  AbstractSet::__get
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::__get')]
    public function testGetUnexisting()
    {
        $set = TreeSet::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->expectException('RuntimeException');
        $unexisting = $set->unexisting;
    }

    /**
     * Data provider for testLower
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesLower()
    {
        return array(
            array(array(), 10, null, 'OutOfBoundsException'),
            array(array(1), 1, null, 'OutOfBoundsException'),
            array(array(0, 1), 0, null, 'OutOfBoundsException'),
            array(array(1, 2), 0, null, 'OutOfBoundsException'),
            array(array(0, 1), 1, 0, null),
            array(array(0, 1), 2, 1, null),
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesLower')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::lower')]
    public function testLower($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
        }

        $set = TreeSet::create()->initialise($values);

        $this->assertEquals(
            $expected,
            $set->lower($key)
        );
    }

    /**
     * Data provider for testFloor
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesFloor()
    {
        return array(
            array(array(), 10, null, 'OutOfBoundsException'),
            array(array(1), 1, 1, null),
            array(array(0, 1), 0, 0, null),
            array(array(1, 2), 0, null, 'OutOfBoundsException'),
            array(array(0, 1), 1, 1, null),
            array(array(0, 1), 2, 1, null),
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesFloor')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::floor')]
    public function testFloor($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::find')]
    public function testFind()
    {
        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        $this->assertEquals(
            0,
            $set->find(0)
        );

        $set->clear();
        $this->expectException('OutOfBoundsException');

        $key = $set->find(10);
    }

    /**
     * Data provider for testCeiling
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesCeiling()
    {
        return array(
            array(array(), 10, null, 'OutOfBoundsException'),
            array(array(1), 1, 1, null),
            array(array(0, 1), 0, 0, null),
            array(array(1, 2), 0, 1, null),
            array(array(0, 1), 1, 1, null),
            array(array(0, 1), 2, null, 'OutOfBoundsException'),
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesCeiling')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::ceiling')]
    public function testCeiling($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
        }

        $set = TreeSet::create()->initialise($values);

        $this->assertEquals(
            $expected,
            $set->ceiling($key)
        );
    }

    /**
     * Data provider for testHigher
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesHigher()
    {
        return array(
            array(array(), 10, null, 'OutOfBoundsException'),
            array(array(1), 1, null, 'OutOfBoundsException'),
            array(array(0, 1), 0, 1, null),
            array(array(1, 2), 0, 1, null),
            array(array(0, 1), 1, null, 'OutOfBoundsException'),
            array(array(0, 1), 2, null, 'OutOfBoundsException'),
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesHigher')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::higher')]
    public function testHigher($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
        }

        $set = TreeSet::create()->initialise($values);

        $this->assertEquals(
            $expected,
            $set->higher($key)
        );
    }

    /**
     * Data provider for testOffsetGet
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesOffsetGet()
    {
        return array(
            array(array(), 0, false),
            array(array(0), 1, false),
            array(array(1), 1, true),
            array(array(0, 1), 0, true),
            array(array(0, 1), 1, true),
            array(array(0, 1), 2, false),
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesOffsetGet')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::offsetGet')]
    public function testOffsetGet($values, $key, $value)
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeSet::offsetSet')]
    public function testOffsetSet()
    {
        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::offsetExists')]
    public function testOffsetExists()
    {
        $set = TreeSet::create();

        $this->assertFalse(
            isset($set[10])
        );

        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeSet::offsetUnset')]
    public function testOffsetUnset()
    {
        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::count')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::__get')]
    public function testCount()
    {
        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::__toString')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::toArray')]
    #[CoversFunction('chdemko\SortedCollection\AbstractSet::getIterator')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::create')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::rewind')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::key')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::current')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::next')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::valid')]
    public function testToString()
    {
        $set = TreeSet::create();

        $this->assertEquals(
            '[]',
            (string) $set
        );

        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeSet::jsonSerialize')]
    public function testJsonSerialize()
    {
        $set = TreeSet::create();

        $this->assertEquals(
            '{"TreeSet":[]}',
            json_encode($set)
        );

        $set = TreeSet::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        $this->assertEquals(
            '{"TreeSet":[0,1,2,3,4,5,6,7,8,9]}',
            json_encode($set)
        );
    }
}
