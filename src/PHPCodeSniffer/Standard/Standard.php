<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard;

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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Exception\InvalidStandardException;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Exception\StandardPathAccessDeniedException;

/**
 * Class for PHPCodeSniffer standards.
 */
class Standard implements StandardInterface
{
    const RULESET_FILENAME = 'ruleset.xml';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $ruleSetXmlPath;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        if (!is_readable($path)) {
            throw new StandardPathAccessDeniedException(
                sprintf('Standard path "%s" is not accessable.', $path)
            );
        }
        $this->path = realpath($path);
        $this->name = basename($this->path);
        $this->ruleSetXmlPath = $path . DIRECTORY_SEPARATOR . 'ruleset.xml';

        if (!is_readable($this->ruleSetXmlPath)) {
            throw new InvalidStandardException(
                sprintf('Standard "%s" doesn\'t contain a "ruleset.xml" file.', $this->name)
            );
        }
    }

    /**
     * Get the name of the PHPCodeSniffer standard.
     *
     * @return string The name of the PHPCodeSniffer standard.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the path to PHPCodeSniffer standard.
     *
     * @return string The path to the PHPCodeSniffer standard.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the path to the PHPCodeSniffer ruleset.xml file.
     *
     * @return string The path to the PHPCodeSniffer ruleset.xml file.
     */
    public function getRuleSetXmlPath()
    {
        return $this->ruleSetXmlPath;
    }
}
