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

class Standards implements \Iterator
{
    /**
     * @var StandardInterface[]
     */
    protected $standards;

    /**
     * @param StandardInterface[] $standards
     */
    public function __construct(array $standards = array())
    {
        foreach ($standards as $standard) {
            $this->addStandard($standard);
        }
    }

    /**
     * @param StandardInterface $standard
     *
     * @return $this
     */
    public function addStandard(StandardInterface $standard)
    {
        $this->standards[$standard->getName()] = $standard;

        return $this;
    }

    /**
     * @param string|StandardInterface $standard
     *
     * @return bool
     */
    public function hasStandard($standard)
    {
        return isset($this->standards[$this->getStandardName($standard)]);
    }

    /**
     * @param string|StandardInterface $standard
     *
     * @return $this
     */
    public function removeStandard($standard)
    {
        if ($this->hasStandard($standard)) {
            unset($this->standards[$this->getStandardName($standard)]);
        }

        return $this;
    }

    /**
     * @param string|StandardInterface $standard
     *
     * @return StandardInterface|null
     */
    public function getStandard($standard)
    {
        if (!$this->hasStandard($standard)) {
            return null;
        }

        return $this->standards[$this->getStandardName($standard)];
    }

    /**
     * @return array|StandardInterface[]
     */
    public function getStandards()
    {
        return $this->standards;
    }

    /**
     * @param string|StandardInterface $standard
     *
     * @return string
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
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->standards);
    }

    /**
     * Checks if current position is valid
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
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->standards);
    }
}
