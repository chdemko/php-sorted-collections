-----------------------------------
chdemko\\SortedCollection\\TreeNode
-----------------------------------

.. php:namespace: chdemko\\SortedCollection

.. php:class:: TreeNode

    TreeNode

    .. php:attr:: value

        mixed

    .. php:method:: create($key, $value)

        Create a node

        :type $key: mixed
        :param $key: The node key
        :type $value: mixed
        :param $value: The node value
        :returns: A new node

    .. php:method:: __construct($key, $value, $predecessor = null, $successor = null)

        Constructor

        :type $key: mixed
        :param $key: The node key
        :type $value: mixed
        :param $value: The node value
        :type $predecessor: TreeNode
        :param $predecessor: The left node
        :type $successor: TreeNode
        :param $successor: The right node

    .. php:method:: __get($property)

        Magic get method

        :type $property: string
        :param $property: The node property
        :returns: mixed The value associated to the property

    .. php:method:: first()

        Get the first node

        :returns: the first node

    .. php:method:: last()

        Get the last node

        :returns: the last node

    .. php:method:: predecessor()

        Get the predecessor

        :returns: the predecessor node

    .. php:method:: successor()

        Get the successor

        :returns: the successor node

    .. php:method:: count()

        Count the number of key/value pair

        :returns: integer

    .. php:method:: find($key, $comparator, $type = 0)

        Get the node for a key

        :type $key: mixed
        :param $key: The key
        :type $comparator: callable
        :param $comparator: The comparator function
        :type $type: integer
        :param $type: The operation type -2 for the greatest key lesser than the given key -1 for the greatest key lesser than or equal to the given key 0 for the given key +1 for the lowest key greater than or equal to the given key +2 for the lowest key greater than the given key
        :returns: mixed The node or null if not found

    .. php:method:: rotateLeft()

        Rotate the node to the left

        :returns: TreeNode The rotated node

    .. php:method:: rotateRight()

        Rotate the node to the right

        :returns: TreeNode The rotated node

    .. php:method:: incBalance()

        Increment the balance of the node

        :returns: TreeNode $this or a rotated version of $this

    .. php:method:: decBalance()

        Decrement the balance of the node

        :returns: TreeNode $this or a rotated version of $this

    .. php:method:: insert($key, $value, $comparator)

        Insert a key/value pair

        :type $key: mixed
        :param $key: The key
        :type $value: mixed
        :param $value: The value
        :type $comparator: callable
        :param $comparator: The comparator function
        :returns: TreeNode The new root

    .. php:method:: pullUpLeftMost()

        Pull up the left most node of a node

        :returns: TreeNode The new root

    .. php:method:: remove($key, $comparator)

        Remove a key

        :type $key: mixed
        :param $key: The key
        :type $comparator: callable
        :param $comparator: The comparator function
        :returns: TreeNode The new root
