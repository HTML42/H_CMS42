<?php

if (!defined('DIR_CMS')) {
    define('DIR_CMS', str_replace('/42/lib', '', str_replace('\\', '/', __DIR__)) . '/42/');
}

$UPDATE_NEED = null;

if (!defined('CMS_VERSION')) {
    $CMS_VERSION_FILE = DIR_CMS . 'version';
    define('CMS_VERSION', (is_file($CMS_VERSION_FILE) ? trim(file_get_contents($CMS_VERSION_FILE)) : NULL));
}


$baseurl = 'https://raw.githubusercontent.com/HTML42/H_CMS42/master/';
$baseurl_files = $baseurl . 'updater/files/';
