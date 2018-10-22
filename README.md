PHP Sorted Collections
======================
[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=chdemko&url=https://github.com/chdemko/php-sorted-collections&title=PHP%20Sorted%20Collections&language=&tags=github&category=software)
[![Travis](https://img.shields.io/travis/chdemko/php-sorted-collections.svg)](http://travis-ci.org/chdemko/php-sorted-collections)
[![Documentation Status](https://img.shields.io/readthedocs/php-sorted-collections.svg)](http://php-sorted-collections.readthedocs.io/en/latest/?badge=latest)
[![Coveralls](https://img.shields.io/coveralls/chdemko/php-sorted-collections.svg)](https://coveralls.io/r/chdemko/php-sorted-collections?branch=master)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/chdemko/php-sorted-collections.svg)](https://scrutinizer-ci.com/g/chdemko/php-sorted-collections/?branch=master)
[![PHP versions](https://img.shields.io/php-eye/chdemko/sorted-collections.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Stable Version](https://img.shields.io/packagist/v/chdemko/sorted-collections.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![Packagist](https://img.shields.io/packagist/dt/chdemko/sorted-collections.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Unstable Version](https://poser.pugx.org/chdemko/sorted-collections/v/unstable.svg)](https://packagist.org/packages/chdemko/sorted-collections)
[![License](https://poser.pugx.org/chdemko/sorted-collections/license.svg)](https://raw.githubusercontent.com/chdemko/php-sorted-collections/master/LICENSE)

Sorted Collection for PHP. Insertion, search, and removal compute in `log(n)` time where `n` is the number of items present in the collection. It uses AVL threaded tree [see @Knuth97, 1:320, Sect. 2.3.1] as internal structure.

@Knuth97: Donald E. Knuth, The Art of Computer Programming, Addison-Wesley, volumes 1 and 2, 2nd edition, 1997.

This project uses:

* [PHP Code Sniffer](https://github.com/squizlabs/php_codesniffer) for checking PHP code style using [Joomla Coding Standards](https://github.com/joomla/coding-standards)
* [PHPUnit](http://phpunit.de/) for unit test (100% covered)
* [phpDocumentor](http://http://www.phpdoc.org/) and [sphpdox](https://packagist.org/packages/sphpdox/sphpdox) for [documentation](http://php-sorted-collections.readthedocs.io/en/latest/?badge=latest)

Instructions
------------

Using composer: either

~~~bash
$ composer create-project chdemko/sorted-collections:1.0.*@dev; cd sorted-collections
~~~

or create a `composer.json` file containing

~~~json
{
    "require": {
        "chdemko/sorted-collections": "1.0.*@dev"
    }
}
~~~

and run

~~~bash
$ composer install
~~~

Run also

~~~bash
$ [sudo] pip install [--user] -r docs/requirements.txt
~~~

if you want to create local documentation.

Create a `test.php` file containg

~~~php
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

See the [examples](https://github.com/chdemko/php-sorted-collections/tree/master/examples) and [benchmarks](https://github.com/chdemko/php-sorted-collections/tree/master/benchmarks) folder for more information.

Citation
--------

If you are using this project including publication in research activities, you have to cite it using ([BibTeX format](https://raw.github.com/chdemko/php-sorted-collections/master/cite.bib)). You are also pleased to send me an email to chdemko@gmail.com.
* authors: Christophe Demko
* title: php-sorted-collections: a PHP library for handling sorted collections
* year: 2014
* how published: https://packagist.org/packages/chdemko/sorted-collections

All releases can be found [here](https://github.com/chdemko/php-sorted-collections/releases)
