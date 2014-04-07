PHP Sorted Collections
[![Downloads](https://poser.pugx.org/chdemko/sorted-collections/d/total.png)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Stable Version](https://poser.pugx.org/chdemko/sorted-collections/version.png)](https://packagist.org/packages/chdemko/sorted-collections)
[![Latest Unstable Version](https://poser.pugx.org/chdemko/sorted-collections/v/unstable.png)](https://packagist.org/packages/chdemko/sorted-collections)
[![Build Status](https://secure.travis-ci.org/chdemko/php-sorted-collections.png)](http://travis-ci.org/chdemko/php-sorted-collections)
[![License](https://poser.pugx.org/chdemko/sorted-collections/license.png)](https://packagist.org/packages/chdemko/sorted-collections)
======================

Sorted Collection for PHP. Insertion, search, and removal compute in `log(n)` time where `n` is the number of items present in the collection. It uses AVL threaded tree [see @Knuth97, 1:320, Sect. 2.3.1] as internal structure.

@Knuth97: Donald E. Knuth, The Art of Computer Programming, Addison-Wesley, volumes 1 and 2, 2nd edition, 1997.

This project uses:

* [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer) for checking PHP code style using [Joomla Coding Standards](https://github.com/joomla/coding-standards)
* [PHPUnit](http://phpunit.de/) for unit test (100% covered)
* [phpDocumentor](http://http://www.phpdoc.org/) for api documentation

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

