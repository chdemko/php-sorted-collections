<?php

/**
 * chdemko\SortedCollection\TreeNode class
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2016 Christophe Demko. All rights reserved.
 *
 * @license    http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html The CeCILL B license
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

/**
 * TreeNode
 *
 * @package  SortedCollection
 *
 * @since    1.0.0
 *
 * @property-read  TreeNode  $first        The first node of the tree
 * @property-read  TreeNode  $last         The last node of the tree
 * @property-read  TreeNode  $predecessor  The predecessor node
 * @property-read  TreeNode  $successor    The successor node
 * @property-read  mixed     $key          The key
 * @property-read  integer   $count        The number of elements in the tree
 */
class TreeNode implements \Countable
{
	/**
	 * @var     integer  Information associated to that node.
	 *                   Bits of order 0 and 1 are reserved for the existence of left and right tree.
	 *                   Other bits are for the balance
	 *
	 * @since   1.0.0
	 */
	private $information = 0;

	/**
	 * @var     TreeNode  Left|Predecessor node
	 *
	 * @since   1.0.0
	 */
	private $left;

	/**
	 * @var     TreeNode  Right|Successor node
	 *
	 * @since   1.0.0
	 */
	private $right;

	/**
	 * @var     mixed  Node key
	 *
	 * @since   1.0.0
	 */
	private $key;

	/**
	 * @var     mixed  Node value
	 *
	 * @since   1.0.0
	 */
	public $value;

	/**
	 * Create a node
	 *
	 * @param   mixed  $key    The node key
	 * @param   mixed  $value  The node value
	 *
	 * @return  A new node
	 *
	 * @since   1.0.0
	 */
	public static function create($key, $value)
	{
		return new static($key, $value);
	}

	/**
	 * Constructor
	 *
	 * @param   mixed     $key          The node key
	 * @param   mixed     $value        The node value
	 * @param   TreeNode  $predecessor  The left node
	 * @param   TreeNode  $successor    The right node
	 *
	 * @since   1.0.0
	 */
	protected function __construct($key, $value, $predecessor = null, $successor = null)
	{
		$this->key = $key;
		$this->value = $value;
		$this->left = $predecessor;
		$this->right = $successor;
	}

	/**
	 * Magic get method
	 *
	 * @param   string  $property  The node property
	 *
	 * @return  mixed  The value associated to the property
	 *
	 * @throws  \RuntimeException  If the property is undefined
	 *
	 * @since   1.0.0
	 */
	public function __get($property)
	{
		switch ($property)
		{
		case 'first':
			return $this->first();
		case 'last':
			return $this->last();
		case 'predecessor':
			return $this->predecessor();
		case 'successor':
			return $this->successor();
		case 'key':
			return $this->key;
		case 'count':
			return $this->count();
		default:
			throw new \RuntimeException('Undefined property');
		}
	}

	/**
	 * Get the first node
	 *
	 * @return  the first node
	 *
	 * @since   1.0.0
	 */
	public function first()
	{
		$node = $this;

		while ($node->information & 2)
		{
			$node = $node->left;
		}

		return $node;
	}

	/**
	 * Get the last node
	 *
	 * @return  the last node
	 *
	 * @since   1.0.0
	 */
	public function last()
	{
		$node = $this;

		while ($node->information & 1)
		{
			$node = $node->right;
		}

		return $node;
	}

	/**
	 * Get the predecessor
	 *
	 * @return  the predecessor node
	 *
	 * @since   1.0.0
	 */
	public function predecessor()
	{
		if ($this->information & 2)
		{
			$node = $this->left;

			while ($node->information & 1)
			{
				$node = $node->right;
			}

			return $node;
		}
		else
		{
			return $this->left;
		}
	}

	/**
	 * Get the successor
	 *
	 * @return  the successor node
	 *
	 * @since   1.0.0
	 */
	public function successor()
	{
		if ($this->information & 1)
		{
			$node = $this->right;

			while ($node->information & 2)
			{
				$node = $node->left;
			}

			return $node;
		}
		else
		{
			return $this->right;
		}
	}

