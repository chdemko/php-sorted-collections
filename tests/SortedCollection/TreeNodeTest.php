<?php

/**
 * chdemko\SortedCollection\TreeNodeTest class
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2018 Christophe Demko. All rights reserved.
 *
 * @license    BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

use PHPUnit\Framework\TestCase;

/**
 * TreeNode class test
 *
 * @package  SortedCollection
 *
 * @since    1.0.0
 */
class TreeNodeTest extends TestCase
{
	/**
	 * Transform a tree map node to a string
	 *
	 * @param   TreeNode  $node  A Tree Map Node
	 *
	 * @return  string
	 *
	 * @since   1.0.0
	 */
	protected function nodeToString($node)
	{
		if ($node != null)
		{
			$string = '(';

			// Set the key property accessible
			$key = (new \ReflectionClass($node))->getProperty('key');
			$key->setAccessible(true);
			$string .= $key->getValue($node);

			// Set the value property accessible
			$value = (new \ReflectionClass($node))->getProperty('value');
			$value->setAccessible(true);
			$string .= ',' . $value->getValue($node);

			// Set the information property accessible
			$information = (new \ReflectionClass($node))->getProperty('information');
			$information->setAccessible(true);

			$string .= ',' . (($information->getValue($node) & ~3) / 4);

			if ($information->getValue($node) & 2)
			{
				// Set the left property accessible
				$left = (new \ReflectionClass($node))->getProperty('left');
				$left->setAccessible(true);
				$string .= ',' . $this->nodeToString($left->getValue($node));
			}
			else
			{
				$string .= ',';
			}

			if ($information->getValue($node) & 1)
			{
				// Set the right property accessible
				$right = (new \ReflectionClass($node))->getProperty('right');
				$right->setAccessible(true);
				$string .= ',' . $this->nodeToString($right->getValue($node));
			}
			else
			{
				$string .= ',';
			}

			$string .= ')';
		}
		else
		{
			$string = '()';
		}

		return $string;
	}

