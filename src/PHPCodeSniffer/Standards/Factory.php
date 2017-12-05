<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards;

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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Factory as StandardFactory;

/**
 * Standards class factory.
 */
class Factory
{
    /**
     * @var StandardFactory
     */
    protected $standardFactory;

    /**
     * @param StandardFactory|null $standardFactory
     */
    public function __construct(StandardFactory $standardFactory = null)
    {
        $this->standardFactory = $standardFactory ?: new StandardFactory();
    }

    /**
     * Creates PHPCodeSniffer standards from paths.
     *
     * @param array $paths Paths with PHPCodeSniffer standard paths.
     *
     * @return Standards PHPCodeSniffer standards object.
     */
    public function create(array $paths)
    {
        $standards = new Standards();
        foreach ($paths as $path) {
            $standards->addStandard($this->standardFactory->create($path));
        }

        return $standards;
    }
}
