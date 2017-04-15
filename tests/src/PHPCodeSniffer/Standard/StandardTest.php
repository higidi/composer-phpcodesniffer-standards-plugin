<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\PHPCodeSniffer\Standard;

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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Standard;

/**
 * Test case for class \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Standard
 */
class StandardTest extends \PHPUnit_Framework_TestCase
{
    public function testStandard()
    {
        $name = 'Standard1';
        $path = implode(
            DIRECTORY_SEPARATOR,
            array(__DIR__, '..', '..', '..', 'Fixtures', 'Standards', $name)
        );
        $ruleSetXmlPath = $path . DIRECTORY_SEPARATOR . 'ruleset.xml';

        $standard = new Standard($path);

        $this->assertSame($name, $standard->getName(), 'getName');
        $this->assertSame($path, $standard->getPath(), 'getPath');
        $this->assertSame($ruleSetXmlPath, $standard->getRuleSetXmlPath(), 'getRuleSetXmlPath');
    }

    public function testIfInvalidStandardExceptionIsThrown()
    {
        $this->expectException(
            'Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Exception\InvalidStandardException'
        );

        $path = implode(
            DIRECTORY_SEPARATOR,
            array(__DIR__, '..', '..', '..', 'Fixtures', 'Standards', 'InvalidStandard')
        );

        new Standard($path);
    }
}
