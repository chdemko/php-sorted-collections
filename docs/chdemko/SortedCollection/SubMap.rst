---------------------------------
chdemko\\SortedCollection\\SubMap
---------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:class:: SubMap

    Sub map

    .. php:const:: UNUSED

        When the from or to key is unused

    .. php:const:: INCLUSIVE

        When the from or to key is inclusive

    .. php:const:: EXCLUSIVE

        When the from or to key is exclusive

    .. php:method:: __get($property)

        Magic get method

        :param $property:
        :returns: mixed The value associated to the property

    .. php:method:: __set($property, $value)

        Magic set method

        :type $property: string
        :param $property: The property
        :type $value: mixed
        :param $value: The new value
        :returns: void

    .. php:method:: __unset($property)

        Magic unset method

        :type $property: string
        :param $property: The property
        :returns: void

    .. php:method:: __isset($property)

        Magic isset method

        :type $property: string
        :param $property: The property
        :returns: boolean

    .. php:method:: __construct(SortedMap $map, $fromKey, $fromOption, $toKey, $toOption)

        Constructor

        :type $map: SortedMap
        :param $map: Internal map
        :type $fromKey: mixed
        :param $fromKey: The from key
        :type $fromOption: integer
        :param $fromOption: The option for from (SubMap::UNUSED, SubMap::INCLUSIVE or SubMap::EXCLUSIVE)
        :type $toKey: mixed
        :param $toKey: The to key
        :type $toOption: integer
        :param $toOption: The option for to (SubMap::UNUSED, SubMap::INCLUSIVE or SubMap::EXCLUSIVE)

    .. php:method:: setEmpty()

        Set the empty flag

        :returns: void

    .. php:method:: create(SortedMap $map, $fromKey, $toKey, $fromInclusive = true, $toInclusive = false)

        Create

        :type $map: SortedMap
        :param $map: A sorted map
        :type $fromKey: mixed
        :param $fromKey: The from key
        :type $toKey: mixed
        :param $toKey: The to key
        :type $fromInclusive: boolean
        :param $fromInclusive: The inclusive flag for from
        :type $toInclusive: boolean
        :param $toInclusive: The inclusive flag for to
        :returns: SubMap A new sub map

    .. php:method:: head(SortedMap $map, $toKey, $toInclusive = false)

        Return a head portion of a sorted map

        :type $map: SortedMap
        :param $map: A sorted map
        :type $toKey: mixed
        :param $toKey: The to key
        :type $toInclusive: boolean
        :param $toInclusive: The inclusive flag for to
        :returns: SubMap A new head map

    .. php:method:: tail(SortedMap $map, $fromKey, $fromInclusive = true)

        Return a tail portion of a sorted map

        :type $map: SortedMap
        :param $map: A sorted map
        :type $fromKey: mixed
        :param $fromKey: The from key
        :type $fromInclusive: boolean
        :param $fromInclusive: The inclusive flag for from
        :returns: SubMap A new tail map

    .. php:method:: view(SortedMap $map)

        Return a view of the map

        :type $map: SortedMap
        :param $map: A sorted map
        :returns: SubMap A new sub map

    .. php:method:: comparator()

        Get the comparator

        :returns: callable The comparator

    .. php:method:: first()

        Get the first element or throw an exception if there is no such element

        :returns: mixed The first element

    .. php:method:: last()

        Get the last element or throw an exception if there is no such element

        :returns: mixed The last element

    .. php:method:: predecessor($element)

        Get the predecessor element or throw an exception if there is no such
        element

        :type $element: TreeNode
        :param $element: A tree node member of the underlying TreeMap
        :returns: mixed The predecessor element

    .. php:method:: successor($element)

        Get the successor element or throw an exception if there is no such
        element

        :type $element: TreeNode
        :param $element: A tree node member of the underlying TreeMap
        :returns: mixed The successor element

    .. php:method:: lower($key)

        Returns the element whose key is the greatest key lesser than the given
        key or throw an exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found element

    .. php:method:: floor($key)

        Returns the element whose key is the greatest key lesser than or equal to
        the given key or throw an exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found element

    .. php:method:: find($key)

        Returns the element whose key is equal to the given key or throw an
        exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found element

    .. php:method:: ceiling($key)

        Returns the element whose key is the lowest key greater than or equal to
        the given key or throw an exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found element

    .. php:method:: higher($key)

        Returns the element whose key is the lowest key greater than to the given
        key or throw an exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found element

    .. php:method:: jsonSerialize()

        Serialize the object

        :returns: array Array of values

    .. php:method:: count()

        Count the number of key/value pairs

        :returns: integer

    .. php:method:: firstKey()

        Get the first key or throw an exception if there is no element

        :returns: mixed The first key

    .. php:method:: firstValue()

        Get the first value or throw an exception if there is no element

        :returns: mixed The first value

    .. php:method:: lastKey()

        Get the last key or throw an exception if there is no element

        :returns: mixed The last key

    .. php:method:: lastValue()

        Get the last value or throw an exception if there is no element

        :returns: mixed The last value

    .. php:method:: lowerKey($key)

        Returns the greatest key lesser than the given key or throw an exception
        if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: lowerValue($key)

        Returns the value whose key is the greatest key lesser than the given key
        or throw an exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found value

    .. php:method:: floorKey($key)

        Returns the greatest key lesser than or equal to the given key or throw an
        exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: floorValue($key)

        Returns the value whose key is the greatest key lesser than or equal to
        the given key or throw an exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found value

    .. php:method:: findKey($key)

        Returns the key equal to the given key or throw an exception if there is
        no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: findValue($key)

        Returns the value whose key equal to the given key or throw an exception
        if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found value

    .. php:method:: ceilingKey($key)

        Returns the lowest key greater than or equal to the given key or throw an
        exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: ceilingValue($key)

        Returns the value whose key is the lowest key greater than or equal to the
        given key or throw an exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found value

    .. php:method:: higherKey($key)

        Returns the lowest key greater than to the given key or throw an exception
        if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: higherValue($key)

        Returns the value whose key is the lowest key greater than to the given
        key or throw an exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found value

    .. php:method:: keys()

        Keys iterator

        :returns: Iterator The keys iterator

    .. php:method:: values()

        Values iterator

        :returns: Iterator The values iterator

    .. php:method:: __toString()

        Convert the object to a string

        :returns: string String representation of the object

    .. php:method:: toArray()

        Convert the object to an array

        :returns: array Array representation of the object

    .. php:method:: getIterator()

        Create an iterator

        :returns: Iterator A new iterator

    .. php:method:: offsetGet($key)

        Get the value for a key

        :type $key: mixed
        :param $key: The key
        :returns: mixed The found value

    .. php:method:: offsetExists($key)

        Test the existence of a key

        :type $key: mixed
        :param $key: The key
        :returns: boolean TRUE if the key exists, false otherwise

    .. php:method:: offsetSet($key, $value)

        Set the value for a key

        :type $key: mixed
        :param $key: The key
        :type $value: mixed
        :param $value: The value
        :returns: void

    .. php:method:: offsetUnset($key)

        Unset the existence of a key

        :type $key: mixed
        :param $key: The key
        :returns: void
