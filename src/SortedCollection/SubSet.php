<?php

/**
 * chdemko\SortedCollection\SubSet class
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
 * Sub set
 *
 * @package    SortedCollection
 * @subpackage Set
 *
 * @since 1.0.0
 *
 * @property      mixed      $from           The from element
 * @property      boolean    $fromInclusive  The from inclusive flag
 * @property      mixed      $to             The to element
 * @property      boolean    $toInclusive    The to inclusive flag
 * @property-read callable   $comparator     The element comparison function
 * @property-read mixed      $first          The first element of the set
 * @property-read mixed      $last           The last element of the set
 * @property-read integer    $count          The number of elements in the set
 * @property-read SortedSet  $set            The underlying set
 */
class SubSet extends AbstractSet
{
    /**
     * When the from or to value is unused
     *
     * @since 1.0.0
     */
    private const UNUSED = 0;

    /**
     * When the from or to value is inclusive
     *
     * @since 1.0.0
     */
    private const INCLUSIVE = 1;

    /**
     * When the from or to value is exclusive
     *
     * @since 1.0.0
     */
    private const EXCLUSIVE = 2;

    /**
     * @var SortedSet  Internal set
     *
     * @since 1.0.0
     */
    private $set;

    /**
     * Get the underlying map as a SubMap
     *
     * @throws RuntimeException If the underlying map is not a SubMap
     *
     * @return SubMap The underlying sub map
     *
     * @since 1.0.0
     */
    private function getSubMap()
    {
        $map = $this->getMap();

        if (!$map instanceof SubMap) {
            throw new \RuntimeException('Unexpected map type');
        }

        return $map;
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
        $map = $this->getSubMap();

        switch ($property) {
            case 'from':
                return $map->fromKey;
            case 'to':
                return $map->toKey;
            case 'fromInclusive':
                return $map->fromInclusive;
            case 'toInclusive':
                return $map->toInclusive;
            case 'set':
                return $this->set;
            default:
                return parent::__get($property);
        }
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
        $map = $this->getSubMap();

        switch ($property) {
            case 'from':
                $map->fromKey = $value;
                break;
            case 'to':
                $map->toKey = $value;
                break;
            case 'fromInclusive':
                $map->fromInclusive = $value;
                break;
            case 'toInclusive':
                $map->toInclusive = $value;
                break;
            default:
                throw new \RuntimeException('Undefined property');
        }
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
        $map = $this->getSubMap();

        switch ($property) {
            case 'from':
                unset($map->fromKey);
                break;
            case 'to':
                unset($map->toKey);
                break;
            case 'fromInclusive':
                unset($map->fromInclusive);
                break;
            case 'toInclusive':
                unset($map->toInclusive);
                break;
            default:
                throw new \RuntimeException('Undefined property');
        }
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
        $map = $this->getSubMap();

        switch ($property) {
            case 'from':
                return isset($map->fromKey);
            case 'to':
                return isset($map->toKey);
            case 'fromInclusive':
                return isset($map->fromInclusive);
            case 'toInclusive':
                return isset($map->toInclusive);
            default:
                return false;
        }
    }

    /**
     * Constructor
     *
     * @param SortedSet $set        Internal set
     * @param mixed     $from       The from element
     * @param integer   $fromOption The option for from (SubSet::UNUSED, SubSet::INCLUSIVE or SubSet::EXCLUSIVE)
     * @param mixed     $to         The to element
     * @param integer   $toOption   The option for to (SubSet::UNUSED, SubSet::INCLUSIVE or SubSet::EXCLUSIVE)
     *
     * @since 1.0.0
     */
    protected function __construct(SortedSet $set, $from, $fromOption, $to, $toOption)
    {
        if ($fromOption == self::UNUSED) {
            if ($toOption == self::UNUSED) {
                $this->setMap(SubMap::view($set->getMap()));
            } else {
                $this->setMap(SubMap::head($set->getMap(), $to, $toOption == self::INCLUSIVE));
            }
        } elseif ($toOption == self::UNUSED) {
            $this->setMap(SubMap::tail($set->getMap(), $from, $fromOption == self::INCLUSIVE));
        } else {
            $this->setMap(
                SubMap::create($set->getMap(), $from, $to, $fromOption == self::INCLUSIVE, $toOption == self::INCLUSIVE)
            );
        }

        $this->set = $set;
    }

    /**
     * Create
     *
     * @param SortedSet $set           Internal set
     * @param mixed     $from          The from element
     * @param mixed     $to            The to element
     * @param boolean   $fromInclusive The inclusive flag for from
     * @param boolean   $toInclusive   The inclusive flag for to
     *
     * @return SubSet A new sub set
     *
     * @since 1.0.0
     */
    public static function create(SortedSet $set, $from, $to, $fromInclusive = true, $toInclusive = false)
    {
        return new static(
            $set,
            $from,
            $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE,
            $to,
            $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE
        );
    }

    /**
     * Head
     *
     * @param SortedSet $set         Internal set
     * @param mixed     $to          The to element
     * @param boolean   $toInclusive The inclusive flag for to
     *
     * @return SubSet A new head set
     *
     * @since 1.0.0
     */
    public static function head(SortedSet $set, $to, $toInclusive = false)
    {
        return new static($set, null, self::UNUSED, $to, $toInclusive ? self::INCLUSIVE : self::EXCLUSIVE);
    }

    /**
     * Tail
     *
     * @param SortedSet $set           Internal set
     * @param mixed     $from          The from element
     * @param boolean   $fromInclusive The inclusive flag for from
     *
     * @return SubSet A new tail set
     *
     * @since 1.0.0
     */
    public static function tail(SortedSet $set, $from, $fromInclusive = true)
    {
        return new static($set, $from, $fromInclusive ? self::INCLUSIVE : self::EXCLUSIVE, null, self::UNUSED);
    }

    /**
     * View
     *
     * @param SortedSet $set Internal set
     *
     * @return SubSet A new sub set
     *
     * @since 1.0.0
     */
    public static function view(SortedSet $set)
    {
        return new static($set, null, self::UNUSED, null, self::UNUSED);
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
        if (isset($this->from)) {
            if (isset($this->to)) {
                return array(
                    'SubSet' => array(
                        'set' => $this->set->jsonSerialize(),
                        'from' => $this->from,
                        'fromInclusive' => $this->fromInclusive,
                        'to' => $this->to,
                        'toInclusive' => $this->toInclusive,
                    )
                );
            } else {
                return array(
                    'TailSet' => array(
                        'set' => $this->set->jsonSerialize(),
                        'from' => $this->from,
                        'fromInclusive' => $this->fromInclusive,
                    )
                );
            }
        } else {
            if (isset($this->to)) {
                return array(
                    'HeadSet' => array(
                        'set' => $this->set->jsonSerialize(),
                        'to' => $this->to,
                        'toInclusive' => $this->toInclusive,
                    )
                );
            } else {
                return array(
                    'ViewSet' => array(
                        'set' => $this->set->jsonSerialize(),
                    )
                );
            }
        }
    }
}
