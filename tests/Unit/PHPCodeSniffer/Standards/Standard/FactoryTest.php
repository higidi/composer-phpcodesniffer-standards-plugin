<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Unit\PHPCodeSniffer\Standards\Standard;

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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Test case for class \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Factory
 *
 * @covers \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Factory
 */
class FactoryTest extends TestCase
{
    /**
     * @var Factory
     */
    protected $classUnderTesting;

    protected function setUp()
    {
        parent::setUp();
        $this->classUnderTesting = new Factory();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->classUnderTesting);
    }

    public function testCreateStandard()
    {
        $path = implode(
            DIRECTORY_SEPARATOR,
            array(__DIR__, '..', '..', '..', '..', 'Fixtures', 'Standards', 'Standard1')
        );
        $standard = $this->classUnderTesting->create($path);

        $this->assertInstanceOf(
            'Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Standard',
            $standard
        );
    }
}