	/**
	 * Count the number of key/value pair
	 *
	 * @return  integer
	 *
	 * @since   1.0.0
	 */
	public function count()
	{
		$count = 1;

		if ($this->information & 2)
		{
			$count += $this->left->count;
		}

		if ($this->information & 1)
		{
			$count += $this->right->count;
		}

		return $count;
	}

	/**
	 * Get the node for a key
	 *
	 * @param   mixed     $key         The key
	 * @param   Callable  $comparator  The comparator function
	 * @param   integer   $type        The operation type
	 *                                     -2 for the greatest key lesser than the given key
	 *                                     -1 for the greatest key lesser than or equal to the given key
	 *                                      0 for the given key
	 *                                     +1 for the lowest key greater than or equal to the given key
	 *                                     +2 for the lowest key greater than the given key
	 *
	 * @return  mixed  The node or null if not found
	 *
	 * @since   1.0.0
	 */
	public function find($key, $comparator, $type = 0)
	{
		$node = $this;

		while (true)
		{
			$cmp = call_user_func($comparator, $key, $node->key);

			if ($cmp < 0 && $node->information & 2)
			{
				$node = $node->left;
			}
			elseif ($cmp > 0 && $node->information & 1)
			{
				$node = $node->right;
			}
			else
			{
				break;
			}
		}

		if ($cmp < 0)
		{
			if ($type < 0)
			{
				return $node->left;
			}
			elseif ($type > 0)
			{
				return $node;
			}
			else
			{
				return null;
			}
		}
		elseif ($cmp > 0)
		{
			if ($type < 0)
			{
				return $node;
			}
			elseif ($type > 0)
			{
				return $node->right;
			}
			else
			{
				return null;
			}
		}
		else
		{
			if ($type < -1)
			{
				return $node->predecessor;
			}
			elseif ($type > 1)
			{
				return $node->successor;
			}
			else
			{
				return $node;
			}
		}
	}

	/**
	 * Rotate the node to the left
	 *
	 * @return  TreeNode  The rotated node
	 *
	 * @since   1.0.0
	 */
	private function _rotateLeft()
	{
		$right = $this->right;

		if ($right->information & 2)
		{
			$this->right = $right->left;
			$right->left = $this;
		}
		else
		{
			$right->information |= 2;
			$this->information &= ~ 1;
		}

		$this->information -= 4;

		if ($right->information >= 4)
		{
			$this->information -= $right->information & ~3;
		}

		$right->information -= 4;

		if ($this->information < 0)
		{
			$right->information += $this->information & ~3;
		}

		return $right;
	}

	/**
	 * Rotate the node to the right
	 *
	 * @return  TreeNode  The rotated node
	 *
	 * @since   1.0.0
	 */
	private function _rotateRight()
	{
		$left = $this->left;

		if ($left->information & 1)
		{
			$this->left = $left->right;
			$left->right = $this;
		}
		else
		{
			$this->information &= ~ 2;
			$left->information |= 1;
		}

		$this->information += 4;

		if ($left->information < 0)
		{
			$this->information -= $left->information & ~3;
		}

		$left->information += 4;

		if ($this->information >= 4)
		{
			$left->information += $this->information & ~3;
		}

		return $left;
	}

	/**
	 * Increment the balance of the node
	 *
	 * @return  TreeNode  $this or a rotated version of $this
	 *
	 * @since   1.0.0
	 */
	private function _incBalance()
	{
		$this->information += 4;

		if ($this->information >= 8)
		{
			if ($this->right->information < 0)
			{
				$this->right = $this->right->_rotateRight();
			}

			return $this->_rotateLeft();
		}

		return $this;
	}

	/**
	 * Decrement the balance of the node
	 *
	 * @return  TreeNode  $this or a rotated version of $this
	 *
	 * @since   1.0.0
	 */
	private function _decBalance()
	{
		$this->information -= 4;

		if ($this->information < - 4)
		{
			if ($this->left->information >= 4)
			{
				$this->left = $this->left->_rotateLeft();
			}

			return $this->_rotateRight();
		}

		return $this;
	}

