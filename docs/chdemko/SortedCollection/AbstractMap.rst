--------------------------------------
chdemko\\SortedCollection\\AbstractMap
--------------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:class:: AbstractMap

    AbstractMap

    .. php:method:: __get($property)

        Magic get method

        :type $property: string
        :param $property: The property
        :returns: mixed The value associated to the property

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

    .. php:method:: predecessor($node)

        Get the predecessor node

        :type $node: TreeNode
        :param $node: A tree node member of the underlying TreeMap
        :returns: mixed The predecessor node

    .. php:method:: successor($node)

        Get the successor node

        :type $node: TreeNode
        :param $node: A tree node member of the underlying TreeMap
        :returns: mixed The successor node

    .. php:method:: comparator()

        Get the comparator

        :returns: callable The comparator

    .. php:method:: first()

        Get the first element or throw an exception if there is no element

        :returns: mixed The first element

    .. php:method:: last()

        Get the last element or throw an exception if there is no element

        :returns: mixed The last element

    .. php:method:: lower($key)

        Returns the greatest element lesser than the given key or throw an
        exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found node

    .. php:method:: floor($key)

        Returns the greatest element lesser than or equal to the given key or
        throw an exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found node

    .. php:method:: find($key)

        Returns the element equal to the given key or throw an exception if there
        is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found node

    .. php:method:: ceiling($key)

        Returns the lowest element greater than or equal to the given key or throw
        an exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found node

    .. php:method:: higher($key)

        Returns the lowest element greater than to the given key or throw an
        exception if there is no such element

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found node

    .. php:method:: count()

    .. php:method:: jsonSerialize()
