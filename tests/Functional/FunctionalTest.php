<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Functional;

class FunctionalTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function itInstallPhpCodeSnifferStandards()
    {
        $this->writeComposerJson(
            array(
                'require-dev' => array(
                    'higidi/testcase-simple-standard' => '1.0.0',
                )
            )
        );
        $srcPath = implode(
            DIRECTORY_SEPARATOR,
            array($this->getLocalPackagePath(), 'tests', 'fixtures', 'Composer', 'simple-standard', 'ruleset.xml')
        );
        $dstPath = implode(
            DIRECTORY_SEPARATOR,
            array(
                $this->tempWorkingDir,
                'vendor',
                'squizlabs',
                'php_codesniffer',
                'CodeSniffer',
                'Standards',
                'Simple-Standard',
                'ruleset.xml'
            )
        );

        $exitCode = $this->applicationTester->run(array('install'));

        $this->assertSame(0, $exitCode);
        $this->assertFileExists($dstPath);
        $this->assertFileEquals($srcPath, $dstPath);
    }

    /**
     * @test
     */
    public function itUninstallPhpCodeSnifferStandards()
    {
        $this->writeComposerJson(
            array(
                'require-dev' => array(
                    'higidi/testcase-simple-standard' => '1.0.0',
                )
            )
        );
        $srcPath = implode(
            DIRECTORY_SEPARATOR,
            array($this->getLocalPackagePath(), 'tests', 'fixtures', 'Composer', 'simple-standard', 'ruleset.xml')
        );
        $dstPath = implode(
            DIRECTORY_SEPARATOR,
            array(
                $this->tempWorkingDir,
                'vendor',
                'squizlabs',
                'php_codesniffer',
                'CodeSniffer',
                'Standards',
                'Simple-Standard',
                'ruleset.xml'
            )
        );

        $exitCode = $this->applicationTester->run(array('install'));

        $this->assertSame(0, $exitCode);
        $this->assertFileExists($dstPath);
        $this->assertFileEquals($srcPath, $dstPath);

        $exitCode = $this->applicationTester->run(
            array('command' => 'remove', 'packages' => array('higidi/testcase-simple-standard'))
        );

        $this->assertSame(0, $exitCode);
        $this->assertFileNotExists($dstPath);
    }
}
