----------------------------------
chdemko\\SortedCollection\\TreeSet
----------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:class:: TreeSet

    Tree set

    .. php:method:: __construct($comparator = null)

        Constructor

        :type $comparator: callable
        :param $comparator: Comparison function

    .. php:method:: create($comparator = null)

        Create

        :type $comparator: callable
        :param $comparator: Comparison function
        :returns: TreeSet A new TreeSet

    .. php:method:: put($traversable = array())

        Put values in the set

        :type $traversable: \Traversable
        :param $traversable: Values to put in the set
        :returns: TreeSet $this for chaining

    .. php:method:: clear()

        Clear the set

        :returns: TreeSet $this for chaining

    .. php:method:: initialise($traversable = array())

        Initialise the set

        :type $traversable: \Traversable
        :param $traversable: Values to initialise the set
        :returns: TreeSet $this for chaining

    .. php:method:: __clone()

        Clone the set

        :returns: void

    .. php:method:: offsetSet($element, $value)

        Set the value for an element

        :type $element: mixed
        :param $element: The element
        :type $value: mixed
        :param $value: The value
        :returns: void

    .. php:method:: jsonSerialize()

        Serialize the object

        :returns: array Array of values

    .. php:method:: offsetUnset($element)

        Unset the existence of an element

        :type $element: mixed
        :param $element: The element
        :returns: void

    .. php:method:: getMap()

        Get the map

        :returns: SortedMap The underlying map

    .. php:method:: setMap(SortedMap $map)

        Set the map

        :type $map: SortedMap
        :param $map: The underlying map
        :returns: AbstractSet $this for chaining

    .. php:method:: __get($property)

        Magic get method

        :type $property: string
        :param $property: The property
        :returns: mixed The value associated to the property

    .. php:method:: comparator()

        Get the comparator

        :returns: callable The comparator

    .. php:method:: first()

        Get the first element or throw an exception if there is no such element

        :returns: mixed The first element

    .. php:method:: last()

        Get the last element or throw an exception if there is no such element

        :returns: mixed The last element

    .. php:method:: lower($element)

        Returns the greatest element lesser than the given element or throw an
        exception if there is no such element

        :type $element: mixed
        :param $element: The searched element
        :returns: mixed The found element

    .. php:method:: floor($element)

        Returns the greatest element lesser than or equal to the given element or
        throw an exception if there is no such element

        :type $element: mixed
        :param $element: The searched element
        :returns: mixed The found element

    .. php:method:: find($element)

        Returns the element equal to the given element or throw an exception if
        there is no such element

        :type $element: mixed
        :param $element: The searched element
        :returns: mixed The found element

    .. php:method:: ceiling($element)

        Returns the lowest element greater than or equal to the given element or
        throw an exception if there is no such element

        :type $element: mixed
        :param $element: The searched element
        :returns: mixed The found element

    .. php:method:: higher($element)

        Returns the lowest element greater than to the given element or throw an
        exception if there is no such element

        :type $element: mixed
        :param $element: The searched element
        :returns: mixed The found element

    .. php:method:: __toString()

        Convert the object to a string

        :returns: string String representation of the object

    .. php:method:: toArray()

        Convert the object to an array

        :returns: array Array representation of the object

    .. php:method:: getIterator()

        Create an iterator

        :returns: Iterator A new iterator

    .. php:method:: offsetGet($element)

        Get the value for an element

        :type $element: mixed
        :param $element: The element
        :returns: mixed The found value

    .. php:method:: offsetExists($element)

        Test the existence of an element

        :type $element: mixed
        :param $element: The element
        :returns: boolean TRUE if the element exists, false otherwise

    .. php:method:: count()

        Count the number of elements

        :returns: integer
