<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Unit\PHPCodeSniffer\Standards;

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
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Factory as StandardFactory;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Standard;

/**
 * Test case for class \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\StandardsFactory
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    protected $classUnderTesting;

    /**
     * @var StandardFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $standardFactoryMock;

    protected function setUp()
    {
        parent::setUp();
        $this->standardFactoryMock = $this->getMockBuilder(
            'Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Factory'
        )->getMock();
        $this->standardFactoryMock
            ->method('create')
            ->willReturn(
                $this->getMockBuilder('Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Standard')
                    ->disableOriginalConstructor()
                    ->getMock()
            );

        $this->classUnderTesting = new Factory($this->standardFactoryMock);
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->standardFactoryMock);
        unset($this->classUnderTesting);
    }

    public function testCreateStandard()
    {
        $paths = array();
        $paths[] = implode(
            DIRECTORY_SEPARATOR,
            array(__DIR__, '..', '..', '..', '..', 'Fixtures', 'Standards', 'Standard1')
        );
        $this->standardFactoryMock
            ->expects($this->exactly(count($paths)))
            ->method('create')
            ->withConsecutive($paths);

        $standards = $this->classUnderTesting->create($paths);

        $this->assertInstanceOf('Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standards', $standards);
    }
}
