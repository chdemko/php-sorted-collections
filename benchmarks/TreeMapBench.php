<?php

/**
 * TreeMap benchmark class
 *
 * @author     Christophe Demko <chdemko@gmail.com>
 * @copyright  Copyright (C) 2012-2023 Christophe Demko. All rights reserved.
 *
 * @license    BSD 3-Clause License
 *
 * This file is part of the php-sorted-collections package https://github.com/chdemko/php-sorted-collections
 */

// Declare chdemko\SortedCollectionBenchmark namespace
namespace chdemko\SortedCollectionBenchmark;

use chdemko\SortedCollection\TreeMap;
use chdemko\SortedCollection\ReversedMap;
use chdemko\SortedCollection\SubMap;

/**
 * TreeMap benchmark class
 *
 * @since 1.0.5
 */
class TreeMapBench
{
    /**
     * @var TreeMap The tree map
     *
     * @since 1.0.5
     */
    protected $tree;

    /**
     * @var SortedMap The sorted map
     *
     * @since 1.0.5
     */
    protected $data;

    /**
     * Provider for counts
     *
     * @return iterator Iterator on count
     *
     * @since 1.0.5
     */
    public function provideCounts()
    {
        yield ['count' => 100];
        yield ['count' => 1000];
        yield ['count' => 10000];
        yield ['count' => 100000];
    }

    /**
     * Provider for counts
     *
     * @return iterator Iterator on type
     *
     * @since 1.0.5
     */
    public function provideTypes()
    {
        yield ['type' => 'tree'];
        yield ['type' => 'reversed'];
        yield ['type' => 'sub', 'from' => 0.30, 'to' => 0.70];
        yield ['type' => 'sub', 'from' => 0.40, 'to' => 0.80];
    }

    /**
     * Create the tree map.
     *
     * @param array $params Array of parameters
     *
     * @return void
     *
     * @since 1.0.5
     */
    public function init($params)
    {
        $this->tree = TreeMap::create();
    }

    /**
     * Create the sorted map.
     *
     * @param array $params Array of parameters
     *
     * @return void
     *
     * @since 1.0.5
     */
    public function data($params)
    {
        if (isset($params['type'])) {
            switch ($params['type']) {
                case 'tree':
                    $this->data = $this->tree;
                    break;
                case 'reversed':
                    $this->data = ReversedMap::create($this->tree);
                    break;
                case 'sub':
                    if (isset($params['from']) && isset($params['to'])) {
                        $this->data = SubMap::create(
                            $this->tree,
                            (int) ($params['from'] * $params['count']),
                            (int) ($params['to'] * $params['count'])
                        );
                    } else {
                        $this->data = SubMap::create(
                            $this->tree,
                            null,
                            null
                        );
                    }
                    break;
            }
        } else {
            $this->data = $this->tree;
        }
    }

    /**
     * Clear the tree map.
     *
     * @param array $params Array of parameters
     *
     * @return void
     *
     * @since 1.0.5
     */
    public function finish($params)
    {
        $this->tree->clear();
    }

    /**
     * @BeforeMethods({"init", "data"})
     * @AfterMethods({"finish"})
     * @Revs(5)
     * @ParamProviders({"provideCounts"})
     *
     * @param array $params Array of parameters
     *
     * @return void
     *
     * @since 1.0.5
     */
    public function benchFill($params)
    {
        for ($i = 0; $i < $params['count']; $i++) {
            $this->tree[$i] = $i;
        }
    }

    /**
     * @BeforeMethods({"init", "benchFill", "data"})
     * @AfterMethods({"finish"})
     * @Revs(5)
     * @ParamProviders({"provideCounts", "provideTypes"})
     *
     * @param array $params Array of parameters
     *
     * @return void
     *
     * @since 1.0.5
     */
    public function benchSearch($params)
    {
        if (isset($params['from'])) {
            $min = (int) ($params['from'] * $params['count']);
        } else {
            $min = 0;
        }

        if (isset($params['to'])) {
            $max = (int) ($params['to'] * $params['count']);
        } else {
            $max = $params['count'];
        }

        for ($i = $min; $i < $max; $i++) {
            $value = $this->data[$i];
        }
    }

    /**
     * @BeforeMethods({"init", "benchFill", "data"})
     * @AfterMethods({"finish"})
     * @Revs(5)
     * @ParamProviders({"provideCounts"})
     *
     * @param array $params Array of parameters
     *
     * @return void
     *
     * @since 1.0.5
     */
    public function benchClean($params)
    {
        for ($i = 0; $i < $params['count']; $i++) {
            unset($this->tree[$i]);
        }
    }
}
