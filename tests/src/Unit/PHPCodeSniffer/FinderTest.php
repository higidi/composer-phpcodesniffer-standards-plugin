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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Finder;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Factory;
use Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory as SymfonyFinderFactory;
use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * Test case for class \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Finder
 */
class FinderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Finder
     */
    protected $classUnderTesting;

    /**
     * @var SymfonyFinderFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $symfonyFinderFactoryMock;

    /**
     * @var SymfonyFinder|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $symfonyFinderMock;

    /**
     * @var Factory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $standardsFactoryMock;

    protected function setUp()
    {
        parent::setUp();
        $this->symfonyFinderFactoryMock = $this->getMock(
            'Higidi\ComposerPhpCSStandardsPlugin\Symfony\Finder\Factory'
        );
        $this->symfonyFinderMock = $this->getMock('Symfony\Component\Finder\Finder');
        $this->symfonyFinderFactoryMock
            ->method('create')
            ->willReturn($this->symfonyFinderMock);
        $this->standardsFactoryMock = $this->getMock(
            'Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Factory',
            array(),
            array(),
            '',
            false
        );
        $this->classUnderTesting = new Finder($this->symfonyFinderFactoryMock, $this->standardsFactoryMock);
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->classUnderTesting);
        unset($this->standardsFactoryMock);
    }

    public function testFinder()
    {
        $path = realpath(implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '..', '..', 'Fixtures', 'Standards')));
        $expected = array(
            $path . DIRECTORY_SEPARATOR . 'Standard1',
        );

        $fluentMethods = array('in', 'files', 'name', 'sortByName');
        foreach ($fluentMethods as $fluentMethod) {
            $this->symfonyFinderMock
                ->method($fluentMethod)
                ->willReturn($this->symfonyFinderMock);
        }

        $splFileInfoMock = $this->getMock(
            'Symfony\Component\Finder\SplFileInfo',
            array(),
            array(null, null, null)
        );
        $splFileInfoMock
            ->expects($this->once())
            ->method('getPath')
            ->willReturn($path . DIRECTORY_SEPARATOR . 'Standard1');
        $finderIterator = new \ArrayIterator(
            array(
                $splFileInfoMock,
            )
        );
        $this->symfonyFinderMock
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn($finderIterator);
        $this->standardsFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($expected);
        $this->classUnderTesting->in($path);
    }
}
