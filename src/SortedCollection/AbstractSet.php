<?php

/**
 * chdemko\SortedCollection\AbstractSet class
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
 * Abstract set
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
abstract class AbstractSet implements SortedSet
{
    /**
     * @var SortedMap  Underlying map
     *
     * @since 1.0.0
     */
    private $map;

    /**
     * Get the map
     *
     * @return SortedMap The underlying map
     *
     * @since 1.0.0
     */
    protected function getMap()
    {
        return $this->map;
    }

    /**
     * Set the map
     *
     * @param SortedMap $map The underlying map
     *
     * @return AbstractSet $this for chaining
     *
     * @since 1.0.0
     */
    protected function setMap(SortedMap $map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Magic get method
     *
     * @param string $property The property
     *
     * @throws RuntimeException If the property does not exist
     *
     * @return mixed The value associated to the property
     *
     * @since 1.0.0
     */
    public function __get($property)
    {
        switch ($property) {
            case 'comparator':
                return $this->comparator();
            case 'first':
                return $this->first();
            case 'last':
                return $this->last();
            case 'count':
                return $this->count();
            default:
                throw new \RuntimeException('Undefined property');
        }
    }

    /**
     * Get the comparator
     *
     * @return callable The comparator
     *
     * @since 1.0.0
     */
    public function comparator()
    {
        return $this->map->comparator();
    }

    /**
     * Get the first element
     *
     * @return mixed The first element
     *
     * @throws OutOfBoundsException If there is no element
     *
     * @since 1.0.0
     */
    public function first()
    {
        return $this->map->firstKey();
    }

    /**
     * Get the last element
     *
     * @return mixed The last element
     *
     * @throws OutOfBoundsException If there is no element
     *
     * @since 1.0.0
     */
    public function last()
    {
        return $this->map->lastKey();
    }

    /**
     * Returns the greatest element lesser than the given element
     *
     * @param mixed $element The searched element
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no lower element
     *
     * @since 1.0.0
     */
    public function lower($element)
    {
        return $this->map->lowerKey($element);
    }

    /**
     * Returns the greatest element lesser than or equal to the given element
     *
     * @param mixed $element The searched element
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no floor element
     *
     * @since 1.0.0
     */
    public function floor($element)
    {
        return $this->map->floorKey($element);
    }

    /**
     * Returns the element equal to the given element
     *
     * @param mixed $element The searched element
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no such element
     *
     * @since 1.0.0
     */
    public function find($element)
    {
        return $this->map->findKey($element);
    }

    /**
     * Returns the lowest element greater than or equal to the given element
     *
     * @param mixed $element The searched element
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no ceiling element
     *
     * @since 1.0.0
     */
    public function ceiling($element)
    {
        return $this->map->ceilingKey($element);
    }

    /**
     * Returns the lowest element greater than to the given element
     *
     * @param mixed $element The searched element
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no higher element
     *
     * @since 1.0.0
     */
    public function higher($element)
    {
        return $this->map->higherKey($element);
    }

    /**
     * Convert the object to a string
     *
     * @return string String representation of the object
     *
     * @since 1.0.0
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * Convert the object to an array
     *
     * @return array Array representation of the object
     *
     * @since 1.0.0
     */
    public function toArray()
    {
        $array = array();

        foreach ($this as $value) {
            $array[] = $value;
        }

        return $array;
    }

    /**
     * Create an iterator
     *
     * @return Iterator A new iterator
     *
     * @since 1.0.0
     */
    public function getIterator()
    {
        return Iterator::keys($this->map);
    }

    /**
     * Get the value for an element
     *
     * @param mixed $element The element
     *
     * @return mixed The found value
     *
     * @since 1.0.0
     */
    public function offsetGet($element)
    {
        try {
            return (bool) $this->map->find($element);
        } catch (\OutOfBoundsException $e) {
            return false;
        }
    }

    /**
     * Test the existence of an element
     *
     * @param mixed $element The element
     *
     * @return boolean TRUE if the element exists, false otherwise
     *
     * @since 1.0.0
     */
    public function offsetExists($element)
    {
        return $this->offsetGet($element);
    }

    /**
     * Set the value for an element
     *
     * @param mixed $element The element
     * @param mixed $value   The value
     *
     * @return void
     *
     * @throws RuntimeOperation The operation is not supported by this class
     *
     * @since 1.0.0
     */
    public function offsetSet($element, $value)
    {
        throw new \RuntimeException('Unsupported operation');
    }

    /**
     * Unset the existence of an element
     *
     * @param mixed $element The element
     *
     * @return void
     *
     * @throws RuntimeOperation The operation is not supported by this class
     *
     * @since 1.0.0
     */
    public function offsetUnset($element)
    {
        throw new \RuntimeException('Unsupported operation');
    }

    /**
     * Count the number of elements
     *
     * @return integer
     *
     * @since 1.0.0
     */
    public function count()
    {
        return count($this->map);
    }
}
