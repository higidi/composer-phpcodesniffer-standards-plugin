<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard;

use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Exception\InvalidStandardException;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard\Exception\StandardPathAccessDeniedException;

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
     * @param $path
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
