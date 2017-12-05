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

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\StandardInterface;

/**
 * Class holds a set of PHPCodeSniffer standards.
 */
class Standards implements \Iterator
{
    /**
     * @var StandardInterface[]
     */
    protected $standards;

    /**
     * @param StandardInterface[] $standards
     */
    public function __construct(array $standards = [])
    {
        $this->setStandards($standards);
    }

    /**
     * Add a single standard to set.
     *
     * @param StandardInterface $standard The standard to add
     *
     * @return $this Fluent interface
     */
    public function addStandard(StandardInterface $standard)
    {
        $this->standards[$standard->getName()] = $standard;

        return $this;
    }

    /**
     * Check whether set holds the given standard.
     *
     * @param string|StandardInterface $standard The standard to check
     *
     * @return bool True if sets hold the standard, otherwise false
     */
    public function hasStandard($standard)
    {
        return isset($this->standards[$this->getStandardName($standard)]);
    }

    /**
     * Remove a single standard from the set.
     *
     * @param string|StandardInterface $standard The standard to remove
     *
     * @return $this Fluent interface
     */
    public function removeStandard($standard)
    {
        if ($this->hasStandard($standard)) {
            unset($this->standards[$this->getStandardName($standard)]);
        }

        return $this;
    }

    /**
     * Get a single standard.
     *
     * @param string|StandardInterface $standard The standard to get
     *
     * @return StandardInterface|null Return the standard or null if not exist
     */
    public function getStandard($standard)
    {
        if (! $this->hasStandard($standard)) {
            return null;
        }

        return $this->standards[$this->getStandardName($standard)];
    }

    /**
     * Get all standards hold by this set.
     *
     * @return array|StandardInterface[] Array of standards
     */
    public function getStandards()
    {
        return array_values($this->standards);
    }

    /**
     * Set standards hold by this set.
     *
     * @param StandardInterface[] $standards Array with standards to set
     *
     * @return $this Fluent interface
     */
    public function setStandards(array $standards)
    {
        $this->standards = [];
        foreach ($standards as $standard) {
            $this->addStandard($standard);
        }

        return $this;
    }

    /**
     * Extract the name of the given standard.
     *
     * @param string|StandardInterface $standard The standard get name from
     *
     * @return string The standard name
     */
    protected function getStandardName($standard)
    {
        if ($standard instanceof StandardInterface) {
            return $standard->getName();
        }

        return (string)$standard;
    }

    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return StandardInterface Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->standards);
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->standards);
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        $key = key($this->standards);

        return array_search($key, array_keys($this->standards));
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return current($this->standards) !== false;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->standards);
    }
}
