-------------------------------------------
chdemko\\SortedCollection\\SortedCollection
-------------------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:interface:: SortedCollection

    The SortedCollection interface is the root of the hierarchy. It extends:

    * :php:class:`ArrayAccess`
    * :php:class:`IteratorAggregate`
    * :php:class:`JsonSerializable`
    * :php:class:`Countable`

    And it is implemented by two classes: :php:class:`chdemko\\SortedCollection\\SortedMap`
    and :php:class:`chdemko\\SortedCollection\\SortedSet`

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
