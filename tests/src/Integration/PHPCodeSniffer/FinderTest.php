<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Integration\PHPCodeSniffer\Standard;

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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Finder;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\StandardsFactory;

/**
 * Integration test case for class \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Finder
 */
class FinderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Finder
     */
    protected $fixture;

    /**
     * @var StandardsFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $standardsFactoryMock;

    protected function setUp()
    {
        parent::setUp();
        $this->standardsFactoryMock = $this->getMock(
            'Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\StandardsFactory',
            array(),
            array(),
            '',
            false
        );
        $this->fixture = new Finder(null, $this->standardsFactoryMock);
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->fixture);
        unset($this->standardsFactoryMock);
    }

    public function testFinder()
    {
        $path = realpath(implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '..', 'Fixtures', 'Standards')));
        $expected = array(
            $path . DIRECTORY_SEPARATOR . 'Standard1',
            $path . DIRECTORY_SEPARATOR . 'Standard2',
            $path . DIRECTORY_SEPARATOR . 'Standard3',
        );

        $this->standardsFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($expected);
        $this->fixture->in($path);
    }
}
