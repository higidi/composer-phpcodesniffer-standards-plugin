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

use Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory as FinderFactory;
use Symfony\Component\Finder\Finder as SymfonyFinder;
use Symfony\Component\Finder\SplFileInfo;

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
     * @var StandardsFactory
     */
    protected $factory;

    /**
     * @param FinderFactory|null $finderFactory
     * @param StandardsFactory|null $factory
     */
    public function __construct(FinderFactory $finderFactory = null, StandardsFactory $factory = null)
    {
        $this->finderFactory = $finderFactory ?: new FinderFactory();
        $this->factory = $factory ?: new StandardsFactory();
    }

    /**
     * Find and return PHPCodeSniffer standards.
     *
     * @param string $path
     * @return Standards
     */
    public function in($path)
    {
        $finder = $this->getSymfonyFinder()
            ->in($path)
            ->files()
            ->name('ruleset.xml');
        $paths = iterator_to_array($finder, false);
        $paths = array_map(
            function (SplFileInfo $file) {
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
     * @return Standards
     */
    protected function createStandardsFromPaths(array $paths)
    {
        return $this->factory->create($paths);
    }
}
