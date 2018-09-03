<?php

define('DIR_CMS', __DIR__ . '/42/');

$UPDATE_NEED = null;

$CMS_VERSION_FILE = DIR_CMS . 'version';
define('CMS_VERSION', (is_file($CMS_VERSION_FILE) ? trim(file_get_contents($CMS_VERSION_FILE)) : NULL));


$baseurl = 'https://raw.githubusercontent.com/HTML42/H_CMS42/master/';
$baseurl_files = $baseurl . 'updater/files/';
