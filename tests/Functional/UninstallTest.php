<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Functional;

class UninstallTest extends ComposerTestCase
{
    /**
     * @test
     */
    public function itUninstallPhpCodeSnifferStandards()
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

        $exitCode = $this->applicationTester->run(
            ['command' => 'remove', 'packages' => ['higidi/testcase-simple-standard']]
        );

        $this->assertSame(0, $exitCode);
        $this->assertFileNotExists($dstPath);
    }
}
