<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standard;

class Standard
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getRuleSetXmlPath()
    {
        return $this->ruleSetXmlPath;
    }
}
