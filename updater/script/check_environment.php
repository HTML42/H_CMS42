<?php

$parent_folder = scandir(dirname(__DIR__));
if (substr(__DIR__, -4) == 'dist' && in_array('demo', $parent_folder) && in_array('updater', $parent_folder)) {
    exit('<div>You are currently accessing to a source-File.</div>');
}


if (!defined('CDN_VERSION')) {
    $_cdn_version = _get($baseurl_files . 'version');
    define('CDN_VERSION', is_string($_cdn_version) ? $_cdn_version : null);
}

$UPDATE_NEED = false;

if (!is_dir(DIR_CMS)) {
    mkdir(DIR_CMS);
    $UPDATE_NEED = true;
}

if (!is_string(CMS_VERSION) || strlen(CMS_VERSION) < 1) {
    $UPDATE_NEED = true;
} else if (CMS_VERSION != CDN_VERSION) {
    $UPDATE_NEED = true;
}


