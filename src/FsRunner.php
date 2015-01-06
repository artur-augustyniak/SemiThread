<?php

namespace Aaugustyniak\SemiThread;

$scriptPath = __DIR__;
$autoloaderPath = '../vendor/autoload.php';
$realAutoloaderPath = realpath($scriptPath . DIRECTORY_SEPARATOR . $autoloaderPath);
require_once $realAutoloaderPath;

$serializedId = $argv[1];
$serializedFolderPath = $argv[2];
$serializedPath = $serializedFolderPath . DIRECTORY_SEPARATOR . $serializedId;
$serializedRunnable = \file_get_contents($serializedPath);
$runnable = \unserialize($serializedRunnable);
unlink($serializedPath);
$runnable->run();
unset($runnable);
exit(0);