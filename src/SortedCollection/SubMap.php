<?php

/**
 * chdemko\SortedCollection\SubMap class
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
 * Sub map
 *
 * @package    SortedCollection
 * @subpackage Map
 *
 * @since 1.0.0
 *
 * @property-read callable   $comparator     The key comparison function
 * @property-read TreeNode   $first          The first element of the map
 * @property-read mixed      $firstKey       The first key of the map
 * @property-read mixed      $firstValue     The first value of the map
 * @property-read TreeNode   $last           The last element of the map
 * @property-read mixed      $lastKey        The last key of the map
 * @property-read mixed      $lastValue      The last value of the map
 * @property-read Iterator   $keys           The keys iterator
 * @property-read Iterator   $values         The values iterator
 * @property-read integer    $count          The number of elements in the map
 * @property      mixed      $fromKey        The from key
 * @property      boolean    $fromInclusive  The from inclusive flag
 * @property      mixed      $toKey          The to key
 * @property      boolean    $toInclusive    The to inclusive flag
 * @property-read SortedMap  $map            The underlying map
 */
class SubMap extends AbstractMap
{
    /**
     * When the from or to key is unused
     *
     * @since 1.0.0
     */
    private const UNUSED = 0;

    /**
     * When the from or to key is inclusive
     *
     * @since 1.0.0
     */
    private const INCLUSIVE = 1;

    /**
     * When the from or to key is exclusive
     *
     * @since 1.0.0
     */
    private const EXCLUSIVE = 2;

    /**
     * @var SortedMap  Internal map
     *
     * @since 1.0.0
     */
    private $mapInternal;

    /**
     * @var integer  from option
     *
     * @since 1.0.0
     */
    private $fromOption;

    /**
     * @var mixed  from key
     *
     * @since 1.0.0
     */
    private $fromKey;

    /**
     * @var integer  to option
     *
     * @since 1.0.0
     */
    private $toOption;

    /**
     * @var mixed  to key
     *
     * @since 1.0.0
     */
    private $toKey;

    /**
     * @var boolean  Empty flag
     *
     * @since 1.0.0
     */
    private $empty;

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
            case 'fromKey':
                return $this->getFromKey();

            case 'toKey':
                return $this->getToKey();

            case 'fromInclusive':
                return $this->isFromInclusive();

            case 'toInclusive':
                return $this->isToInclusive();

