<?php

error_reporting(E_ALL);

if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
    date_default_timezone_set(@date_default_timezone_get());
}

function includeIfExists($file)
{
    return file_exists($file) ? include $file : false;
}

if (!$autoLoader = includeIfExists(__DIR__ . '/../vendor/autoload.php')) {
    echo 'You must set up the project dependencies, run the following command from the project root:' . PHP_EOL .
        'php composer.phar install' . PHP_EOL;
    exit(1);
}

return $autoLoader;
