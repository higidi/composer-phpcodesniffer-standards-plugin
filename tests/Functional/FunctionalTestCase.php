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
class FunctionalTestCase extends TestCase
{
    /**
     * @var string
     */
    protected $oldHomeDirectory;

    /**
     * @var string
     */
    protected $oldWorkingDirectory;

    /**
     * @var string
     */
    protected $tempWorkingDir;

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
        $this->oldHomeDirectory = getenv('HOME');
        $this->tempWorkingDir = $this->createUniqueTmpDirectory();
        chdir($this->tempWorkingDir);
        putenv(sprintf('HOME=%s', $this->tempWorkingDir));
        putenv('COMPOSER_ROOT_VERSION=dev-master');
        $this->application = new Application();
        $this->applicationTester = new ApplicationTester($this->application);
    }

    /**
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();
        if ($this->tempWorkingDir) {
            $fs = new Filesystem();
            $fs->remove($this->tempWorkingDir);
        }
        chdir($this->oldWorkingDirectory);
        putenv(sprintf('HOME=%s', $this->oldHomeDirectory));
        putenv('COMPOSER_ROOT_VERSION');
        unset($this->oldWorkingDirectory, $this->workingDir);
    }

    /**
     * @return bool|string
     */
    protected function createUniqueTmpDirectory()
    {
        $attempts = 5;
        $root = sys_get_temp_dir();

        do {
            $unique = $root . DIRECTORY_SEPARATOR . uniqid('composer-test-' . rand(1000, 9000));

            $fs = new Filesystem();
            if (!file_exists($unique)) {
                $fs->mkdir($unique);

                return realpath($unique);
            }
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
     * @param array $data
     *
     * @return void
     */
    protected function writeComposerJson(array $data)
    {
        $defaultData = array(
            'repositories' => array(
                array(
                    'type' => 'path',
                    'url' => $this->getLocalPackagePath(),
                )
            ),
        );
        $data = array_merge_recursive($defaultData, $data);
        $jsonFile = $this->getComposerJsonFile();

        $jsonFile->write($data);
    }
}
