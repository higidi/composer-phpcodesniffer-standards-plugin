<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer;

/*
 * Copyright (C) 2017  Daniel Hürtgen <daniel@higidi.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Factory;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standards;
use Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory as FinderFactory;
use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * Standards finder class.
 */
class Finder
{
    /**
     * @var FinderFactory
     */
    protected $finderFactory;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @param FinderFactory|null $finderFactory
     * @param Factory|null $factory
     */
    public function __construct(FinderFactory $finderFactory = null, Factory $factory = null)
    {
        $this->finderFactory = $finderFactory ?: new FinderFactory();
        $this->factory = $factory ?: new Factory();
    }

    /**
     * Find and return PHPCodeSniffer standards.
     *
     * @param string $path
     *
     * @return Standards
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function in($path)
    {
        $finder = $this->getSymfonyFinder()
            ->in($path)
            ->files()
            ->name('ruleset.xml')
            ->sortByName();
        $paths = iterator_to_array($finder, false);
        $paths = array_map(
            function (\SplFileInfo $file) {
                return $file->getPath();
            },
            $paths
        );

        return $this->createStandardsFromPaths($paths);
    }

    /**
     * Creates new symfony finder instance.
     *
     * @return SymfonyFinder
     */
    protected function getSymfonyFinder()
    {
        return $this->finderFactory->create();
    }

    /**
     * Creates PHPCodeSniffer standards from paths.
     *
     * @param array $path
     *
     * @return Standards
     */
    protected function createStandardsFromPaths(array $paths)
    {
        return $this->factory->create($paths);
    }
}
