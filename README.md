PHP Sorted Collections
======================
[![Downloads](https://poser.pugx.org/chdemko/sorted-collections/d/total.png)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Stable Version](https://poser.pugx.org/chdemko/sorted-collections/version.png)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Unstable Version](https://poser.pugx.org/chdemko/sorted-collections/v/unstable.png)](https://packagist.org/packages/chdemko/sorted-collections)
[![Code coverage](https://coveralls.io/repos/chdemko/php-sorted-collections/badge.png?branch=master)](https://coveralls.io/r/chdemko/php-sorted-collections?branch=master)
[![Build Status](https://secure.travis-ci.org/chdemko/php-sorted-collections.png)](http://travis-ci.org/chdemko/php-sorted-collections)
[![License](https://poser.pugx.org/chdemko/sorted-collections/license.png)](http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.html)

Sorted Collection for PHP. Insertion, search, and removal compute in `log(n)` time where `n` is the number of items present in the collection. It uses AVL threaded tree [see @Knuth97, 1:320, Sect. 2.3.1] as internal structure.

@Knuth97: Donald E. Knuth, The Art of Computer Programming, Addison-Wesley, volumes 1 and 2, 2nd edition, 1997.

This project uses:

* [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer) for checking PHP code style using [Joomla Coding Standards](https://github.com/joomla/coding-standards)
* [PHPUnit](http://phpunit.de/) for unit test (100% covered)
* [phpDocumentor](http://http://www.phpdoc.org/) for api documentation

Installation
------------

Using composer: either

~~~
$ composer create-project chdemko/sorted-collections:1.0.x-dev --dev; cd sorted-collections
~~~

or create a `composer.json` file containing

~~~json
{
	"require": {
		"chdemko/sorted-collections": "dev-master"
	}
}
~~~
and run
~~~
$ composer install
~~~

Create a `test.php` file containg
~~~php
<?php
require __DIR__ . '/vendor/autoload.php';

use chdemko\SortedCollection\TreeMap;

$tree = TreeMap::create()->put([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
echo $tree . PHP_EOL;
~~~
This should print
~~~
[0,1,2,3,4,5,6,7,8,9]
~~~
See the [examples](https://github.com/chdemko/php-sorted-collections/tree/master/examples) folder for more information.

Documentation
-------------

* [http://chdemko.github.io/php-sorted-collections](http://chdemko.github.io/php-sorted-collections)

Citation
--------

If you are using this project including publication in research activities, you have to cite it using ([BibTeX format](https://raw.github.com/chdemko/php-sorted-collections/master/cite.bib)). You are also pleased to send me an email to chdemko@gmail.com.
* authors: Christophe Demko
* title: php-sorted-collections: a PHP library for handling sorted collections
* year: 2014
* how published: http://chdemko.github.io/php-sorted-collections

