PHP Sorted Collections
======================
[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=chdemko&url=https://github.com/chdemko/php-sorted-collections&title=PHP Sorted Collections&language=&tags=github&category=software)
[![Build Status](https://secure.travis-ci.org/chdemko/php-sorted-collections.png)](http://travis-ci.org/chdemko/php-sorted-collections)
[![Code coverage](https://coveralls.io/repos/chdemko/php-sorted-collections/badge.png?branch=master)](https://coveralls.io/r/chdemko/php-sorted-collections?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chdemko/php-sorted-collections/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chdemko/php-sorted-collections/?branch=master)
[![Dependency Status](https://www.versioneye.com/package/php--chdemko--sorted-collections/badge.svg)](https://www.versioneye.com/package/php--chdemko--sorted-collections)
[![Latest Stable Version](https://poser.pugx.org/chdemko/sorted-collections/v/stable.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![Total Downloads](https://poser.pugx.org/chdemko/sorted-collections/downloads.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Unstable Version](https://poser.pugx.org/chdemko/sorted-collections/v/unstable.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![License](https://poser.pugx.org/chdemko/sorted-collections/license.svg)](https://packagist.org/packages/chdemko/sorted-collections)

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
        "chdemko/sorted-collections": "1.0.x-dev"
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

$tree = TreeMap::create()->put(
    [1=>1, 9=>9, 5=>5, 2=>2, 6=>6, 3=>3, 0=>0, 8=>8, 7=>7, 4=>4]
);
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

All releases can be found [here](https://github.com/chdemko/php-sorted-collections/releases)
