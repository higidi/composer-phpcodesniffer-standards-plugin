<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Functional;

use Composer\Console\Application;
use Composer\Factory;
use Composer\Json\JsonFile;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base functional test case.
 */
class ComposerTestCase extends TestCase
{
    /**
     * @var string
     */
    protected $oldWorkingDirectory;

    /**
     * @var string
     */
    protected $testWorkingDir;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var ApplicationTester
     */
    protected $applicationTester;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->oldWorkingDirectory = getcwd();
        $this->testWorkingDir = $this->createUniqueTmpDirectory();
        chdir($this->testWorkingDir);
        $this->application = new Application();
        $this->application->setAutoExit(false);
        $this->applicationTester = new ApplicationTester($this->application);
    }

    /**
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();
        chdir($this->oldWorkingDirectory);
        if ($this->testWorkingDir) {
            $fs = new Filesystem();
            $fs->remove($this->testWorkingDir);
        }
        unset($this->oldWorkingDirectory, $this->testWorkingDir);
    }

    /**
     * @return string
     */
    protected function createUniqueTmpDirectory()
    {
        $attempts = 5;
        $randomize = false;
        $root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'composer-test';
        $name = $this->getName();
        $folderName = preg_replace('/[^a-zA-Z0-9\-\._]/', '', $name);

        do {
            $unique = $root . DIRECTORY_SEPARATOR . $folderName;
            if ($randomize) {
                $unique .= '-' . uniqid(rand(1000, 9000));
            }

            $fs = new Filesystem();
            if (! file_exists($unique)) {
                $fs->mkdir($unique);

                return realpath($unique);
            }
            $randomize = true;
        } while (--$attempts);

        throw new \RuntimeException('Failed to create a unique temporary directory.');
    }

    /**
     * @return string
     */
    protected function getComposerJsonFilePath()
    {
        return Factory::getComposerFile();
    }

    /**
     * @return JsonFile
     */
    protected function getComposerJsonFile()
    {
        $jsonFile = new JsonFile($this->getComposerJsonFilePath());

        return $jsonFile;
    }

    /**
     * @return bool|string
     */
    protected function getLocalPackagePath()
    {
        return realpath(__DIR__ . '/../../');
    }

    /**
     * @return string
     */
    protected function getLocalPackageComposerPath()
    {
        return $this->getLocalPackagePath() . DIRECTORY_SEPARATOR . 'composer.json';
    }

    /**
     * @return mixed
     */
    protected function getLocalPackageComposerPackage()
    {
        $jsonFile = new JsonFile($this->getLocalPackageComposerPath());

        $json = $jsonFile->read();
        if (! is_array($json)) {
            throw new \RuntimeException();
        }
        $json['version'] = 'dev-workingDir';
        $json['dist'] = [
            'type' => 'path',
            'url' => $this->getLocalPackagePath(),
        ];

        return $json;
    }

    /**
     * @param array $requireDev
     * @param array $require
     * @param array $additionalJson
     *
     * @return void
     */
    protected function writeComposerJson(array $requireDev, array $require = [], array $additionalJson = [])
    {
        $defaultJson = [
            'repositories' => [
                [
                    'type' => 'package',
                    'package' => $this->getLocalPackageComposerPackage(),
                ],
                [
                    'type' => 'path',
                    'url' => implode(
                        DIRECTORY_SEPARATOR,
                        [$this->getLocalPackagePath(), 'tests', 'Fixtures', 'Composer', '*']
                    ),
                ],
            ],
            'minimum-stability' => 'dev',
            'config' => [
                'bin-dir' => 'bin',
                'vendor-dir' => 'vendor',
            ],
            'require-dev' => [
                'squizlabs/php_codesniffer' => '*',
            ],
        ];
        $json = [
            'require-dev' => $requireDev,
        ];
        if (count($require) > 0) {
            $json['require'] = $require;
        }
        $json = array_replace_recursive($defaultJson, $json);
        if (count($additionalJson) > 0) {
            $json = array_replace_recursive($json, $additionalJson);
        }
        $jsonFile = $this->getComposerJsonFile();

        $jsonFile->write($json);
    }
}
