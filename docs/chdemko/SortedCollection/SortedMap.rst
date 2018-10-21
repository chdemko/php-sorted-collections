------------------------------------
chdemko\\SortedCollection\\SortedMap
------------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:interface:: SortedMap

    SortedMap

    .. php:method:: firstKey()

        Get the first key or throw an exception if there is no element

        :returns: mixed The first key

    .. php:method:: lastKey()

        Get the last key or throw an exception if there is no element

        :returns: mixed The last key

    .. php:method:: lowerKey($key)

        Returns the greatest key lesser than the given key or throw an exception
        if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: floorKey($key)

        Returns the greatest key lesser than or equal to the given key or throw an
        exception if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: findKey($key)

        Returns the key equal to the given key or throw an exception if there is
        no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

    .. php:method:: ceilingKey($key)

        Returns the lowest key greater than or equal to the given key or throw an
        exception if there is no such key

        :param $key:
        :returns: mixed The found key

    .. php:method:: higherKey($key)

        Returns the lowest key greater than to the given key or throw an exception
        if there is no such key

        :type $key: mixed
        :param $key: The searched key
        :returns: mixed The found key

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

    .. php:method:: keys()

        Keys generator

        :returns: mixed The keys generator

    .. php:method:: values()

        Values generator

        :returns: mixed The values generator

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

    .. php:method:: offsetExists($offset)

        :param $offset:

    .. php:method:: offsetGet($offset)

        :param $offset:

    .. php:method:: offsetSet($offset, $value)

        :param $offset:
        :param $value:

    .. php:method:: offsetUnset($offset)

        :param $offset:

    .. php:method:: count()

    .. php:method:: getIterator()

    .. php:method:: jsonSerialize()
