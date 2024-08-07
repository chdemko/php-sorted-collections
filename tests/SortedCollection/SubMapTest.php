<?php

/**
 * chdemko\SortedCollection\SubMapTest class
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2024 Christophe Demko. All rights reserved.
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
 * SubMap class test
 *
 * @package     SortedCollection
 * @subpackage  Map
 *
 * @since       1.0.0
 */
class SubMapTest extends TestCase
{
    /**
     * Tests  SubMap::create
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::create')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__construct')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::setEmpty')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__set')]
    public function testCreate()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::head')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__construct')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testHead()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::tail')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__construct')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testTail()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::view')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__construct')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testCopy()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testGetFromKey()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $head = SubMap::head($tree, 7);

        $this->expectException('RuntimeException');
        $fromKey = $head->fromKey;
    }

    /**
     * Tests  SubMap::__get
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testGetToKey()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $tail = SubMap::tail($tree, 2);

        $this->expectException('RuntimeException');
        $toKey = $tail->toKey;
    }

    /**
     * Tests  SubMap::__get
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testGetFromInclusive()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $head = SubMap::head($tree, 7);

        $this->expectException('RuntimeException');
        $fromInclusive = $head->fromInclusive;
    }

    /**
     * Tests  SubMap::__get
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    public function testGetToInclusive()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $tail = SubMap::tail($tree, 2);

        $this->expectException('RuntimeException');
        $toInclusive = $tail->toInclusive;
    }

    /**
     * Tests  SubMap::__set
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__set')]
    public function testSetFromKey()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__set')]
    public function testSetToKey()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__set')]
    public function testSetFromInclusive()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::head($tree, 7);
        $this->expectException('RuntimeException');
        $sub->fromInclusive = true;
    }

    /**
     * Tests  SubMap::__set
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__set')]
    public function testSetToInclusive()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::tail($tree, 2);
        $this->expectException('RuntimeException');
        $sub->toInclusive = true;
    }

    /**
     * Tests  SubMap::__set
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__set')]
    public function testSetUnexisting()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::head($tree, 7);
        $this->expectException('RuntimeException');
        $sub->unexisting = true;
    }

    /**
     * Tests  SubMap::__unset
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__unset')]
    public function testUnsetFromKey()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::tail($tree, 2);
        unset($sub->fromKey);
        $this->expectException('RuntimeException');
        $fromKey = $sub->fromKey;
    }

    /**
     * Tests  SubMap::__unset
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__unset')]
    public function testUnsetToKey()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::head($tree, 7);
        unset($sub->toKey);
        $this->expectException('RuntimeException');
        $toKey = $sub->toKey;
    }

    /**
     * Tests  SubMap::__unset
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__unset')]
    public function testUnsetFromInclusive()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::head($tree, 7);
        unset($sub->fromInclusive);
        $this->expectException('RuntimeException');
        $fromKey = $sub->fromKey;
    }

    /**
     * Tests  SubMap::__unset
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__unset')]
    public function testUnsetToInclusive()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::head($tree, 7);
        unset($sub->toInclusive);
        $this->expectException('RuntimeException');
        $toKey = $sub->toKey;
    }

    /**
     * Tests  SubMap::__unset
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__unset')]
    public function testUnsetUnexisting()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
        $sub = SubMap::tail($tree, 2);
        $this->expectException('RuntimeException');
        unset($sub->unexisting);
    }

    /**
     * Tests  SubMap::__isset
     *
     * @return  void
     *
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__isset')]
    public function testIssetFrom()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__isset')]
    public function testIssetTo()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::__isset')]
    public function testIssetUnexisting()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
     * @since   1.0.0
     */
    #[CoversFunction('chdemko\SortedCollection\SubMap::comparator')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    public function testComparator()
    {
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
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
        $tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

        if ($fromInclusive === null) {
            if ($toInclusive === null) {
                $sub = SubMap::view($tree);
            } else {
                $sub = SubMap::head($tree, $toKey, $toInclusive);
            }
        } elseif ($toInclusive === null) {
            $sub = SubMap::tail($tree, $fromKey, $fromInclusive);
        } else {
            $sub = SubMap::create($tree, $fromKey, $toKey, $fromInclusive, $toInclusive);
        }

        return $sub;
    }

