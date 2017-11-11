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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Standard;

/**
 * Test case for class \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Standard
 */
class StandardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider differentStandards
     */
    public function testStandard($standardName, $expectedName)
    {
        $path = implode(
            DIRECTORY_SEPARATOR,
            array(__DIR__, '..', '..', '..', '..', '..', 'Fixtures', 'Standards', $standardName)
        );
        $ruleSetXmlPath = $path . DIRECTORY_SEPARATOR . 'ruleset.xml';

        $standard = new Standard($path);

        $this->assertSame(
            $expectedName,
            $standard->getName(),
            'The standard instance did not return the expected name.'
        );
        $this->assertSame(
            realpath($path),
            $standard->getPath(),
            'The standard instance did not return the expected path value.'
        );
        $this->assertSame(
            $ruleSetXmlPath,
            $standard->getRuleSetXmlPath(),
            'The standard instance did not return the expected ruleset.xml path value.'
        );
    }

    public function differentStandards()
    {
        return array(
            'No Ruleset' => array(
                'Standard1',
                'Standard1',
            ),
            'Ruleset with name' => array(
                'standard_with_ruleset',
                'CustomStandard',
            ),
            'Ruleset without name' => array(
                'standard_with_ruleset_without_name',
                'standard_with_ruleset_without_name',
            ),
        );
    }

    /**
     * @expectedException \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Exception\StandardPathAccessDeniedException
     */
    public function testIfStandardPathAccessDeniedExceptionIsThrown()
    {
        new Standard('foo');
    }

    /**
     * @expectedException \Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Exception\InvalidStandardException
     */
    public function testIfInvalidStandardExceptionIsThrown()
    {
        $path = implode(
            DIRECTORY_SEPARATOR,
            array(__DIR__, '..', '..', '..', '..', '..', 'Fixtures', 'Standards', 'InvalidStandard')
        );

        new Standard($path);
    }
}
