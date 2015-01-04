<?php
require_once './Runnable.php';
require_once './WriterThread.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = $argv[1];
$filename = "/tmp/".$id;
$sob = file_get_contents($filename);
$ob = unserialize($sob);
unlink($filename);
$ob->work();
