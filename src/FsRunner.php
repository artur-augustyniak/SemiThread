<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Artur Augustyniak
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Aaugustyniak\SemiThread;

/**
 *
 * Unserialize and run user job
 *
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */

$serializedId = $argv[1];
$serializedFolderPath = $argv[2];
$devMode = intval($argv[3]);


$scriptPath = __DIR__;

if ($devMode) {
    $loaderPath = '../vendor/autoload.php';
} else {
    $loaderPath = '../../../autoload.php';
}

$realLoaderPath = realpath($scriptPath . DIRECTORY_SEPARATOR . $loaderPath);
require_once $realLoaderPath;


$serializedPath = $serializedFolderPath . DIRECTORY_SEPARATOR . $serializedId;
$serializedRunnable = \file_get_contents($serializedPath);
$semiThread = \unserialize($serializedRunnable);
unlink($serializedPath);
$semiThread->run();
unset($semiThread);
exit(0);