<?php

define('DIR_CMS', __DIR__ . '/42/');

$UPDATE_NEED = null;

$CMS_VERSION_FILE = DIR_CMS . 'version';
define('CMS_VERSION', (is_file($CMS_VERSION_FILE) ? trim(file_get_contents($CMS_VERSION_FILE)) : NULL));

$parent_folder = scandir(dirname(__DIR__));
if (substr(__DIR__, -4) == 'dist' && in_array('demo', $parent_folder) && in_array('updater', $parent_folder)) {
    exit('<div>You are currently accessing to a source-File.</div>');
}

if (!is_dir(DIR_CMS)) {
    mkdir(DIR_CMS);
    $UPDATE_NEED = true;
}

if (!is_string(CMS_VERSION) || strlen(CMS_VERSION) < 1) {
    $UPDATE_NEED = true;
}

echo 'CMS-Version: ' . CMS_VERSION;
echo '<br/>';
echo 'Update needed: ' . strval($UPDATE_NEED);