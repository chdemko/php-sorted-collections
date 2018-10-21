-----------------------------------
chdemko\\SortedCollection\\Iterator
-----------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:class:: Iterator

    Iterator

    .. php:const:: PAIRS

        Iterate on pairs

    .. php:const:: KEYS

        Iterate on keys

    .. php:const:: VALUES

        Iterate on values

    .. php:attr:: current

        protected TreeNode

    .. php:method:: __construct(SortedMap $map, $type)

        Constructor

        :type $map: SortedMap
        :param $map: Sorted map
        :type $type: integer
        :param $type: Iterator type

    .. php:method:: create(SortedMap $map)

        Create a new iterator on pairs

        :type $map: SortedMap
        :param $map: Sorted map
        :returns: Iterator A new iterator on pairs

    .. php:method:: keys(SortedMap $map)

        Create a new iterator on keys

        :type $map: SortedMap
        :param $map: Sorted map
        :returns: Iterator A new iterator on keys

    .. php:method:: values(SortedMap $map)

        Create a new iterator on values

        :type $map: SortedMap
        :param $map: Sorted map
        :returns: Iterator A new iterator on values

    .. php:method:: rewind()

        Rewind the Iterator to the first element

        :returns: void

    .. php:method:: key()

        Return the current key

        :returns: mixed The current key

    .. php:method:: current()

        Return the current value

        :returns: mixed The current value

    .. php:method:: next()

        Move forward to the next element

        :returns: void

    .. php:method:: valid()

        Checks if current position is valid

        :returns: boolean