    /**
     * Data provider for testFirst
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesFirst()
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
     * @since   1.0.0
     */
    #[DataProvider('casesFirst')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::first')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    public function testFirst($fromKey, $toKey, $fromInclusive, $toInclusive, $firstKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $this->assertEquals(
            $firstKey,
            $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive)->firstKey
        );
    }

    /**
     * Data provider for testLast
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesLast()
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
     * @since   1.0.0
     */
    #[DataProvider('casesLast')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::last')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::__get')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    public function testLast($fromKey, $toKey, $fromInclusive, $toInclusive, $lastKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $this->assertEquals(
            $lastKey,
            $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive)->lastKey
        );
    }

    /**
     * Data provider for testPredecessor
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesPredecessor()
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
     * @since   1.0.0
     */
    #[DataProvider('casesPredecessor')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::predecessor')]
    public function testPredecessor($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $predecessorKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $predecessorKey,
            $sub->predecessor($sub->find($key))->key
        );
    }

    /**
     * Data provider for testSuccessor
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesSuccessor()
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
     * @since   1.0.0
     */
    #[DataProvider('casesSuccessor')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::successor')]
    public function testSuccessor($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $successorKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $successorKey,
            $sub->successor($sub->find($key))->key
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesLower')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::lower')]
    public function testLower($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $lowerKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $lowerKey,
            $sub->lowerKey($key)
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
     * @since   1.0.0
     */
    #[DataProvider('casesFloor')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::floor')]
    public function testFloor($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $floorKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $floorKey,
            $sub->floorKey($key)
        );
    }

    /**
     * Data provider for testFind
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesFind()
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
     * @since   1.0.0
     */
    #[DataProvider('casesFind')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::find')]
    public function testFind($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $findKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $findKey,
            $sub->findKey($key)
        );
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
     * @since   1.0.0
     */
    #[DataProvider('casesCeiling')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::ceiling')]
    public function testCeiling($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $ceilingKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $ceilingKey,
            $sub->ceilingKey($key)
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
     * @since   1.0.0
     */
    #[DataProvider('casesHigher')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::higher')]
    public function testHigher($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $higherKey, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfBoundsException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $higherKey,
            $sub->higherKey($key)
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
     * @since   1.0.0
     */
    #[DataProvider('casesOffsetGet')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::offsetGet')]
    public function testOffsetGet($fromKey, $toKey, $fromInclusive, $toInclusive, $key, $getValue, $exception)
    {
        if ($exception) {
            $this->expectException('OutOfRangeException');
        }

        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $getValue,
            $sub[$key]
        );
    }

    /**
     * Data provider for testCount
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesCount()
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
     * @since   1.0.0
     */
    #[DataProvider('casesCount')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::count')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__get')]
    public function testCount($fromKey, $toKey, $fromInclusive, $toInclusive, $count)
    {
        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $count,
            count($sub)
        );
    }

    /**
     * Data provider for testToString
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesToString()
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
     * @since   1.0.0
     */
    #[DataProvider('casesToString')]
    #[CoversFunction('chdemko\SortedCollection\AbstractMap::__toString')]
    public function testToString($fromKey, $toKey, $fromInclusive, $toInclusive, $string)
    {
        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $string,
            (string) $sub
        );
    }

    /**
     * Data provider for testJsonSerialize
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function casesJsonSerialize()
    {
        return array(
            array(
                2,
                7,
                true,
                false,
                '{"SubMap":{' .
                    '"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},' .
                    '"fromKey":2,' .
                    '"fromInclusive":true,' .
                    '"toKey":7,' .
                    '"toInclusive":false' .
                '}}'
            ),
            array(
                2,
                7,
                false,
                false,
                '{"SubMap":{' .
                    '"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},' .
                    '"fromKey":2,' .
                    '"fromInclusive":false,' .
                    '"toKey":7,' .
                    '"toInclusive":false' .
                '}}'
            ),
            array(
                2,
                7,
                false,
                true,
                '{"SubMap":{' .
                    '"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},' .
                    '"fromKey":2,' .
                    '"fromInclusive":false,' .
                    '"toKey":7,' .
                    '"toInclusive":true' .
                '}}'
            ),
            array(
                2,
                7,
                true,
                true,
                '{"SubMap":{' .
                    '"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},' .
                    '"fromKey":2,' .
                    '"fromInclusive":true,' .
                    '"toKey":7,' .
                    '"toInclusive":true' .
                '}}'
            ),
            array(
                9,
                -1,
                true,
                false,
                '{"SubMap":{' .
                    '"map":{"TreeMap":[0,1,2,3,4,5,6,7,8,9]},' .
                    '"fromKey":9,' .
                    '"fromInclusive":true,' .
                    '"toKey":-1,' .
                    '"toInclusive":false' .
                '}}'
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
     * @since   1.0.0
     */
    #[DataProvider('casesJsonSerialize')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::jsonSerialize')]
    #[CoversFunction('chdemko\SortedCollection\SubMap::setEmpty')]
    public function testJsonSerialize($fromKey, $toKey, $fromInclusive, $toInclusive, $string)
    {
        $sub = $this->createSub($fromKey, $toKey, $fromInclusive, $toInclusive);
        $this->assertEquals(
            $string,
            json_encode($sub)
        );
    }
}
