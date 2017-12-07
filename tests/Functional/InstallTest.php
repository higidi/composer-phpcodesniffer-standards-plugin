<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Functional;

class InstallTest extends ComposerTestCase
{
    /**
     * @test
     */
    public function itInstallPhpCodeSnifferStandards()
    {
        $this->writeComposerJson(
            [
                'higidi/testcase-simple-standard' => '1.0.0',
            ]
        );
        $srcPath = implode(
            DIRECTORY_SEPARATOR,
            [$this->getLocalPackagePath(), 'tests', 'fixtures', 'Composer', 'simple-standard', 'ruleset.xml']
        );
        $dstPath = implode(
            DIRECTORY_SEPARATOR,
            [
                $this->testWorkingDir,
                'vendor',
                'squizlabs',
                'php_codesniffer',
                'CodeSniffer',
                'Standards',
                'Simple-Standard',
                'ruleset.xml',
            ]
        );

        $exitCode = $this->applicationTester->run(['install']);

        $this->assertSame(0, $exitCode);
        $this->assertFileExists($dstPath);
        $this->assertFileEquals($srcPath, $dstPath);
    }
}
