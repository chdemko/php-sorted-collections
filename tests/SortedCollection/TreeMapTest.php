<?php

/**
 * chdemko\SortedCollection\TreeMapTest class
 *
 * @author    Christophe Demko <chdemko@gmail.com>
 * @copyright Copyright (C) 2012-2023 Christophe Demko. All rights reserved.
 *
 * @license BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * TreeMap class test
 *
 * @package    SortedCollection
 * @subpackage Map
 *
 * @since 1.0.0
 */
class TreeMapTest extends TestCase
{
    /**
     * Data provider for testCreate
     *
     * @return array
     *
     * @since 1.0.0
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
     * Tests  TreeMap::create
     *
     * @param array    $values     Initial values
     * @param mixed    $key        Expected root key
     * @param callable $comparator Comparator
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[DataProvider('casesCreate')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::__construct')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::create')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::put')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::initialise')]
    public function testCreate($values, $key, $comparator)
    {
        $tree = TreeMap::create($comparator)->initialise($values);

        if ($comparator !== null) {
            $this->assertEquals(
                $comparator,
                $tree->comparator
            );
        } else {
            $this->assertTrue(
                is_callable($tree->comparator)
            );
        }

        // Set the root property accessible
        $root = (new \ReflectionClass($tree))->getProperty('root');
        $root->setAccessible(true);

        if ($values) {
            $this->assertEquals(
                $key,
                $root->getValue($tree)->key
            );
        } else {
            $this->assertEquals(
                null,
                $root->getValue($tree)
            );
        }
    }

    /**
     * Tests  TreeMap::clear
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::clear')]
    public function testClear()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

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
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::__clone')]
    public function testClone()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::comparator')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    public function testComparator()
    {
        $comparator = function ($key1, $key2) {
            return $key1 - $key2;
        };
        $tree = TreeMap::create($comparator)->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->assertEquals(
            $comparator,
            $tree->comparator
        );
    }

    /**
     * Tests  TreeMap::first
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::first')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::firstKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::firstValue')]
    public function testFirst()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
        $this->expectException('OutOfBoundsException');
        $key = $tree->firstKey;
    }

    /**
     * Tests  TreeMap::last
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::last')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::lastKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::lastValue')]
    public function testLast()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
        $this->expectException('OutOfBoundsException');
        $key = $tree->lastKey;
    }

    /**
     * Tests  TreeMap::predecessor
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::predecessor')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::predecessor')]
    public function testPredecessor()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->assertEquals(
            8,
            $tree->predecessor($tree->last)->key
        );
        $this->expectException('OutOfBoundsException');
        $predecessor = $tree->predecessor($tree->first);
    }

    /**
     * Tests  TreeMap::successor
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::successor')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::successor')]
    public function testSuccessor()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->assertEquals(
            1,
            $tree->successor($tree->first)->key
        );
        $this->expectException('OutOfBoundsException');
        $successor = $tree->successor($tree->last);
    }

    /**
     * Tests  AbstractMap::keys
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::keys')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::keys')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::rewind')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::key')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::current')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::next')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::valid')]
    public function testKeys()
    {
        $empty = true;
        $tree = TreeMap::create();

        foreach ($tree->keys as $key) {
            $empty = false;
        }

        $this->assertEquals(true, $empty);

        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $i = 0;

        foreach ($tree->keys as $index => $key) {
            $this->assertEquals($i, $index);
            $this->assertEquals($i, $key);
            $i++;
        }
    }

    /**
     * Tests  AbstractMap::values
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::values')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::values')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::rewind')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::key')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::current')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::next')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::valid')]
    public function testValues()
    {
        $empty = true;
        $tree = TreeMap::create();

        foreach ($tree->values as $values) {
            $empty = false;
        }

        $this->assertEquals(true, $empty);

        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $i = 0;

        foreach ($tree->values as $value) {
            $this->assertEquals($i, $value);
            $i++;
        }
    }

    /**
     * Tests  TreeMap::__get
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::__get')]
    public function testGetUnexisting()
    {
        $tree = TreeMap::create()->put(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $this->expectException('RuntimeException');
        $unexisting = $tree->unexisting;
    }

    /**
     * Data provider for testLower
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function casesLower()
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
     * Tests  TreeMap::lower
     *
     * @param array $values    Values array
     * @param mixed $key       Key to search for
     * @param mixed $expected  Expected key/value
     * @param mixed $exception Exception to be thrown
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[DataProvider('casesLower')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::lower')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::lowerKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::lowerValue')]
    public function testLower($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
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
     * Data provider for testFloor
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function casesFloor()
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
     * Tests  TreeMap::floor
     *
     * @param array $values    Values array
     * @param mixed $key       Key to search for
     * @param mixed $expected  Expected key/value
     * @param mixed $exception Exception to be thrown
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[DataProvider('casesFloor')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::floor')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::floorKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::floorValue')]
    public function testFloor($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
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
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::find')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::findKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::findValue')]
    public function testFind()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        $this->assertEquals(
            0,
            $tree->findKey(0)
        );
        $this->assertEquals(
            0,
            $tree->findValue(0)
        );

        $tree->clear();
        $this->expectException('OutOfBoundsException');

        $key = $tree->findKey(10);
    }

    /**
     * Data provider for testCeiling
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function casesCeiling()
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
     * Tests  TreeMap::ceiling
     *
     * @param array $values    Values array
     * @param mixed $key       Key to search for
     * @param mixed $expected  Expected key/value
     * @param mixed $exception Exception to be thrown
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[DataProvider('casesCeiling')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::ceiling')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::ceilingKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::ceilingValue')]
    public function testCeiling($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
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
     * Data provider for testHigher
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function casesHigher()
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
     * Tests  TreeMap::higher
     *
     * @param array $values    Values array
     * @param mixed $key       Key to search for
     * @param mixed $expected  Expected key/value
     * @param mixed $exception Exception to be thrown
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[DataProvider('casesHigher')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::higher')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::higherKey')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::higherValue')]
    public function testHigher($values, $key, $expected, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
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
     * Data provider for testOffsetGet
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function casesOffsetGet()
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
     * Tests  TreeMap::offsetGet
     *
     * @param array $values    Values array
     * @param mixed $key       Key to search for
     * @param mixed $value     Expected value
     * @param mixed $exception Exception to be thrown
     *
     * @return void
     *
     * @covers
     *
     * @dataProvider
     *
     * @since 1.0.0
     */
    #[DataProvider('casesOffsetGet')]
    #[CoversFunction('chdemko\SortedCollection\TreeMap::offsetGet')]
    public function testOffsetGet($values, $key, $value, $exception)
    {
        if ($exception) {
            $this->expectException($exception);
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
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::offsetSet')]
    public function testOffsetSet()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $tree[5] = 6;

        $this->assertEquals(
            6,
            $tree[5]
        );
    }

    /**
     * Tests  AbstractMap::offsetExists
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::offsetExists')]
    public function testOffsetExists()
    {
        $tree = TreeMap::create();

        $this->assertFalse(
            isset($tree[10])
        );

        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

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
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::offsetUnset')]
    public function testOffsetUnset()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        unset($tree[3]);

        $this->assertEquals(
            9,
            count($tree)
        );

        $this->expectException('OutOfRangeException');
        $value = $tree[3];
    }

    /**
     * Tests  TreeMap::count
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::count')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    public function testCount()
    {
        $tree = TreeMap::create();

        $this->assertEquals(
            0,
            $tree->count
        );

        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        $this->assertEquals(
            10,
            count($tree)
        );
    }

    /**
     * Tests  AbstractMap::__toString
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__toString')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::toArray')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::getIterator')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::__construct')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::create')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::rewind')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::key')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::current')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::next')]
    #[CoversFunction('chdemko\SortedCollection\Iterator::valid')]
    public function testToString()
    {
        $tree = TreeMap::create();

        $this->assertEquals(
            '[]',
            (string) $tree
        );

        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        $this->assertEquals(
            '[0,1,2,3,4,5,6,7,8,9]',
            (string) $tree
        );
    }

    /**
     * Tests  TreeMap::jsonSerialize
     *
     * @return void
     *
     * @since 1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\TreeMap::jsonSerialize')]
    public function testJsonSerialize()
    {
        $tree = TreeMap::create();

        $this->assertEquals(
            '{"TreeMap":[]}',
            json_encode($tree)
        );

        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        $this->assertEquals(
            '{"TreeMap":[0,1,2,3,4,5,6,7,8,9]}',
            json_encode($tree)
        );
    }
}
