<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard;

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
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $pathParts = explode(DIRECTORY_SEPARATOR, $path);
        $this->name = array_pop($pathParts);
        $this->path = $path;
        $this->ruleSetXmlPath = $path . DIRECTORY_SEPARATOR . 'ruleset.xml';
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
