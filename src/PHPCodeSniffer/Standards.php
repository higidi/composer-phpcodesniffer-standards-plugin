<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer;

class Standards implements \Iterator
{

    /**
     * @var array|Standard[]
     */
    protected $standards;

    /**
     * @param array $standards
     */
    public function __construct(array $standards = array())
    {
        foreach ($standards as $standard) {
            $this->addStandard($standard);
        }
    }

    /**
     * @param Standard $standard
     * @return $this
     */
    public function addStandard(Standard $standard)
    {
        $this->standards[$standard->getName()] = $standard;

        return $this;
    }

    /**
     * @param string|Standard $standard
     * @return bool
     */
    public function hasStandard($standard)
    {
        return isset($this->standards[$this->getStandardName($standard)]);
    }

    /**
     * @param string|Standard $standard
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
     * @param string|Standard $standard
     * @return Standard|null
     */
    public function getStandard($standard)
    {
        if (!$this->hasStandard($standard)) {
            return null;
        }

        return $this->standards[$this->getStandardName($standard)];
    }

    /**
     * @return array|Standard[]
     */
    public function getStandards()
    {
        return $this->standards;
    }

    /**
     * @param string|Standard $standard
     * @return string
     */
    protected function getStandardName($standard) {
        if ($standard instanceof Standard) {
            $standard = $standard->getName();
        } else {
            $standard = (string)$standard;
        }

        return $standard;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Standard Can return any type.
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