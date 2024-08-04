<?php

/**
 * chdemko\SortedCollection\Iterator class
 *
 * @author    Christophe Demko <chdemko@gmail.com>
 * @copyright Copyright (C) 2012-2024 Christophe Demko. All rights reserved.
 *
 * @license BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollection namespace
namespace chdemko\SortedCollection;

/**
 * Iterator
 *
 * @package SortedCollection
 *
 * @since 1.0.0
 */
class Iterator implements \Iterator
{
    /**
     * Iterate on pairs
     *
     * @since 1.0.0
     */
    private const PAIRS = 0;

    /**
     * Iterate on keys
     *
     * @since 1.0.0
     */
    private const KEYS = 1;

    /**
     * Iterate on values
     *
     * @since 1.0.0
     */
    private const VALUES = 2;

    /**
     * @var integer  Type: self::PAIRS, self::KEYS or self::VALUES
     *
     * @since 1.0.0
     */
    private $type;

    /**
     * @var integer  Index
     *
     * @since 1.0.0
     */
    private $index;

    /**
     * @var SortedMap  Map
     *
     * @since 1.0.0
     */
    private $map;

    /**
     * Constructor
     *
     * @param SortedMap $map  Sorted map
     * @param integer   $type Iterator type
     *
     * @since 1.0.0
     */
    protected function __construct(SortedMap $map, $type)
    {
        $this->map = $map;
        $this->type = $type;
        $this->rewind();
    }

    /**
     * Create a new iterator on pairs
     *
     * @param SortedMap $map Sorted map
     *
     * @return Iterator A new iterator on pairs
     *
     * @since 1.0.0
     */
    public static function create(SortedMap $map)
    {
        return new static($map, self::PAIRS);
    }

    /**
     * Create a new iterator on keys
     *
     * @param SortedMap $map Sorted map
     *
     * @return Iterator A new iterator on keys
     *
     * @since 1.0.0
     */
    public static function keys(SortedMap $map)
    {
        return new static($map, self::KEYS);
    }

    /**
     * Create a new iterator on values
     *
     * @param SortedMap $map Sorted map
     *
     * @return Iterator A new iterator on values
     *
     * @since 1.0.0
     */
    public static function values(SortedMap $map)
    {
        return new static($map, self::VALUES);
    }

    /**
     * @var TreeNode  The current node
     *
     * @since 1.0.0
     */
    protected $current;

    /**
     * Rewind the Iterator to the first element
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function rewind(): void
    {
        $this->index = 0;

        try {
            $this->current = $this->map->first();
        } catch (\OutOfBoundsException $e) {
            $this->current = null;
        }
    }

    /**
     * Return the current key
     *
     * @return mixed The current key
     *
     * @since 1.0.0
     */
    public function key(): mixed
    {
        if ($this->type == self::PAIRS) {
            return $this->current->key;
        } else {
            return $this->index;
        }
    }

    /**
     * Return the current value
     *
     * @return mixed The current value
     *
     * @since 1.0.0
     */
    public function current(): mixed
    {
        if ($this->type == self::KEYS) {
            return $this->current->key;
        } else {
            return $this->current->value;
        }
    }

    /**
     * Move forward to the next element
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function next(): void
    {
        try {
            $this->current = $this->map->successor($this->current);
        } catch (\OutOfBoundsException $e) {
            $this->current = null;
        }

        $this->index++;
    }

    /**
     * Checks if current position is valid
     *
     * @return boolean
     *
     * @since 1.0.0
     */
    public function valid(): bool
    {
        return (bool) $this->current;
    }
}
