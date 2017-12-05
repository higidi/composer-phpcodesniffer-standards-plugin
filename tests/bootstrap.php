<?php

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

error_reporting(E_ALL);

if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
    date_default_timezone_set(@date_default_timezone_get());
}

function includeIfExists($file)
{
    return file_exists($file) ? include $file : false;
}

if (! $autoLoader = includeIfExists(__DIR__ . '/../vendor/autoload.php')) {
    echo 'You must set up the project dependencies, run the following command from the project root:' . PHP_EOL .
        'php composer.phar install' . PHP_EOL;
    exit(1);
}

return $autoLoader;
