<?php

namespace Higidi\ComposerPhpCSStandardsPlugin;

/*
 * Copyright (C) 2017  Daniel Hürtgen <daniel@higidi.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

use Composer\Composer;
use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Finder;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standard\Standard;
use Higidi\ComposerPhpCSStandardsPlugin\PHPCodeSniffer\Standards\Standards;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class Installer extends LibraryInstaller
{
    const TYPE = 'phpcodesniffer-standard';

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * Initializes library installer.
     *
     * @param IOInterface $io
     * @param Composer $composer
     * @param string $type
     * @param Filesystem $filesystem
     * @param BinaryInstaller $binaryInstaller
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function __construct(
        IOInterface $io,
        Composer $composer,
        $type = self::TYPE,
        Filesystem $filesystem = null,
        BinaryInstaller $binaryInstaller = null,
        Finder $finder = null
    ) {
        parent::__construct($io, $composer, $type, $filesystem, $binaryInstaller);
        $this->finder = $finder ?: new Finder();
    }

    /**
     * {@inheritDoc}
     */
    public function isInstalled(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if (!parent::isInstalled($repo, $package)) {
            return false;
        }
        $srcStandards = $this->getSourceStandards($package);
        $dstStandards = $this->getDestinationStandards($repo);

        foreach ($srcStandards as $srcStandard) {
            if (!$dstStandards->hasStandard($srcStandard)
                || !$this->compareStandards($srcStandard, $dstStandards->getStandard($srcStandard))
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);
        $this->installStandards($repo, $package);
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);
        $this->installStandards($repo, $target, $initial ? false : true);
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if (!$repo->hasPackage($package)) {
            throw new \InvalidArgumentException('Package is not installed: ' . $package);
        }
        $this->removeStandards($repo, $package);
        parent::uninstall($repo, $package);
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     * @param bool $override
     * @return void
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    protected function installStandards(
        InstalledRepositoryInterface $repo,
        PackageInterface $package,
        $override = false
    ) {
        $filesystem = new SymfonyFilesystem();
        $srcStandards = $this->getSourceStandards($package);
        $dstStdBasePath = $this->getPHPCodeSnifferStandardsBasePath($repo);
        $this->io->writeError('    Installing PHP-CodeSniffer Standards:', false);
        foreach ($srcStandards as $srcStandard) {
            $this->io->writeError(sprintf(' <info>%s</info>', $srcStandard->getName()));
            $srcPath = $srcStandard->getPath();
            $dstPath = $dstStdBasePath . DIRECTORY_SEPARATOR . $srcStandard->getName();
            $filesystem->mirror($srcPath, $dstPath, null, array('override' => $override));
        }
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     * @return void
     */
    protected function removeStandards(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $srcStandards = $this->getSourceStandards($package);
        $dstStandards = $this->getDestinationStandards($repo);
        $this->io->writeError('    Removing PHP-CodeSniffer Standards:', false);
        foreach ($srcStandards as $srcStandard) {
            if (!$dstStandards->hasStandard($srcStandard)) {
                continue;
            }
            $this->io->writeError(sprintf(' <info>%s</info>', $srcStandard->getName()));
            $dstStandard = $dstStandards->getStandard($srcStandard);

            $this->filesystem->removeDirectory($dstStandard->getPath());
        }
    }

    /**
     * Get source (provided by the composer package) standards for package.
     *
     * @param PackageInterface $package
     * @return Standards
     */
    protected function getSourceStandards(PackageInterface $package)
    {
        $basePath = $this->getInstallPath($package);

        return $this->findStandards($basePath);
    }

    /**
     * Get destination (provided by PHPCodeSniffer) standards.
     *
     * @param InstalledRepositoryInterface $repo
     * @return Standards
     */
    protected function getDestinationStandards(InstalledRepositoryInterface $repo)
    {
        $basePath = $this->getPHPCodeSnifferInstallPath($repo);

        return $this->findStandards($basePath);
    }

    /**
     * @param Standard $source
     * @param Standard $destination
     * @return bool
     */
    protected function compareStandards(Standard $source, Standard $destination)
    {
        return $source->getName() === $destination->getName()
            && sha1_file($source->getRuleSetXmlPath()) === sha1_file($destination->getRuleSetXmlPath());
    }

    /**
     * @param string $basePath
     * @return Standards
     */
    protected function findStandards($basePath)
    {
        return $this->finder->in($basePath);
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @return string
     */
    protected function getPHPCodeSnifferStandardsBasePath(InstalledRepositoryInterface $repo)
    {
        $package = $this->getPHPCodeSnifferPackage($repo);
        $basePath = $this->getInstallPath($package);

        return $basePath . DIRECTORY_SEPARATOR . 'CodeSniffer' . DIRECTORY_SEPARATOR . 'Standards';
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @return PackageInterface
     */
    protected function getPHPCodeSnifferPackage(InstalledRepositoryInterface $repo)
    {
        $packageKey = 'squizlabs/php_codesniffer';
        $package = $repo->findPackage($packageKey, '*');
        if (!$package) {
            throw new \RuntimeException(sprintf('Package "%s" not installed.', $packageKey));
        }

        return $package;
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @return string
     */
    protected function getPHPCodeSnifferInstallPath(InstalledRepositoryInterface $repo)
    {
        return $this->getInstallPath($this->getPHPCodeSnifferPackage($repo));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        $secondaryTypes = array('phpcodesniffer-standards');
        $deprecatedTypes = array('php-codesniffer-standards');

        return parent::supports($packageType)
            || in_array($packageType, array_merge($secondaryTypes, $deprecatedTypes));
    }
}