            case 'map':
                return $this->mapInternal;
            default:
                return parent::__get($property);
        }
    }

    /**
     * Get from key property value
     *
     * @return mixed
     *
     * @throws RuntimeException If from key is undefined
     *
     * @since 1.0.0
     */
    private function getFromKey()
    {
        if ($this->fromOption == self::UNUSED) {
            throw new \RuntimeException('Undefined property');
        }

        return $this->fromKey;
    }

    /**
     * Get to key property value
     *
     * @return mixed
     *
     * @throws RuntimeException If to key is undefined
     *
     * @since 1.0.0
     */
    private function getToKey()
    {
        if ($this->toOption == self::UNUSED) {
            throw new \RuntimeException('Undefined property');
        }

        return $this->toKey;
    }

    /**
     * Get fromInclusive property value
     *
     * @return boolean
     *
     * @throws RuntimeException If fromInclusive is undefined
     *
     * @since 1.0.0
     */
    private function isFromInclusive()
    {
        if ($this->fromOption == self::UNUSED) {
            throw new \RuntimeException('Undefined property');
        }

        return $this->fromOption == self::INCLUSIVE;
    }

    /**
     * Get toInclusive property value
     *
     * @return boolean
     *
     * @throws RuntimeException If toInclusive is undefined
     *
     * @since 1.0.0
     */
    private function isToInclusive()
    {
        if ($this->toOption == self::UNUSED) {
            throw new \RuntimeException('Undefined property');
        }

        return $this->toOption == self::INCLUSIVE;
    }

    /**
     * Magic set method
     *
     * @param string $property The property
     * @param mixed  $value    The new value
     *
     * @throws RuntimeException If the property does not exist
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function __set($property, $value)
    {
        switch ($property) {
            case 'fromKey':
                $this->setFromKey($value);
                break;
            case 'toKey':
                $this->setToKey($value);
                break;
            case 'fromInclusive':
                $this->setFromInclusive($value);
                break;
            case 'toInclusive':
                $this->setToInclusive($value);
                break;
            default:
                throw new \RuntimeException('Undefined property');
        }

        $this->setEmpty();
    }

    /**
     * Set from key bound
     *
     * @param mixed $value The from key
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setFromKey($value)
    {
        $this->fromKey = $value;

        if ($this->fromOption == self::UNUSED) {
            $this->fromOption = self::INCLUSIVE;
        }
    }

    /**
     * Set to key bound
     *
     * @param mixed $value The to key
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setToKey($value)
    {
        $this->toKey = $value;

        if ($this->toOption == self::UNUSED) {
            $this->toOption = self::EXCLUSIVE;
        }
    }

    /**
     * Set from inclusiveness
     *
     * @param mixed $value The from inclusive flag
     *
     * @return void
     *
     * @throws RuntimeException If from bound is undefined
     *
     * @since 1.0.0
     */
    private function setFromInclusive($value)
    {
        if ($this->fromOption == self::UNUSED) {
            throw new \RuntimeException('Undefined property');
        }

        $this->fromOption = $value ? self::INCLUSIVE : self::EXCLUSIVE;
    }

    /**
     * Set to inclusiveness
     *
     * @param mixed $value The to inclusive flag
     *
     * @return void
     *
     * @throws RuntimeException If to bound is undefined
     *
     * @since 1.0.0
     */
    private function setToInclusive($value)
    {
        if ($this->toOption == self::UNUSED) {
            throw new \RuntimeException('Undefined property');
        }

        $this->toOption = $value ? self::INCLUSIVE : self::EXCLUSIVE;
    }

    /**
     * Magic unset method
     *
     * @param string $property The property
     *
     * @throws RuntimeException If the property does not exist
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function __unset($property)
    {
        switch ($property) {
            case 'fromKey':
            case 'fromInclusive':
                $this->fromOption = self::UNUSED;
                break;
            case 'toKey':
            case 'toInclusive':
                $this->toOption = self::UNUSED;
                break;
            default:
                throw new \RuntimeException('Undefined property');
        }

        $this->setEmpty();
    }

    /**
     * Magic isset method
     *
     * @param string $property The property
     *
     * @return boolean
     *
     * @since 1.0.0
     */
    public function __isset($property)
    {
        switch ($property) {
            case 'fromKey':
            case 'fromInclusive':
                return $this->fromOption != self::UNUSED;
            case 'toKey':
            case 'toInclusive':
                return $this->toOption != self::UNUSED;
            default:
                return false;
        }
    }

    /**
     * Constructor
     *
     * @param SortedMap $map        Internal map
     * @param mixed     $fromKey    The from key
     * @param integer   $fromOption The option for from (SubMap::UNUSED, SubMap::INCLUSIVE or SubMap::EXCLUSIVE)
     * @param mixed     $toKey      The to key
     * @param integer   $toOption   The option for to (SubMap::UNUSED, SubMap::INCLUSIVE or SubMap::EXCLUSIVE)
     *
     * @since 1.0.0
     */
    protected function __construct(SortedMap $map, $fromKey, $fromOption, $toKey, $toOption)
    {
        $this->mapInternal = $map;
        $this->fromKey = $fromKey;
        $this->fromOption = $fromOption;
        $this->toKey = $toKey;
        $this->toOption = $toOption;
        $this->setEmpty();
    }

    /**
     * Set the empty flag
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected function setEmpty()
    {
        if ($this->fromOption != self::UNUSED && $this->toOption != self::UNUSED) {
            $cmp = $this->compareKeys($this->fromKey, $this->toKey);

            $this->empty = $cmp > 0
              || $cmp == 0 && ($this->fromOption == self::EXCLUSIVE || $this->toOption == self::EXCLUSIVE);
        } else {
            $this->empty = false;
        }
    }

    /**
     * Compare 2 keys using the map comparator
     *
     * @param mixed $key1 First key
     * @param mixed $key2 Second key
     *
     * @return integer Comparison result
     *
     * @since 1.0.0
     */
    private function compareKeys($key1, $key2)
    {
        return call_user_func($this->mapInternal->comparator(), $key1, $key2);
    }

    /**
     * Validate lower() input against the lower bound
     *
     * @param mixed $key The searched key
     *
     * @return void
     *
     * @throws OutOfBoundsException If lower bound excludes the key
     *
     * @since 1.0.0
     */
    private function assertLowerAllowed($key)
    {
        if ($this->fromOption != self::UNUSED && $this->compareKeys($key, $this->fromKey) <= 0) {
            throw new \OutOfBoundsException('Lower element unexisting');
        }
    }

    /**
     * Validate floor() input against the lower bound
     *
     * @param mixed $key The searched key
     *
     * @return void
     *
     * @throws OutOfBoundsException If lower bound excludes the key
     *
     * @since 1.0.0
     */
    private function assertFloorAllowed($key)
    {
        if (
            ($this->fromOption == self::INCLUSIVE && $this->compareKeys($key, $this->fromKey) < 0)
            || ($this->fromOption == self::EXCLUSIVE && $this->compareKeys($key, $this->fromKey) <= 0)
        ) {
            throw new \OutOfBoundsException('Floor element unexisting');
        }
    }

    /**
     * Validate higher() input against the upper bound
     *
     * @param mixed $key The searched key
     *
     * @return void
     *
     * @throws OutOfBoundsException If upper bound excludes the key
     *
     * @since 1.0.0
     */
    private function assertHigherAllowed($key)
    {
        if ($this->toOption != self::UNUSED && $this->compareKeys($key, $this->toKey) >= 0) {
            throw new \OutOfBoundsException('Higher element unexisting');
        }
    }

    /**
     * Validate ceiling() input against the upper bound
     *
     * @param mixed $key The searched key
     *
     * @return void
     *
     * @throws OutOfBoundsException If upper bound excludes the key
     *
     * @since 1.0.0
     */
    private function assertCeilingAllowed($key)
    {
        if (
            ($this->toOption == self::INCLUSIVE && $this->compareKeys($key, $this->toKey) > 0)
            || ($this->toOption == self::EXCLUSIVE && $this->compareKeys($key, $this->toKey) >= 0)
        ) {
            throw new \OutOfBoundsException('Ceiling element unexisting');
        }
    }

    /**
     * Validate find() input against lower bound
     *
     * @param mixed $key The searched key
     *
     * @return void
     *
     * @throws OutOfBoundsException If lower bound excludes the key
     *
     * @since 1.0.0
     */
    private function assertFindLowerAllowed($key)
    {
        if (
            ($this->fromOption == self::INCLUSIVE && $this->compareKeys($key, $this->fromKey) < 0)
            || ($this->fromOption == self::EXCLUSIVE && $this->compareKeys($key, $this->fromKey) <= 0)
        ) {
            throw new \OutOfBoundsException('Element unexisting');
        }
    }

    /**
     * Validate find() input against upper bound
     *
     * @param mixed $key The searched key
     *
     * @return void
     *
     * @throws OutOfBoundsException If upper bound excludes the key
     *
     * @since 1.0.0
     */
    private function assertFindUpperAllowed($key)
    {
        if (
            ($this->toOption == self::INCLUSIVE && $this->compareKeys($key, $this->toKey) > 0)
            || ($this->toOption == self::EXCLUSIVE && $this->compareKeys($key, $this->toKey) >= 0)
        ) {
            throw new \OutOfBoundsException('Element unexisting');
        }
    }

    /**
     * Ensure lower() result respects an exclusive lower bound
     *
     * @param TreeNode $node The found node
     *
     * @return void
     *
     * @throws OutOfBoundsException If result is out of bounds
     *
     * @since 1.0.0
     */
    private function assertLowerResultInRange($node)
    {
        if ($node === null) {
            return;
        }

        if ($this->fromOption == self::EXCLUSIVE && $this->compareKeys($node->key, $this->fromKey) <= 0) {
            throw new \OutOfBoundsException('Lower element unexisting');
        }
    }

    /**
     * Ensure higher() result respects an exclusive upper bound
     *
     * @param TreeNode $node The found node
     *
     * @return void
     *
     * @throws OutOfBoundsException If result is out of bounds
     *
     * @since 1.0.0
     */
    private function assertHigherResultInRange($node)
    {
        if ($node === null) {
            return;
        }

        if ($this->toOption == self::EXCLUSIVE && $this->compareKeys($node->key, $this->toKey) >= 0) {
            throw new \OutOfBoundsException('Higher element unexisting');
        }
    }

    /**
     * Clamp a lower-like result against the upper bound
     *
     * @param TreeNode $node The found node
     *
     * @return TreeNode The clamped node
     *
     * @since 1.0.0
     */
    private function clampLowerToUpperBound($node)
    {
        if (
            ($this->toOption == self::INCLUSIVE && $this->compareKeys($node->key, $this->toKey) > 0)
            || ($this->toOption == self::EXCLUSIVE && $this->compareKeys($node->key, $this->toKey) >= 0)
        ) {
            return $this->last();
        }

        return $node;
    }

    /**
     * Clamp a floor-like result against the upper bound
     *
     * @param TreeNode $node The found node
     *
     * @return TreeNode The clamped node
     *
     * @since 1.0.0
     */
    private function clampFloorToUpperBound($node)
    {
        if (
            ($this->toOption == self::INCLUSIVE && $this->compareKeys($node->key, $this->toKey) > 0)
            || ($this->toOption == self::EXCLUSIVE && $this->compareKeys($node->key, $this->toKey) >= 0)
        ) {
            return $this->last();
        }

        return $node;
    }

    /**
     * Clamp a higher-like result against the lower bound
     *
     * @param TreeNode $node The found node
     *
     * @return TreeNode The clamped node
     *
     * @since 1.0.0
     */
    private function clampHigherToLowerBound($node)
    {
        if (
            ($this->fromOption == self::INCLUSIVE && $this->compareKeys($node->key, $this->fromKey) < 0)
            || ($this->fromOption == self::EXCLUSIVE && $this->compareKeys($node->key, $this->fromKey) <= 0)
        ) {
            return $this->first();
        }

        return $node;
    }

    /**
     * Clamp a ceiling-like result against the lower bound
     *
     * @param TreeNode $node The found node
     *
     * @return TreeNode The clamped node
     *
     * @since 1.0.0
     */
    private function clampCeilingToLowerBound($node)
    {
        if (
            ($this->fromOption == self::INCLUSIVE && $this->compareKeys($node->key, $this->fromKey) < 0)
            || ($this->fromOption == self::EXCLUSIVE && $this->compareKeys($node->key, $this->fromKey) <= 0)
        ) {
            return $this->first();
        }

        return $node;
    }

    /**
     * Create
     *
     * @param SortedMap $map           A sorted map
     * @param mixed     $fromKey       The from key
     * @param mixed     $toKey         The to key
     * @param boolean   $fromInclusive The inclusive flag for from
     * @param boolean   $toInclusive   The inclusive flag for to
     *
     * @return SubMap A new sub map
     *
     * @since 1.0.0
     */
    public static function create(SortedMap $map, $fromKey, $toKey, $fromInclusive = true, $toInclusive = false)
    {
        return new static(
            $map,
            $fromKey,
            $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE,
            $toKey,
            $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE
        );
    }

    /**
     * Return a head portion of a sorted map
     *
     * @param SortedMap $map         A sorted map
     * @param mixed     $toKey       The to key
     * @param boolean   $toInclusive The inclusive flag for to
     *
     * @return SubMap A new head map
     *
     * @since 1.0.0
     */
    public static function head(SortedMap $map, $toKey, $toInclusive = false)
    {
        return new static($map, null, self::UNUSED, $toKey, $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE);
    }

    /**
     * Return a tail portion of a sorted map
     *
     * @param SortedMap $map           A sorted map
     * @param mixed     $fromKey       The from key
     * @param boolean   $fromInclusive The inclusive flag for from
     *
     * @return SubMap A new tail map
     *
     * @since 1.0.0
     */
    public static function tail(SortedMap $map, $fromKey, $fromInclusive = true)
    {
        return new static($map, $fromKey, $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE, null, self::UNUSED);
    }

    /**
     * Return a view of the map
     *
     * @param SortedMap $map A sorted map
     *
     * @return SubMap A new sub map
     *
     * @since 1.0.0
     */
    public static function view(SortedMap $map)
    {
        return new static($map, null, self::UNUSED, null, self::UNUSED);
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
        return $this->mapInternal->comparator();
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
        if ($this->empty) {
            throw new \OutOfBoundsException('First element unexisting');
        }

        switch ($this->fromOption) {
            case self::INCLUSIVE:
                $first = $this->mapInternal->ceiling($this->fromKey);
                break;
            case self::EXCLUSIVE:
                $first = $this->mapInternal->higher($this->fromKey);
                break;
            default:
                $first = $this->mapInternal->first();
                break;
        }

        return $first;
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
        if ($this->empty) {
            throw new \OutOfBoundsException('Last element unexisting');
        }

        switch ($this->toOption) {
            case self::INCLUSIVE:
                $last = $this->map->floor($this->toKey);
                break;
            case self::EXCLUSIVE:
                $last = $this->map->lower($this->toKey);
                break;
            default:
                $last = $this->map->last();
                break;
        }

        return $last;
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
        $predecessor = $this->map->predecessor($element);

        if ($predecessor) {
            switch ($this->fromOption) {
                case self::INCLUSIVE:
                    if (call_user_func($this->map->comparator(), $predecessor->key, $this->fromKey) < 0) {
                        throw new \OutOfBoundsException('Predecessor element unexisting');
                    }
                    break;
                case self::EXCLUSIVE:
                    if (call_user_func($this->map->comparator(), $predecessor->key, $this->fromKey) <= 0) {
                        throw new \OutOfBoundsException('Predecessor element unexisting');
                    }
                    break;
            }
        }

        return $predecessor;
    }

    /**
     * Get the successor element
     *
     * @param TreeNode $element A tree node member of the underlying TreeMap
     *
     * @return mixed The successor element
     *
     * @throws OutOfBoundsException If there is no successor
     *
     * @since 1.0.0
     */
    public function successor($element)
    {
        $successor = $this->map->successor($element);

        if ($successor) {
            switch ($this->toOption) {
                case self::INCLUSIVE:
                    if (call_user_func($this->map->comparator(), $successor->key, $this->toKey) > 0) {
                        throw new \OutOfBoundsException('Successor element unexisting');
                    }
                    break;
                case self::EXCLUSIVE:
                    if (call_user_func($this->map->comparator(), $successor->key, $this->toKey) >= 0) {
                        throw new \OutOfBoundsException('Successor element unexisting');
                    }
                    break;
            }
        }

        return $successor;
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
        if ($this->empty) {
            throw new \OutOfBoundsException('Lower element unexisting');
        }

        $this->assertLowerAllowed($key);

        $lower = $this->mapInternal->lower($key);
        $this->assertLowerResultInRange($lower);

        if ($lower) {
            $lower = $this->clampLowerToUpperBound($lower);
        }

        return $lower;
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
        if ($this->empty) {
            throw new \OutOfBoundsException('Floor element unexisting');
        }

        $this->assertFloorAllowed($key);

        $floor = $this->mapInternal->floor($key);

        if ($floor) {
            $floor = $this->clampFloorToUpperBound($floor);
        }

        return $floor;
    }

    /**
     * Returns the element whose key is equal to the given key
     *
     * @param mixed $key The searched key
     *
     * @return mixed The found element
     *
     * @throws OutOfBoundsException  If there is no such element
     *
     * @since 1.0.0
     */
    public function find($key)
    {
        $this->assertFindLowerAllowed($key);
        $this->assertFindUpperAllowed($key);

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
        if ($this->empty) {
            throw new \OutOfBoundsException('Ceiling element unexisting');
        }

        $this->assertCeilingAllowed($key);

        $ceiling = $this->mapInternal->ceiling($key);

        if ($ceiling) {
            $ceiling = $this->clampCeilingToLowerBound($ceiling);
        }

        return $ceiling;
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
        if ($this->empty) {
            throw new \OutOfBoundsException('Higher element unexisting');
        }

        $this->assertHigherAllowed($key);

        $higher = $this->mapInternal->higher($key);
        $this->assertHigherResultInRange($higher);

        if ($higher) {
            $higher = $this->clampHigherToLowerBound($higher);
        }

        return $higher;
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
        if ($this->fromOption == self::UNUSED) {
            if ($this->toOption == self::UNUSED) {
                return array(
                    'ViewMap' => array(
                        'map' => $this->map->jsonSerialize(),
                     )
                );
            } else {
                return array(
                    'HeadMap' => array(
                        'map' => $this->map->jsonSerialize(),
                        'toKey' => $this->toKey,
                        'toInclusive' => $this->toOption == self::INCLUSIVE,
                    )
                );
            }
        } else {
            if ($this->toOption == self::UNUSED) {
                return array(
                    'TailMap' => array(
                        'map' => $this->map->jsonSerialize(),
                        'fromKey' => $this->fromKey,
                        'fromInclusive' => $this->fromOption == self::INCLUSIVE,
                    )
                );
            } else {
                return array(
                    'SubMap' => array(
                        'map' => $this->map->jsonSerialize(),
                        'fromKey' => $this->fromKey,
                        'fromInclusive' => $this->fromOption == self::INCLUSIVE,
                        'toKey' => $this->toKey,
                        'toInclusive' => $this->toOption == self::INCLUSIVE,
                    )
                );
            }
        }
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
        $count = 0;

        foreach ($this as $value) {
            $count++;
        }

        return $count;
    }
}
