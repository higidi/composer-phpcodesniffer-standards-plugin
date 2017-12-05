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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\StandardInterface;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standards;
use PHPUnit\Framework\TestCase;

/**
 * Test case for "\Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standards".
 *
 * @covers \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standards
 */
class StandardsTest extends TestCase
{
    /**
     * @param string $name
     *
     * @return StandardInterface
     */
    protected function createStandardMock($name)
    {
        $standard = $this->prophesize(
            '\Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\StandardInterface'
        );
        $standard
            ->getName()
            ->willReturn($name);

        return $standard->reveal();
    }

    /**
     * @test
     */
    public function itImplementsTheIteratorInterface()
    {
        $sut = new Standards();

        $this->assertInstanceOf('\Iterator', $sut);
    }

    /**
     * @test
     */
    public function itHasAnEmptyArrayAsDefaultStandards()
    {
        $sut = new Standards();

        $standards = $sut->getStandards();

        $this->assertInternalType('array', $standards);
        $this->assertEmpty($standards);
    }

    /**
     * @test
     */
    public function itAcceptsStandardViaConstructor()
    {
        $standards = array(
            $this->createStandardMock('standard1'),
            $this->createStandardMock('standard2'),
            $this->createStandardMock('standard3'),
        );

        $sut = new Standards($standards);

        $this->assertSame($standards, $sut->getStandards());
    }

    /**
     * @test
     */
    public function itHoldsStandards()
    {
        $standards = array(
            $this->createStandardMock('standard1'),
            $this->createStandardMock('standard2'),
            $this->createStandardMock('standard3'),
        );

        $sut = new Standards();
        $sut->setStandards($standards);

        $this->assertSame($standards, $sut->getStandards());

        return $sut;
    }

    /**
     * @test
     * @depends itHoldsStandards
     *
     * @param Standards $sut
     */
    public function itCanAddStandardsToTheSet(Standards $sut)
    {
        $standards = $sut->getStandards();
        $newStandard = $this->createStandardMock('standard4');

        $this->assertSame($standards, $sut->getStandards());
        $sut->addStandard($newStandard);

        $expectedStandards = array_merge($standards, array($newStandard));
        $this->assertSame($expectedStandards, $sut->getStandards());
    }

    /**
     * @test
     * @depends itHoldsStandards
     *
     * @param Standards $sut
     */
    public function itCanRemoveStandardsFromTheSet(Standards $sut)
    {
        $standards = $sut->getStandards();
        $removeableStandard = array_shift($standards);

        $sut->removeStandard($removeableStandard);

        $this->assertSame($standards, $sut->getStandards());
    }

    /**
     * @return array
     */
    public function differentStandardIdentifierTypesDataProvider()
    {
        $standardName = 'blafoo';
        $standard = $this->createStandardMock($standardName);

        return array(
            'as_string' => array($standard, $standardName),
            'as_object' => array($standard, $standard)
        );
    }

    /**
     * @test
     * @dataProvider differentStandardIdentifierTypesDataProvider
     *
     * @param StandardInterface $standard
     * @param string|object $identifier
     */
    public function itReturnsWhetherItHoldsAStandardOrNot(StandardInterface $standard, $identifier)
    {
        $sut = new Standards();
        $this->assertFalse($sut->hasStandard($identifier));

        $sut->addStandard($standard);
        $this->assertTrue($sut->hasStandard($identifier));
    }

    /**
     * @test
     * @dataProvider differentStandardIdentifierTypesDataProvider
     *
     * @param StandardInterface $standard
     * @param string|object $identifier
     */
    public function itReturnsAStandardItHolds(StandardInterface $standard, $identifier)
    {
        $sut = new Standards();
        $this->assertNull($sut->getStandard($identifier));

        $sut->addStandard($standard);
        $this->assertSame($standard, $sut->getStandard($identifier));
    }

    /**
     * @test
     */
    public function itIsIteratable()
    {
        $standards = array(
            $this->createStandardMock('standard1'),
            $this->createStandardMock('standard2'),
            $this->createStandardMock('standard3'),
        );
        $iteratedStandards = array();

        $sut = new Standards($standards);
        foreach ($sut as $key => $standard) {
            $iteratedStandards[$key] = $standard;
        }

        $this->assertSame($standards, $iteratedStandards);
    }
}