	/**
	 * Insert a key/value pair
	 *
	 * @param   mixed     $key         The key
	 * @param   mixed     $value       The value
	 * @param   Callable  $comparator  The comparator function
	 *
	 * @return  TreeNode  The new root
	 *
	 * @since   1.0.0
	 */
	public function insert($key, $value, $comparator)
	{
		$node = $this;
		$cmp = call_user_func($comparator, $key, $this->key);

		if ($cmp < 0)
		{
			if ($this->information & 2)
			{
				$leftBalance = $this->left->information & ~3;
				$this->left = $this->left->insert($key, $value, $comparator);

				if (($this->left->information & ~3) && ($this->left->information & ~3) != $leftBalance)
				{
					$node = $this->_decBalance();
				}
			}
			else
			{
				$this->left = new static($key, $value, $this->left, $this);
				$this->information|= 2;
				$node = $this->_decBalance();
			}
		}
		elseif ($cmp > 0)
		{
			if ($this->information & 1)
			{
				$rightBalance = $this->right->information & ~3;
				$this->right = $this->right->insert($key, $value, $comparator);

				if (($this->right->information & ~3) && ($this->right->information & ~3) != $rightBalance)
				{
					$node = $this->_incBalance();
				}
			}
			else
			{
				$this->right = new static($key, $value, $this, $this->right);
				$this->information|= 1;
				$node = $this->_incBalance();
			}
		}
		else
		{
			$this->value = $value;
		}

		return $node;
	}

	/**
	 * Pull up the left most node of a node
	 *
	 * @return  TreeNode  The new root
	 *
	 * @since   1.0.0
	 */
	private function _pullUpLeftMost()
	{
		if ($this->information & 2)
		{
			$leftBalance = $this->left->information & ~3;
			$this->left = $this->left->_pullUpLeftMost();

			if (!($this->information & 2) || $leftBalance != 0 && ($this->left->information & ~3) == 0)
			{
				return $this->_incBalance();
			}
			else
			{
				return $this;
			}
		}
		else
		{
			$this->left->key = $this->key;
			$this->left->value = $this->value;

			if ($this->information & 1)
			{
				$this->right->left = $this->left;

				return $this->right;
			}
			else
			{
				if ($this->left->right == $this)
				{
					$this->left->information &= ~ 1;

					return $this->right;
				}
				else
				{
					$this->right->information &= ~ 2;

					return $this->left;
				}
			}
		}
	}

	/**
	 * Remove a key
	 *
	 * @param   mixed     $key         The key
	 * @param   Callable  $comparator  The comparator function
	 *
	 * @return  TreeNode  The new root
	 *
	 * @since   1.0.0
	 */
	public function remove($key, $comparator)
	{
		$cmp = call_user_func($comparator, $key, $this->key);

		if ($cmp < 0)
		{
			if ($this->information & 2)
			{
				$leftBalance = $this->left->information & ~3;
				$this->left = $this->left->remove($key, $comparator);

				if (!($this->information & 2) || $leftBalance != 0 && ($this->left->information & ~3) == 0)
				{
					return $this->_incBalance();
				}
			}
		}
		elseif ($cmp > 0)
		{
			if ($this->information & 1)
			{
				$rightBalance = $this->right->information & ~3;
				$this->right = $this->right->remove($key, $comparator);

				if (!($this->information & 1) || $rightBalance != 0 && ($this->right->information & ~3) == 0)
				{
					return $this->_decBalance();
				}
			}
		}
		else
		{
			if ($this->information & 1)
			{
				$rightBalance = $this->right->information & ~3;
				$this->right = $this->right->_pullUpLeftMost();

				if (!($this->information & 1) || $rightBalance != 0 && ($this->right->information & ~3) == 0)
				{
					return $this->_decBalance();
				}
			}
			else
			{
				$left = $this->left;
				$right = $this->right;

				if ($this->information & 2)
				{
					$left->right = $right;

					return $left;
				}
				else
				{
					if ($left && $left->right == $this)
					{
						$left->information &= ~ 1;

						return $right;
					}
					elseif ($right && $right->left == $this)
					{
						$right->information &= ~ 2;

						return $left;
					}
					else
					{
						return null;
					}
				}
			}
		}

		return $this;
	}
}
