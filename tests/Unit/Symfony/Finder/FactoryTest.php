<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Unit\Symfony\Finder;

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

use Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Test case for class \Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory
 *
 * @covers \Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory
 */
class FactoryTest extends TestCase
{
    public function testCreateFinder()
    {
        $factory = new Factory();
        $finder = $factory->create();

        $this->assertInstanceOf('Symfony\Component\Finder\Finder', $finder);
    }
}
