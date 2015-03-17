<?php

/**
 * chdemko\SortedCollection\TreeNodeTest class
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
 * TreeNode class test
 *
 * @package  SortedCollection
 *
 * @since    0,0,1
 */
class TreeNodeTest extends \PHPUnit_Framework_TestCase
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
	 * Data provider for test_create
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_create()
	{
		return [
			[[], null, '()'],
			[
				[],
				function ($key1, $key2)
				{
					return $key1 - $key2;
				},
				'()'
			],
			[[0, 1, 2, 3, 4, 5, 6, 7, 8, 9], null, '(3,3,1,(1,1,0,(0,0,0,,),(2,2,0,,)),(7,7,0,(5,5,0,(4,4,0,,),(6,6,0,,)),(8,8,1,,(9,9,0,,))))'],
		];
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
	 * @dataProvider  cases_create
	 *
	 * @since   1.0.0
	 */
	public function test_create($values, $comparator, $string)
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
	public function test_first()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

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
	public function test_last()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

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
	public function test___get_unexisting()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->setExpectedException('RuntimeException');
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
	public function test__get()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

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
	public function test_count()
	{
		$tree = TreeMap::create()->initialise([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

		// Set the root property accessible
		$root = (new \ReflectionClass($tree))->getProperty('root');
		$root->setAccessible(true);

		$this->assertEquals(
			10,
			$root->getValue($tree)->count
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
		return [
			[[1, 3], -2, 0, null],
			[[1, 3], -1, 0, null],
			[[1, 3],  0, 0, null],
			[[1, 3],  1, 0, 1],
			[[1, 3],  2, 0, 1],
			[[1, 3], -2, 1, null],
			[[1, 3], -1, 1, 1],
			[[1, 3],  0, 1, 1],
			[[1, 3],  1, 1, 1],
			[[1, 3],  2, 1, 3],
			[[1, 3], -2, 2, 1],
			[[1, 3], -1, 2, 1],
			[[1, 3],  0, 2, null],
			[[1, 3],  1, 2, 3],
			[[1, 3],  2, 2, 3],
			[[1, 3], -2, 3, 1],
			[[1, 3], -1, 3, 3],
			[[1, 3],  0, 3, 3],
			[[1, 3],  1, 3, 3],
			[[1, 3],  2, 3, null],
			[[1, 3], -2, 4, 3],
			[[1, 3], -1, 4, 3],
			[[1, 3],  0, 4, null],
			[[1, 3],  1, 4, null],
			[[1, 3],  2, 4, null],

			[[3, 1], -2, 0, null],
			[[3, 1], -1, 0, null],
			[[3, 1],  0, 0, null],
			[[3, 1],  1, 0, 1],
			[[3, 1],  2, 0, 1],
			[[3, 1], -2, 1, null],
			[[3, 1], -1, 1, 1],
			[[3, 1],  0, 1, 1],
			[[3, 1],  1, 1, 1],
			[[3, 1],  2, 1, 3],
			[[3, 1], -2, 2, 1],
			[[3, 1], -1, 2, 1],
			[[3, 1],  0, 2, null],
			[[3, 1],  1, 2, 3],
			[[3, 1],  2, 2, 3],
			[[3, 1], -2, 3, 1],
			[[3, 1], -1, 3, 3],
			[[3, 1],  0, 3, 3],
			[[3, 1],  1, 3, 3],
			[[3, 1],  2, 3, null],
			[[3, 1], -2, 4, 3],
			[[3, 1], -1, 4, 3],
			[[3, 1],  0, 4, null],
			[[3, 1],  1, 4, null],
			[[3, 1],  2, 4, null],
		];
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
	 * @dataProvider  cases_find
	 *
	 * @since   1.0.0
	 */
	public function test_find($values, $type, $key, $node)
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
	 * Data provider for test_insert and test_remove
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public function cases_modify()
	{
		return [
			// 1 node
			[[1]],

			// 2 nodes
			[[1, 1]],
			[[1, 0]],

			// 3 nodes
			[[0, 1, 2]],
			[[0, 2, 1]],
			[[1, 2, 0]],
			[[1, 0, 2]],
			[[2, 0, 1]],
			[[2, 1, 0]],

			// 4 nodes
			[[1, 2, 3, 0]],
			[[0, 2, 3, 1]],
			[[0, 1, 3, 2]],
			[[0, 1, 2, 3]],

			// 5 nodes
			[[2, 3, 4, 1, 0]],
			[[1, 3, 4, 2, 0]],
			[[1, 2, 4, 3, 0]],
			[[1, 2, 3, 4, 0]],

			// 5 nodes
			[[2, 3, 4, 0, 1]],
			[[0, 3, 4, 2, 1]],
			[[0, 2, 4, 3, 1]],
			[[0, 2, 3, 4, 1]],

			// 5 nodes
			[[1, 3, 4, 0, 2]],
			[[0, 3, 4, 1, 2]],
			[[0, 1, 4, 3, 2]],
			[[0, 1, 3, 4, 2]],

			// 5 nodes
			[[1, 2, 4, 0, 3]],
			[[0, 2, 4, 1, 3]],
			[[0, 1, 4, 2, 3]],
			[[0, 1, 2, 4, 3]],

			// 5 nodes
			[[1, 2, 3, 0, 4]],
			[[0, 2, 3, 1, 4]],
			[[0, 1, 3, 2, 4]],
			[[0, 1, 2, 3, 4]],

			// 6 nodes
			[[3, 4, 5, 2, 1, 0]],
			[[2, 3, 5, 4, 1, 0]],
			[[2, 3, 4, 5, 1, 0]],
			[[1, 3, 5, 4, 2, 0]],
			[[1, 3, 4, 5, 2, 0]],
			[[1, 2, 5, 4, 3, 0]],

			// 6 nodes
			[[3, 4, 5, 2, 0, 1]],
			[[2, 3, 5, 4, 0, 1]],
			[[2, 3, 4, 5, 0, 1]],
			[[0, 3, 5, 4, 2, 1]],
			[[0, 3, 4, 5, 2, 1]],
			[[0, 2, 5, 4, 3, 1]],

			// 6 nodes
			[[3, 4, 5, 1, 0, 2]],
			[[1, 3, 5, 4, 0, 2]],
			[[1, 3, 4, 5, 0, 2]],
			[[0, 3, 5, 4, 1, 2]],
			[[0, 3, 4, 5, 1, 2]],
			[[0, 1, 5, 4, 3, 2]],

			// 6 nodes
			[[2, 4, 5, 1, 0, 3]],
			[[1, 2, 5, 4, 0, 3]],
			[[1, 2, 4, 5, 0, 3]],
			[[0, 2, 5, 4, 1, 3]],
			[[0, 2, 4, 5, 1, 3]],
			[[0, 1, 5, 4, 2, 3]],

			// 6 nodes
			[[2, 3, 5, 1, 0, 4]],
			[[1, 2, 5, 3, 0, 4]],
			[[1, 2, 3, 5, 0, 4]],
			[[0, 2, 5, 3, 1, 4]],
			[[0, 2, 3, 5, 1, 4]],
			[[0, 1, 5, 3, 2, 4]],

			// 6 nodes
			[[2, 3, 4, 1, 0, 5]],
			[[1, 2, 4, 3, 0, 5]],
			[[1, 2, 3, 4, 0, 5]],
			[[0, 2, 4, 3, 1, 5]],
			[[0, 2, 3, 4, 1, 5]],
			[[0, 1, 4, 3, 2, 5]],

			// 7 nodes
			[[4, 5, 6, 3, 2, 1, 0]],
			[[3, 4, 6, 5, 2, 1, 0]],
			[[3, 4, 5, 6, 2, 1, 0]],
			[[4, 5, 6, 3, 1, 2, 0]],

			// 7 nodes
			[[4, 5, 6, 3, 2, 0, 1]],
			[[3, 4, 6, 5, 2, 0, 1]],
			[[3, 4, 5, 6, 2, 0, 1]],
			[[4, 5, 6, 3, 0, 2, 1]],

			// 7 nodes
			[[4, 5, 6, 3, 1, 0, 2]],
			[[3, 4, 6, 5, 1, 0, 2]],
			[[3, 4, 5, 6, 1, 0, 2]],
			[[4, 5, 6, 3, 0, 1, 2]],

			// 7 nodes
			[[4, 5, 6, 2, 1, 0, 3]],
			[[2, 4, 6, 5, 1, 0, 3]],
			[[2, 4, 5, 6, 1, 0, 3]],
			[[4, 5, 6, 2, 0, 1, 3]],

			// 7 nodes
			[[3, 5, 6, 2, 1, 0, 4]],
			[[2, 3, 6, 5, 1, 0, 4]],
			[[2, 3, 5, 6, 1, 0, 4]],
			[[3, 5, 6, 2, 0, 1, 4]],

			// 7 nodes
			[[3, 4, 6, 2, 1, 0, 5]],
			[[2, 3, 6, 4, 1, 0, 5]],
			[[2, 3, 4, 6, 1, 0, 5]],
			[[3, 4, 6, 2, 0, 1, 5]],

			// 7 nodes
			[[3, 4, 5, 2, 1, 0, 6]],
			[[2, 3, 5, 4, 1, 0, 6]],
			[[2, 3, 4, 5, 1, 0, 6]],
			[[3, 4, 5, 2, 0, 1, 6]],

			// 8 nodes
			[[1, 2, 3, 4, 5, 6, 7, 0]],
			[[0, 2, 3, 4, 5, 6, 7, 1]],
			[[0, 1, 3, 4, 5, 6, 7, 2]],
			[[0, 1, 2, 4, 5, 6, 7, 3]],
			[[0, 1, 2, 3, 5, 6, 7, 4]],
			[[0, 1, 2, 3, 4, 6, 7, 5]],
			[[0, 1, 2, 3, 4, 5, 7, 6]],
			[[0, 1, 2, 3, 4, 5, 6, 7]],

			// 9 nodes
			[[2, 3, 4, 5, 6, 7, 8, 0, 1]],
			[[1, 3, 4, 5, 6, 7, 8, 0, 2]],
			[[1, 2, 4, 5, 6, 7, 8, 0, 3]],
			[[1, 2, 3, 5, 6, 7, 8, 0, 4]],
			[[1, 2, 3, 4, 6, 7, 8, 0, 5]],
			[[1, 2, 3, 4, 5, 7, 8, 0, 6]],
			[[1, 2, 3, 4, 5, 6, 8, 0, 7]],
			[[1, 2, 3, 4, 5, 6, 7, 0, 8]],

			// 9 nodes
			[[2, 3, 4, 5, 6, 7, 8, 1, 0]],
			[[0, 3, 4, 5, 6, 7, 8, 1, 2]],
			[[0, 2, 4, 5, 6, 7, 8, 1, 3]],
			[[0, 2, 3, 5, 6, 7, 8, 1, 4]],
			[[0, 2, 3, 4, 6, 7, 8, 1, 5]],
			[[0, 2, 3, 4, 5, 7, 8, 1, 6]],
			[[0, 2, 3, 4, 5, 6, 8, 1, 7]],
			[[0, 2, 3, 4, 5, 6, 7, 1, 8]],

			// 9 nodes
			[[1, 3, 4, 5, 6, 7, 8, 2, 0]],
			[[0, 3, 4, 5, 6, 7, 8, 2, 1]],
			[[0, 1, 4, 5, 6, 7, 8, 2, 3]],
			[[0, 1, 3, 5, 6, 7, 8, 2, 4]],
			[[0, 1, 3, 4, 6, 7, 8, 2, 5]],
			[[0, 1, 3, 4, 5, 7, 8, 2, 6]],
			[[0, 1, 3, 4, 5, 6, 8, 2, 7]],
			[[0, 1, 3, 4, 5, 6, 7, 2, 8]],

			// 9 nodes
			[[1, 2, 4, 5, 6, 7, 8, 3, 0]],
			[[0, 2, 4, 5, 6, 7, 8, 3, 1]],
			[[0, 1, 4, 5, 6, 7, 8, 3, 2]],
			[[0, 1, 2, 5, 6, 7, 8, 3, 4]],
			[[0, 1, 2, 4, 6, 7, 8, 3, 5]],
			[[0, 1, 2, 4, 5, 7, 8, 3, 6]],
			[[0, 1, 2, 4, 5, 6, 8, 3, 7]],
			[[0, 1, 2, 4, 5, 6, 7, 3, 8]],

			// 9 nodes
			[[1, 2, 3, 5, 6, 7, 8, 4, 0]],
			[[0, 2, 3, 5, 6, 7, 8, 4, 1]],
			[[0, 1, 3, 5, 6, 7, 8, 4, 2]],
			[[0, 1, 2, 5, 6, 7, 8, 4, 3]],
			[[0, 1, 2, 3, 6, 7, 8, 4, 5]],
			[[0, 1, 2, 3, 5, 7, 8, 4, 6]],
			[[0, 1, 2, 3, 5, 6, 8, 4, 7]],
			[[0, 1, 2, 3, 5, 6, 7, 4, 8]],

			// 9 nodes
			[[1, 2, 3, 4, 6, 7, 8, 5, 0]],
			[[0, 2, 3, 4, 6, 7, 8, 5, 1]],
			[[0, 1, 3, 4, 6, 7, 8, 5, 2]],
			[[0, 1, 2, 4, 6, 7, 8, 5, 3]],
			[[0, 1, 2, 3, 6, 7, 8, 5, 4]],
			[[0, 1, 2, 3, 4, 7, 8, 5, 6]],
			[[0, 1, 2, 3, 4, 6, 8, 5, 7]],
			[[0, 1, 2, 3, 4, 6, 7, 5, 8]],

			// 9 nodes
			[[1, 2, 3, 4, 5, 7, 8, 6, 0]],
			[[0, 2, 3, 4, 5, 7, 8, 6, 1]],
			[[0, 1, 3, 4, 5, 7, 8, 6, 2]],
			[[0, 1, 2, 4, 5, 7, 8, 6, 3]],
			[[0, 1, 2, 3, 5, 7, 8, 6, 4]],
			[[0, 1, 2, 3, 4, 7, 8, 6, 5]],
			[[0, 1, 2, 3, 4, 5, 8, 6, 7]],
			[[0, 1, 2, 3, 4, 5, 7, 6, 8]],

			// 9 nodes
			[[1, 2, 3, 4, 5, 6, 8, 7, 0]],
			[[0, 2, 3, 4, 5, 6, 8, 7, 1]],
			[[0, 1, 3, 4, 5, 6, 8, 7, 2]],
			[[0, 1, 2, 4, 5, 6, 8, 7, 3]],
			[[0, 1, 2, 3, 5, 6, 8, 7, 4]],
			[[0, 1, 2, 3, 4, 6, 8, 7, 5]],
			[[0, 1, 2, 3, 4, 5, 8, 7, 6]],
			[[0, 1, 2, 3, 4, 5, 6, 7, 8]],

			// 9 nodes
			[[1, 2, 3, 4, 5, 6, 7, 8, 0]],
			[[0, 2, 3, 4, 5, 6, 7, 8, 1]],
			[[0, 1, 3, 4, 5, 6, 7, 8, 2]],
			[[0, 1, 2, 4, 5, 6, 7, 8, 3]],
			[[0, 1, 2, 3, 5, 6, 7, 8, 4]],
			[[0, 1, 2, 3, 4, 6, 7, 8, 5]],
			[[0, 1, 2, 3, 4, 5, 7, 8, 6]],
			[[0, 1, 2, 3, 4, 5, 6, 8, 7]],
		];
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
	 * @covers  chdemko\SortedCollection\TreeNode::_decBalance
	 * @covers  chdemko\SortedCollection\TreeNode::_incBalance
	 * @covers  chdemko\SortedCollection\TreeNode::_rotateLeft
	 * @covers  chdemko\SortedCollection\TreeNode::_rotateRight
	 *
	 * @dataProvider  cases_modify
	 *
	 * @since   1.0.0
	 */
	public function test_insert($values)
	{
		$tree = TreeMap::create();

		$array = [];

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
	public function test_replace()
	{
		$tree = TreeMap::create()->initialise([0]);
		$tree[0] = 1;

		$this->assertEquals(
			[0 => 1],
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
	 * @covers  chdemko\SortedCollection\TreeNode::_pullUpLeftMost
	 * @covers  chdemko\SortedCollection\TreeNode::_decBalance
	 * @covers  chdemko\SortedCollection\TreeNode::_incBalance
	 * @covers  chdemko\SortedCollection\TreeNode::_rotateLeft
	 * @covers  chdemko\SortedCollection\TreeNode::_rotateRight
	 *
	 * @dataProvider  cases_modify
	 *
	 * @since   1.0.0
	 */
	public function test_remove($values)
	{
		foreach ($values as $remove)
		{
			$tree = TreeMap::create();

			$array = [];

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
