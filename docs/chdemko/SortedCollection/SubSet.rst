---------------------------------
chdemko\\SortedCollection\\SubSet
---------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:class:: SubSet

    Sub set

    .. php:const:: UNUSED

        When the from or to value is unused

    .. php:const:: INCLUSIVE

        When the from or to value is inclusive

    .. php:const:: EXCLUSIVE

        When the from or to value is exclusive

    .. php:method:: __get($property)

        Magic get method

        :type $property: string
        :param $property: The property
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

    .. php:method:: __construct(SortedSet $set, $from, $fromOption, $to, $toOption)

        Constructor

        :type $set: SortedSet
        :param $set: Internal set
        :type $from: mixed
        :param $from: The from element
        :type $fromOption: integer
        :param $fromOption: The option for from (SubSet::UNUSED, SubSet::INCLUSIVE or SubSet::EXCLUSIVE)
        :type $to: mixed
        :param $to: The to element
        :type $toOption: integer
        :param $toOption: The option for to (SubSet::UNUSED, SubSet::INCLUSIVE or SubSet::EXCLUSIVE)

    .. php:method:: create(SortedSet $set, $from, $to, $fromInclusive = true, $toInclusive = false)

        Create

        :type $set: SortedSet
        :param $set: Internal set
        :type $from: mixed
        :param $from: The from element
        :type $to: mixed
        :param $to: The to element
        :type $fromInclusive: boolean
        :param $fromInclusive: The inclusive flag for from
        :type $toInclusive: boolean
        :param $toInclusive: The inclusive flag for to
        :returns: SubSet A new sub set

    .. php:method:: head(SortedSet $set, $to, $toInclusive = false)

        Head

        :type $set: SortedSet
        :param $set: Internal set
        :type $to: mixed
        :param $to: The to element
        :type $toInclusive: boolean
        :param $toInclusive: The inclusive flag for to
        :returns: SubSet A new head set

    .. php:method:: tail(SortedSet $set, $from, $fromInclusive = true)

        Tail

        :type $set: SortedSet
        :param $set: Internal set
        :type $from: mixed
        :param $from: The from element
        :type $fromInclusive: boolean
        :param $fromInclusive: The inclusive flag for from
        :returns: SubSet A new tail set

    .. php:method:: view(SortedSet $set)

        View

        :type $set: SortedSet
        :param $set: Internal set
        :returns: SubSet A new sub set

    .. php:method:: jsonSerialize()

        Serialize the object

        :returns: array Array of values

    .. php:method:: getMap()

        Get the map

        :returns: SortedMap The underlying map

    .. php:method:: setMap(SortedMap $map)

        Set the map

        :type $map: SortedMap
        :param $map: The underlying map
        :returns: AbstractSet $this for chaining

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

    .. php:method:: offsetSet($element, $value)

        Set the value for an element

        :type $element: mixed
        :param $element: The element
        :type $value: mixed
        :param $value: The value
        :returns: void

    .. php:method:: offsetUnset($element)

        Unset the existence of an element

        :type $element: mixed
        :param $element: The element
        :returns: void

    .. php:method:: count()

        Count the number of elements

        :returns: integer