	/**
	 * Data provider for testCreate
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function casesCreate()
	{
		return array(
			array(array(), null, '()'),
			array(
				array(),
				function ($key1, $key2)
				{
					return $key1 - $key2;
				},
				'()'
			),
			array(
				array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
				null,
				'(3,3,1,(1,1,0,(0,0,0,,),(2,2,0,,)),(7,7,0,(5,5,0,(4,4,0,,),(6,6,0,,)),(8,8,1,,(9,9,0,,))))'
			),
		);
	}

	/**
	 * Tests  TreeNode::create
	 *
	 * @param   array     $values      Values array
	 * @param   callable  $comparator  Comparator function
	 * @param   string    $string      String representation of the tree
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::create
	 *
	 * @dataProvider  casesCreate
	 *
	 * @since   1.0.0
	 */
	public function testCreate($values, $comparator, $string)
	{
		$tree = TreeMap::create($comparator)->initialise($values);

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			$string,
			$this->nodeToString($root->getValue($tree))
		);
	}

	/**
	 * Tests  TreeNode::first
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::first
	 * @covers  chdemko\SortedCollection\TreeNode::__get
	 *
	 * @since   1.0.0
	 */
	public function testFirst()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			0,
			$root->getValue($tree)->first->key
		);
	}

	/**
	 * Tests  TreeNode::last
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::last
	 * @covers  chdemko\SortedCollection\TreeNode::__get
	 *
	 * @since   1.0.0
	 */
	public function testLast()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			9,
			$root->getValue($tree)->last->key
		);
	}

	/**
	 * Tests  TreeNode::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::__get
	 *
	 * @since   1.0.0
	 */
	public function testGetUnexisting()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->expectException('RuntimeException');
		$unexisting = $root->getValue($tree)->unexisting;
	}

	/**
	 * Tests  TreeNode::__get
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::__get
	 * @covers  chdemko\SortedCollection\TreeNode::first
	 * @covers  chdemko\SortedCollection\TreeNode::last
	 * @covers  chdemko\SortedCollection\TreeNode::predecessor
	 * @covers  chdemko\SortedCollection\TreeNode::successor
	 *
	 * @since   1.0.0
	 */
	public function testGet()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			3,
			$root->getValue($tree)->key
		);

		$this->assertEquals(
			4,
			$root->getValue($tree)->successor->key
		);

		$this->assertEquals(
			2,
			$root->getValue($tree)->predecessor->key
		);

		$this->assertEquals(
			0,
			$root->getValue($tree)->first->key
		);

		$this->assertEquals(
			9,
			$root->getValue($tree)->last->key
		);

		$this->assertEquals(
			null,
			$root->getValue($tree)->first->predecessor
		);

		$this->assertEquals(
			null,
			$root->getValue($tree)->last->successor
		);
	}

	/**
	 * Tests  TreeNode::count
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::count
	 * @covers  chdemko\SortedCollection\TreeNode::__get
	 *
	 * @since   1.0.0
	 */
	public function testCount()
	{
		$tree = TreeMap::create()->initialise(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			10,
			$root->getValue($tree)->count
		);
	}

	/**
	 * Data provider for testFind
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function casesFind()
	{
		return array(
			array(array(1, 3), -2, 0, null),
			array(array(1, 3), -1, 0, null),
			array(array(1, 3),  0, 0, null),
			array(array(1, 3),  1, 0, 1),
			array(array(1, 3),  2, 0, 1),
			array(array(1, 3), -2, 1, null),
			array(array(1, 3), -1, 1, 1),
			array(array(1, 3),  0, 1, 1),
			array(array(1, 3),  1, 1, 1),
			array(array(1, 3),  2, 1, 3),
			array(array(1, 3), -2, 2, 1),
			array(array(1, 3), -1, 2, 1),
			array(array(1, 3),  0, 2, null),
			array(array(1, 3),  1, 2, 3),
			array(array(1, 3),  2, 2, 3),
			array(array(1, 3), -2, 3, 1),
			array(array(1, 3), -1, 3, 3),
			array(array(1, 3),  0, 3, 3),
			array(array(1, 3),  1, 3, 3),
			array(array(1, 3),  2, 3, null),
			array(array(1, 3), -2, 4, 3),
			array(array(1, 3), -1, 4, 3),
			array(array(1, 3),  0, 4, null),
			array(array(1, 3),  1, 4, null),
			array(array(1, 3),  2, 4, null),

			array(array(3, 1), -2, 0, null),
			array(array(3, 1), -1, 0, null),
			array(array(3, 1),  0, 0, null),
			array(array(3, 1),  1, 0, 1),
			array(array(3, 1),  2, 0, 1),
			array(array(3, 1), -2, 1, null),
			array(array(3, 1), -1, 1, 1),
			array(array(3, 1),  0, 1, 1),
			array(array(3, 1),  1, 1, 1),
			array(array(3, 1),  2, 1, 3),
			array(array(3, 1), -2, 2, 1),
			array(array(3, 1), -1, 2, 1),
			array(array(3, 1),  0, 2, null),
			array(array(3, 1),  1, 2, 3),
			array(array(3, 1),  2, 2, 3),
			array(array(3, 1), -2, 3, 1),
			array(array(3, 1), -1, 3, 3),
			array(array(3, 1),  0, 3, 3),
			array(array(3, 1),  1, 3, 3),
			array(array(3, 1),  2, 3, null),
			array(array(3, 1), -2, 4, 3),
			array(array(3, 1), -1, 4, 3),
			array(array(3, 1),  0, 4, null),
			array(array(3, 1),  1, 4, null),
			array(array(3, 1),  2, 4, null),
		);
	}

	/**
	 * Tests  TreeNode::find
	 *
	 * @param   array    $values  Initial values
	 * @param   integer  $type    Search type (-2, -1, 0, 1 or 2)
	 * @param   mixed    $key     Searched key
	 * @param   mixed    $node    Value expected or null
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::find
	 *
	 * @dataProvider  casesFind
	 *
	 * @since   1.0.0
	 */
	public function testFind($values, $type, $key, $node)
	{
		$tree = TreeMap::create();

		foreach ($values as $value)
		{
			$tree[$value] = $value;
		}

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		if ($node === null)
		{
			$this->assertEquals(
				null,
				$root->getValue($tree)->find($key, $tree->comparator, $type)
			);
		}
		else
		{
			$this->assertEquals(
				$node,
				$root->getValue($tree)->find($key, $tree->comparator, $type)->key
			);
		}
	}

	/**
	 * Compute the node height.
	 *
	 * @param   TreeNode  $node  the tree node to calculate the height
	 *
	 * @return  the node height
	 */
	protected function height($node)
	{
		$height = 0;

		if ($node != null)
		{
			$information = (new \ReflectionClass($node))->getProperty('information');
			$information->setAccessible(true);
			$information = $information->getValue($node);

			if ($information & 2)
			{
				$left = (new \ReflectionClass($node))->getProperty('left');
				$left->setAccessible(true);
				$height = $this->height($left->getValue($node));
			}

			if ($information & 1)
			{
				$right = (new \ReflectionClass($node))->getProperty('right');
				$right->setAccessible(true);
				$height = max($height, $this->height($right->getValue($node)));
			}

			$height++;
		}

		return $height;
	}

	/**
	 * Verify the height of a tree node
	 *
	 * @param   TreeNode  $node  the tree node to verify
	 *
	 * @return  void
	 */
	protected function verifyHeight($node)
	{
		if ($node != null)
		{
			$leftHeight = 0;
			$rightHeight = 0;
			$information = (new \ReflectionClass($node))->getProperty('information');
			$information->setAccessible(true);
			$information = $information->getValue($node);

			if ($information & 2)
			{
				$left = (new \ReflectionClass($node))->getProperty('left');
				$left->setAccessible(true);
				$this->verifyHeight($left->getValue($node));
				$leftHeight = $this->height($left->getValue($node));
			}

			if ($information & 1)
			{
				$right = (new \ReflectionClass($node))->getProperty('right');
				$right->setAccessible(true);
				$this->verifyHeight($right->getValue($node));
				$rightHeight = $this->height($right->getValue($node));
			}

			$this->assertEquals($rightHeight - $leftHeight, $information >> 2);
			$this->assertTrue($rightHeight - $leftHeight <= 1);
			$this->assertTrue($rightHeight - $leftHeight >= -1);
		}
	}

	/**
	 * Data provider for testInsert and testRemove
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function casesModify()
	{
		return array(
			// 1 node
			array(array(1)),

			// 2 nodes
			array(array(1, 1)),
			array(array(1, 0)),

			// 3 nodes
			array(array(0, 1, 2)),
			array(array(0, 2, 1)),
			array(array(1, 2, 0)),
			array(array(1, 0, 2)),
			array(array(2, 0, 1)),
			array(array(2, 1, 0)),

			// 4 nodes
			array(array(1, 2, 3, 0)),
			array(array(0, 2, 3, 1)),
			array(array(0, 1, 3, 2)),
			array(array(0, 1, 2, 3)),

			// 5 nodes
			array(array(2, 3, 4, 1, 0)),
			array(array(1, 3, 4, 2, 0)),
			array(array(1, 2, 4, 3, 0)),
			array(array(1, 2, 3, 4, 0)),

			// 5 nodes
			array(array(2, 3, 4, 0, 1)),
			array(array(0, 3, 4, 2, 1)),
			array(array(0, 2, 4, 3, 1)),
			array(array(0, 2, 3, 4, 1)),

			// 5 nodes
			array(array(1, 3, 4, 0, 2)),
			array(array(0, 3, 4, 1, 2)),
			array(array(0, 1, 4, 3, 2)),
			array(array(0, 1, 3, 4, 2)),

			// 5 nodes
			array(array(1, 2, 4, 0, 3)),
			array(array(0, 2, 4, 1, 3)),
			array(array(0, 1, 4, 2, 3)),
			array(array(0, 1, 2, 4, 3)),

			// 5 nodes
			array(array(1, 2, 3, 0, 4)),
			array(array(0, 2, 3, 1, 4)),
			array(array(0, 1, 3, 2, 4)),
			array(array(0, 1, 2, 3, 4)),

			// 6 nodes
			array(array(3, 4, 5, 2, 1, 0)),
			array(array(2, 3, 5, 4, 1, 0)),
			array(array(2, 3, 4, 5, 1, 0)),
			array(array(1, 3, 5, 4, 2, 0)),
			array(array(1, 3, 4, 5, 2, 0)),
			array(array(1, 2, 5, 4, 3, 0)),

			// 6 nodes
			array(array(3, 4, 5, 2, 0, 1)),
			array(array(2, 3, 5, 4, 0, 1)),
			array(array(2, 3, 4, 5, 0, 1)),
			array(array(0, 3, 5, 4, 2, 1)),
			array(array(0, 3, 4, 5, 2, 1)),
			array(array(0, 2, 5, 4, 3, 1)),

			// 6 nodes
			array(array(3, 4, 5, 1, 0, 2)),
			array(array(1, 3, 5, 4, 0, 2)),
			array(array(1, 3, 4, 5, 0, 2)),
			array(array(0, 3, 5, 4, 1, 2)),
			array(array(0, 3, 4, 5, 1, 2)),
			array(array(0, 1, 5, 4, 3, 2)),

			// 6 nodes
			array(array(2, 4, 5, 1, 0, 3)),
			array(array(1, 2, 5, 4, 0, 3)),
			array(array(1, 2, 4, 5, 0, 3)),
			array(array(0, 2, 5, 4, 1, 3)),
			array(array(0, 2, 4, 5, 1, 3)),
			array(array(0, 1, 5, 4, 2, 3)),

			// 6 nodes
			array(array(2, 3, 5, 1, 0, 4)),
			array(array(1, 2, 5, 3, 0, 4)),
			array(array(1, 2, 3, 5, 0, 4)),
			array(array(0, 2, 5, 3, 1, 4)),
			array(array(0, 2, 3, 5, 1, 4)),
			array(array(0, 1, 5, 3, 2, 4)),

			// 6 nodes
			array(array(2, 3, 4, 1, 0, 5)),
			array(array(1, 2, 4, 3, 0, 5)),
			array(array(1, 2, 3, 4, 0, 5)),
			array(array(0, 2, 4, 3, 1, 5)),
			array(array(0, 2, 3, 4, 1, 5)),
			array(array(0, 1, 4, 3, 2, 5)),

			// 7 nodes
			array(array(4, 5, 6, 3, 2, 1, 0)),
			array(array(3, 4, 6, 5, 2, 1, 0)),
			array(array(3, 4, 5, 6, 2, 1, 0)),
			array(array(4, 5, 6, 3, 1, 2, 0)),

			// 7 nodes
			array(array(4, 5, 6, 3, 2, 0, 1)),
			array(array(3, 4, 6, 5, 2, 0, 1)),
			array(array(3, 4, 5, 6, 2, 0, 1)),
			array(array(4, 5, 6, 3, 0, 2, 1)),

			// 7 nodes
			array(array(4, 5, 6, 3, 1, 0, 2)),
			array(array(3, 4, 6, 5, 1, 0, 2)),
			array(array(3, 4, 5, 6, 1, 0, 2)),
			array(array(4, 5, 6, 3, 0, 1, 2)),

			// 7 nodes
			array(array(4, 5, 6, 2, 1, 0, 3)),
			array(array(2, 4, 6, 5, 1, 0, 3)),
			array(array(2, 4, 5, 6, 1, 0, 3)),
			array(array(4, 5, 6, 2, 0, 1, 3)),

			// 7 nodes
			array(array(3, 5, 6, 2, 1, 0, 4)),
			array(array(2, 3, 6, 5, 1, 0, 4)),
			array(array(2, 3, 5, 6, 1, 0, 4)),
			array(array(3, 5, 6, 2, 0, 1, 4)),

			// 7 nodes
			array(array(3, 4, 6, 2, 1, 0, 5)),
			array(array(2, 3, 6, 4, 1, 0, 5)),
			array(array(2, 3, 4, 6, 1, 0, 5)),
			array(array(3, 4, 6, 2, 0, 1, 5)),

			// 7 nodes
			array(array(3, 4, 5, 2, 1, 0, 6)),
			array(array(2, 3, 5, 4, 1, 0, 6)),
			array(array(2, 3, 4, 5, 1, 0, 6)),
			array(array(3, 4, 5, 2, 0, 1, 6)),

			// 8 nodes
			array(array(1, 2, 3, 4, 5, 6, 7, 0)),
			array(array(0, 2, 3, 4, 5, 6, 7, 1)),
			array(array(0, 1, 3, 4, 5, 6, 7, 2)),
			array(array(0, 1, 2, 4, 5, 6, 7, 3)),
			array(array(0, 1, 2, 3, 5, 6, 7, 4)),
			array(array(0, 1, 2, 3, 4, 6, 7, 5)),
			array(array(0, 1, 2, 3, 4, 5, 7, 6)),
			array(array(0, 1, 2, 3, 4, 5, 6, 7)),

			// 9 nodes
			array(array(2, 3, 4, 5, 6, 7, 8, 0, 1)),
			array(array(1, 3, 4, 5, 6, 7, 8, 0, 2)),
			array(array(1, 2, 4, 5, 6, 7, 8, 0, 3)),
			array(array(1, 2, 3, 5, 6, 7, 8, 0, 4)),
			array(array(1, 2, 3, 4, 6, 7, 8, 0, 5)),
			array(array(1, 2, 3, 4, 5, 7, 8, 0, 6)),
			array(array(1, 2, 3, 4, 5, 6, 8, 0, 7)),
			array(array(1, 2, 3, 4, 5, 6, 7, 0, 8)),

			// 9 nodes
			array(array(2, 3, 4, 5, 6, 7, 8, 1, 0)),
			array(array(0, 3, 4, 5, 6, 7, 8, 1, 2)),
			array(array(0, 2, 4, 5, 6, 7, 8, 1, 3)),
			array(array(0, 2, 3, 5, 6, 7, 8, 1, 4)),
			array(array(0, 2, 3, 4, 6, 7, 8, 1, 5)),
			array(array(0, 2, 3, 4, 5, 7, 8, 1, 6)),
			array(array(0, 2, 3, 4, 5, 6, 8, 1, 7)),
			array(array(0, 2, 3, 4, 5, 6, 7, 1, 8)),

			// 9 nodes
			array(array(1, 3, 4, 5, 6, 7, 8, 2, 0)),
			array(array(0, 3, 4, 5, 6, 7, 8, 2, 1)),
			array(array(0, 1, 4, 5, 6, 7, 8, 2, 3)),
			array(array(0, 1, 3, 5, 6, 7, 8, 2, 4)),
			array(array(0, 1, 3, 4, 6, 7, 8, 2, 5)),
			array(array(0, 1, 3, 4, 5, 7, 8, 2, 6)),
			array(array(0, 1, 3, 4, 5, 6, 8, 2, 7)),
			array(array(0, 1, 3, 4, 5, 6, 7, 2, 8)),

			// 9 nodes
			array(array(1, 2, 4, 5, 6, 7, 8, 3, 0)),
			array(array(0, 2, 4, 5, 6, 7, 8, 3, 1)),
			array(array(0, 1, 4, 5, 6, 7, 8, 3, 2)),
			array(array(0, 1, 2, 5, 6, 7, 8, 3, 4)),
			array(array(0, 1, 2, 4, 6, 7, 8, 3, 5)),
			array(array(0, 1, 2, 4, 5, 7, 8, 3, 6)),
			array(array(0, 1, 2, 4, 5, 6, 8, 3, 7)),
			array(array(0, 1, 2, 4, 5, 6, 7, 3, 8)),

			// 9 nodes
			array(array(1, 2, 3, 5, 6, 7, 8, 4, 0)),
			array(array(0, 2, 3, 5, 6, 7, 8, 4, 1)),
			array(array(0, 1, 3, 5, 6, 7, 8, 4, 2)),
			array(array(0, 1, 2, 5, 6, 7, 8, 4, 3)),
			array(array(0, 1, 2, 3, 6, 7, 8, 4, 5)),
			array(array(0, 1, 2, 3, 5, 7, 8, 4, 6)),
			array(array(0, 1, 2, 3, 5, 6, 8, 4, 7)),
			array(array(0, 1, 2, 3, 5, 6, 7, 4, 8)),

			// 9 nodes
			array(array(1, 2, 3, 4, 6, 7, 8, 5, 0)),
			array(array(0, 2, 3, 4, 6, 7, 8, 5, 1)),
			array(array(0, 1, 3, 4, 6, 7, 8, 5, 2)),
			array(array(0, 1, 2, 4, 6, 7, 8, 5, 3)),
			array(array(0, 1, 2, 3, 6, 7, 8, 5, 4)),
			array(array(0, 1, 2, 3, 4, 7, 8, 5, 6)),
			array(array(0, 1, 2, 3, 4, 6, 8, 5, 7)),
			array(array(0, 1, 2, 3, 4, 6, 7, 5, 8)),

			// 9 nodes
			array(array(1, 2, 3, 4, 5, 7, 8, 6, 0)),
			array(array(0, 2, 3, 4, 5, 7, 8, 6, 1)),
			array(array(0, 1, 3, 4, 5, 7, 8, 6, 2)),
			array(array(0, 1, 2, 4, 5, 7, 8, 6, 3)),
			array(array(0, 1, 2, 3, 5, 7, 8, 6, 4)),
			array(array(0, 1, 2, 3, 4, 7, 8, 6, 5)),
			array(array(0, 1, 2, 3, 4, 5, 8, 6, 7)),
			array(array(0, 1, 2, 3, 4, 5, 7, 6, 8)),

			// 9 nodes
			array(array(1, 2, 3, 4, 5, 6, 8, 7, 0)),
			array(array(0, 2, 3, 4, 5, 6, 8, 7, 1)),
			array(array(0, 1, 3, 4, 5, 6, 8, 7, 2)),
			array(array(0, 1, 2, 4, 5, 6, 8, 7, 3)),
			array(array(0, 1, 2, 3, 5, 6, 8, 7, 4)),
			array(array(0, 1, 2, 3, 4, 6, 8, 7, 5)),
			array(array(0, 1, 2, 3, 4, 5, 8, 7, 6)),
			array(array(0, 1, 2, 3, 4, 5, 6, 7, 8)),

			// 9 nodes
			array(array(1, 2, 3, 4, 5, 6, 7, 8, 0)),
			array(array(0, 2, 3, 4, 5, 6, 7, 8, 1)),
			array(array(0, 1, 3, 4, 5, 6, 7, 8, 2)),
			array(array(0, 1, 2, 4, 5, 6, 7, 8, 3)),
			array(array(0, 1, 2, 3, 5, 6, 7, 8, 4)),
			array(array(0, 1, 2, 3, 4, 6, 7, 8, 5)),
			array(array(0, 1, 2, 3, 4, 5, 7, 8, 6)),
			array(array(0, 1, 2, 3, 4, 5, 6, 8, 7)),
		);
	}

	/**
	 * Tests  TreeNode::insert
	 *
	 * @param   array  $values  Values array
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::insert
	 * @covers  chdemko\SortedCollection\TreeNode::__construct
	 * @covers  chdemko\SortedCollection\TreeNode::decBalance
	 * @covers  chdemko\SortedCollection\TreeNode::incBalance
	 * @covers  chdemko\SortedCollection\TreeNode::rotateLeft
	 * @covers  chdemko\SortedCollection\TreeNode::rotateRight
	 *
	 * @dataProvider  casesModify
	 *
	 * @since   1.0.0
	 */
	public function testInsert($values)
	{
		$tree = TreeMap::create();

		$array = array();

		foreach ($values as $value)
		{
			$tree[$value] = $value;
			$array[$value] = $value;
		}

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);
		$this->verifyHeight($root->getValue($tree));

		asort($array);
		$this->assertEquals(
			$array,
			$tree->toArray()
		);

		arsort($array);
		$this->assertEquals(
			$array,
			ReversedMap::create($tree)->toArray()
		);
	}

	/**
	 * Tests  TreeNode::insert
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::insert
	 *
	 * @since   1.0.0
	 */
	public function testReplace()
	{
		$tree = TreeMap::create()->initialise(array(0));
		$tree[0] = 1;

		$this->assertEquals(
			array(0 => 1),
			$tree->toArray()
		);
	}

	/**
	 * Tests  TreeNode::remove
	 *
	 * @param   array  $values  Initial values array
	 *
	 * @return  void
	 *
	 * @covers  chdemko\SortedCollection\TreeNode::remove
	 * @covers  chdemko\SortedCollection\TreeNode::pullUpLeftMost
	 * @covers  chdemko\SortedCollection\TreeNode::decBalance
	 * @covers  chdemko\SortedCollection\TreeNode::incBalance
	 * @covers  chdemko\SortedCollection\TreeNode::rotateLeft
	 * @covers  chdemko\SortedCollection\TreeNode::rotateRight
	 *
	 * @dataProvider  casesModify
	 *
	 * @since   1.0.0
	 */
	public function testRemove($values)
	{
		foreach ($values as $remove)
		{
			$tree = TreeMap::create();

			$array = array();

			foreach ($values as $value)
			{
				$tree[$value] = $value;
				$array[$value] = $value;
			}

			unset($tree[$remove]);
			unset($array[$remove]);

			// Set the root property accessible
			$root = (new \ReflectionClass($tree))->getProperty('root');
			$root->setAccessible(true);
			$this->verifyHeight($root->getValue($tree));

			asort($array);
			$this->assertEquals(
				$array,
				$tree->toArray()
			);

			arsort($array);
			$this->assertEquals(
				$array,
				ReversedMap::create($tree)->toArray()
			);
		}
	}
}
