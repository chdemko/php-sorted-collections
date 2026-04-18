<?php

/**
 * chdemko\SortedCollection\ReversedMap class
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
 * Reversed map
 *
 * @package    SortedCollection
 * @subpackage Map
 *
 * @since 1.0.0
 *
 * @property-read callable   $comparator  The key comparison function
 * @property-read TreeNode   $first       The first element of the map
 * @property-read mixed      $firstKey    The first key of the map
 * @property-read mixed      $firstValue  The first value of the map
 * @property-read TreeNode   $last        The last element of the map
 * @property-read mixed      $lastKey     The last key of the map
 * @property-read mixed      $lastValue   The last value of the map
 * @property-read Iterator   $keys        The keys iterator
 * @property-read Iterator   $values      The values iterator
 * @property-read integer    $count       The number of elements in the map
 * @property-read SortedMap  $map         The underlying map
 */
class ReversedMap extends AbstractMap
{
    /**
     * @var SortedMap  Internal map
     *
     * @since 1.0.0
     */
    private $mapInternal;

    /**
     * @var callable  Comparator function
     *
     * @param mixed $key1 First key
     * @param mixed $key2 Second key
     *
     * @return integer negative if $key1 is lesser than $key2,
     *                 0 if $key1 is equal to $key2,
     *                 positive if $key1 is greater than $key2
     *
     * @since 1.0.0
     */
    private $comparatorInternal;

    /**
     * Constructor
     *
     * @param SortedMap $map Internal map
     *
     * @since 1.0.0
     */
    protected function __construct(SortedMap $map)
    {
        $this->mapInternal = $map;
        $this->comparatorInternal = function ($key1, $key2) {
            return - call_user_func($this->mapInternal->comparator, $key1, $key2);
        };
    }

    /**
     * Create
     *
     * @param SortedMap $map Internal map
     *
     * @return ReversedMap A new reversed map
     *
     * @since 1.0.0
     */
    public static function create(SortedMap $map)
    {
        return new static($map);
    }

    /**
     * Magic get method
     *
     * @param string $property The property
     *
     * @return mixed The value associated to the property
     *
     * @since 1.0.0
     */
    public function __get($property)
    {
        switch ($property) {
            case 'map':
                return $this->mapInternal;
            default:
                return parent::__get($property);
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
        return $this->comparatorInternal;
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
        return $this->mapInternal->last();
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
        return $this->mapInternal->first();
    }

    /**
     * Get the predecessor element
     *
     * @param TreeNode $element A tree node member of the underlying TreeMap
     *
     * @return mixed The predecessor element
     *
     * @throws OutOfBoundsException If there is no predecessor
     *
     * @since 1.0.0
     */
    public function predecessor($element)
    {
        return $this->mapInternal->successor($element);
    }

    /**
     * Get the successor element
     *
     * @param TreeNode $element A tree node member of the underlying TreeMap
     *
     * @return mixed The successor element
     *
     * @throws OutOfBoundsException If there is no successor
     */
    public function successor($element)
    {
        return $this->mapInternal->predecessor($element);
    }

    /**
     * Returns the element whose key is the greatest key lesser than the given key
     *
     * @param mixed $key The searched key
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no lower element
     *
     * @since 1.0.0
     */
    public function lower($key)
    {
        return $this->mapInternal->higher($key);
    }

    /**
     * Returns the element whose key is the greatest key lesser than or equal to the given key
     *
     * @param mixed $key The searched key
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no floor element
     *
     * @since 1.0.0
     */
    public function floor($key)
    {
        return $this->mapInternal->ceiling($key);
    }

    /**
     * Returns the element whose key is equal to the given key
     *
     * @param mixed $key The searched key
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no such element
     *
     * @since 1.0.0
     */
    public function find($key)
    {
        return $this->mapInternal->find($key);
    }

    /**
     * Returns the element whose key is the lowest key greater than or equal to the given key
     *
     * @param mixed $key The searched key
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no ceiling element
     *
     * @since 1.0.0
     */
    public function ceiling($key)
    {
        return $this->mapInternal->floor($key);
    }

    /**
     * Returns the element whose key is the lowest key greater than to the given key
     *
     * @param mixed $key The searched key
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException If there is no higher element
     *
     * @since 1.0.0
     */
    public function higher($key)
    {
        return $this->mapInternal->lower($key);
    }

    /**
     * Serialize the object
     *
     * @return array Array of values
     *
     * @since 1.0.0
     */
    public function jsonSerialize(): array
    {
        return array('ReversedMap' => $this->mapInternal->jsonSerialize());
    }

    /**
     * Count the number of key/value pairs
     *
     * @return integer
     *
     * @since 1.0.0
     */
    public function count(): int
    {
        return $this->mapInternal->count();
    }
}
