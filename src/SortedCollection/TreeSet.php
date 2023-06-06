<?php

/**
 * chdemko\SortedCollection\TreeSet class
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

/**
 * Tree set
 *
 * @package    SortedCollection
 * @subpackage Set
 *
 * @since 1.0.0
 *
 * @property-read callable   $comparator  The element comparison function
 * @property-read mixed      $first       The first element of the set
 * @property-read mixed      $last        The last element of the set
 * @property-read integer    $count       The number of elements in the set
 */
class TreeSet extends AbstractSet
{
    /**
     * Constructor
     *
     * @param callable $comparator Comparison function
     *
     * @since 1.0.0
     */
    protected function __construct($comparator = null)
    {
        $this->setMap(TreeMap::create($comparator));
    }

    /**
     * Create
     *
     * @param callable $comparator Comparison function
     *
     * @return TreeSet A new TreeSet
     *
     * @since 1.0.0
     */
    public static function create($comparator = null)
    {
        return new static($comparator);
    }

    /**
     * Put values in the set
     *
     * @param \Traversable $traversable Values to put in the set
     *
     * @return TreeSet $this for chaining
     *
     * @since 1.0.0
     */
    public function put($traversable = array())
    {
        foreach ($traversable as $value) {
            $this[$value] = true;
        }

        return $this;
    }

    /**
     * Clear the set
     *
     * @return TreeSet $this for chaining
     *
     * @since 1.0.0
     */
    public function clear()
    {
        $this->getMap()->clear();

        return $this;
    }

    /**
     * Initialise the set
     *
     * @param \Traversable $traversable Values to initialise the set
     *
     * @return TreeSet $this for chaining
     *
     * @since 1.0.0
     */
    public function initialise($traversable = array())
    {
        return $this->clear()->put($traversable);
    }

    /**
     * Clone the set
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        $this->setMap(clone $this->getMap());
    }

    /**
     * Set the value for an element
     *
     * @param mixed $element The element
     * @param mixed $value   The value
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function offsetSet($element, $value)
    {
        $map = $this->getMap();

        if ($value) {
            $map[$element] = true;
        } else {
            unset($map[$element]);
        }
    }

    /**
     * Serialize the object
     *
     * @return array Array of values
     *
     * @since 1.0.0
     */
    public function jsonSerialize()
    {
        $array = array();

        foreach ($this as $value) {
            $array[] = $value;
        }

        return array('TreeSet' => $array);
    }

    /**
     * Unset the existence of an element
     *
     * @param mixed $element The element
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function offsetUnset($element)
    {
        $map = $this->getMap();
        unset($map[$element]);
    }
}
