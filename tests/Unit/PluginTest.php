<?php

namespace Higidi\ComposerPhpCSStandardsPlugin\Tests\Unit;

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

use Higidi\ComposerPhpCSStandardsPlugin\Plugin;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * Test case for "\Higidi\ComposerPhpCSStandardsPlugin\Plugin".
 *
 * @covers \Higidi\ComposerPhpCSStandardsPlugin\Plugin
 */
class PluginTest extends TestCase
{
    /**
     * @test
     */
    public function itImplementsThePluginInterface()
    {
        $sut = new Plugin();

        $this->assertInstanceOf('\Composer\Plugin\PluginInterface', $sut);
    }

    /**
     * @test
     */
    public function itRegisteredThePhpCSStandardsInstallerToComposer()
    {
        $installationManager = $this->prophesize('\Composer\Installer\InstallationManager');
        $installationManager
            ->addInstaller(Argument::type('\Higidi\ComposerPhpCSStandardsPlugin\Installer'))
            ->shouldBeCalled();
        $downloadManager = $this->prophesize('\Composer\Downloader\DownloadManager');
        $config = $this->prophesize('\Composer\Config');
        $composer = $this->prophesize('\Composer\Composer');
        $composer
            ->getInstallationManager()
            ->willReturn($installationManager->reveal());
        $composer
            ->getDownloadManager()
            ->willReturn($downloadManager->reveal());
        $composer
            ->getConfig()
            ->willReturn($config->reveal());
        $io = $this->prophesize('\Composer\IO\IOInterface');

        $sut = new Plugin();

        $sut->activate($composer->reveal(), $io->reveal());
    }
}
