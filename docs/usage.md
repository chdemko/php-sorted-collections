Usage
=====

Creation
--------

The base class for storing sorted maps is the `TreeMap` class.

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeMap;

// This will create a map indexed by numbers
// it contains 10 key/value pairs from 0/0 to 9/9
$map = TreeMap::create()->put(
    [1=>1, 9=>9, 5=>5, 2=>2, 6=>6, 3=>3, 0=>0, 8=>8, 7=>7, 4=>4]
);
~~~

There are two other classes to create maps which are in fact views on another sorted map.

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;
use chdemko\SortedCollection\SubMap;

$map = TreeMap::create()->put(
    [1=>1, 9=>9, 5=>5, 2=>2, 6=>6, 3=>3, 0=>0, 8=>8, 7=>7, 4=>4]
);

// This will create a map which is the reverse of $map
$reversed = ReversedMap::create($map);

// This will create a map which is a sub map of $reversed
$sub = SubMap::create($reversed, 7, 3);

// This will display {"7":7,"6":6,"5":5,"4":4}
echo $sub . PHP_EOL;
~~~

For sub maps there are other methods for creation

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\SubMap;

$map = TreeMap::create()->put(
    [1=>1, 9=>9, 5=>5, 2=>2, 6=>6, 3=>3, 0=>0, 8=>8, 7=>7, 4=>4]
);

// This will create a map which is a sub map of $map from key 3 to the end
$tail = SubMap::tail($map, 3);

$map[10] = 10;

// This will display {"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10}
echo $tail . PHP_EOL;

// This will create a sub map of $map from beginning to key 7 (inclusive)
$head = SubMap::head($map, 7, true);

// This will display [0,1,2,3,4,5,6,7]
echo $head . PHP_EOL;
~~~

Sets are created using similar functions

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeSet;
use chdemko\SortedCollection\ReversedSet;
use chdemko\SortedCollection\SubSet;

$set = TreeSet::create()->put([1, 9, 5, 2, 6, 3, 0, 8, 7, 4]);
$reversed = ReversedSet::create($set);
$sub = SubSet::create($reversed, 7, 3);

// This will display [7,6,5,4]
echo $sub . PHP_EOL;
~~~

Iteration
---------

These collections support PHP iteration.

Using maps

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;
use chdemko\SortedCollection\SubMap;

$map = TreeMap::create()->put(
    [1=>1, 9=>9, 5=>5, 2=>2, 6=>6, 3=>3, 0=>0, 8=>8, 7=>7, 4=>4]
);
$reversed = ReversedMap::create($map);
$sub = SubMap::create($reversed, 7, 3);

// This will display 7:7;6:6;5:5;4:4;
foreach ($sub as $key => $value)
{
	echo $key . ':' . $value . ';';
}
echo PHP_EOL;
~~~

Using sets

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeSet;
use chdemko\SortedCollection\ReversedSet;
use chdemko\SortedCollection\SubSet;

$set = TreeSet::create()->put([1, 9, 5, 2, 6, 3, 0, 8, 7, 4]);
$reversed = ReversedSet::create($set);
$sub = SubSet::create($reversed, 7, 3);

// This will display 0:7;1:6;2:5;3:4;
foreach ($sub as $key => $value)
{
	echo $key . ':' . $value . ';';
}
echo PHP_EOL;
~~~

**The behavior is unpredictable if the current key of an iterator is removed of the collection.**

Counting
--------

These collections support PHP counting

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;
use chdemko\SortedCollection\SubMap;

$map = TreeMap::create()->put(
    [1=>1, 9=>9, 5=>5, 2=>2, 6=>6, 3=>3, 0=>0, 8=>8, 7=>7, 4=>4]
);
$reversed = ReversedMap::create($map);
$sub = SubMap::create($reversed, 7, 3);

// This will display 4
echo count($sub) . PHP_EOL;
~~~

Array access
------------

Insertion, modification, access and removal has been designed to work using PHP array access features

Using maps

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeMap;

$map = TreeMap::create();
$map[4] = 4;
$map[2] = 2;
$map[6] = 6;
unset($map[4]);

// This will display 1
echo isset($map[2]) . PHP_EOL;

// This will display 2
echo $map[2] . PHP_EOL;
~~~

Using sets

~~~php
require __DIR__ . '/vendor/autoload.php';
use chdemko\SortedCollection\TreeSet;

$set = TreeSet::create();
$set[4] = true;
$set[2] = true;
$set[6] = true;
unset($set[4]);

// This will display 1
echo isset($set[2]) . PHP_EOL;

// This will display 1
echo $set[2] . PHP_EOL;

// This will display nothing
echo $set[4] . PHP_EOL;
~~~

A lot of methods has been implemented to give access to the minimum element, the lower element....

