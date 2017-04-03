<?php

namespace Higidi\ComposerPhpCSStandardsPlugin;

use Composer\Composer;
use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;

class Installer extends LibraryInstaller
{
    const TYPE = 'php-codesniffer-standards';

    /**
     * Initializes library installer.
     *
     * @param IOInterface     $io
     * @param Composer        $composer
     * @param string          $type
     * @param Filesystem      $filesystem
     * @param BinaryInstaller $binaryInstaller
     */
    public function __construct(
        IOInterface $io,
        Composer $composer,
        $type = self::TYPE,
        Filesystem $filesystem = null,
        BinaryInstaller $binaryInstaller = null
    ) {
        parent::__construct($io, $composer, $type, $filesystem, $binaryInstaller);
    }
}
