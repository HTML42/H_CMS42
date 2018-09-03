<?php

include 'functions.php';

if (!isset($script_root)) {
    $script_root = dirname(__FILE__);
}

ensure_ending_slash($script_root);

define('ROOT', str_replace('\\', '/', $script_root));
define('CMS42', dirname(dirname(__FILE__)) . '/');
define('UPDATER', CMS42 . 'updater/');
define('UPDATER_SCRIPT', UPDATER . 'script/');
define('UPDATER_FILES', UPDATER . 'files/');
define('DIST', CMS42 . 'dist/');
