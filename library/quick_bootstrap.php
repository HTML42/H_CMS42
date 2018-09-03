<?php

include 'functions.php';

if (!isset($script_root)) {
    $script_root = __DIR__;
}

ensure_ending_slash($script_root);

define('ROOT', str_replace('\\', '/', $script_root));
define('CMS42', dirname(__DIR__) . '/');
define('UPDATER', CMS42 . 'updater/');
define('UPDATER_SCRIPT', UPDATER . 'script/');
define('UPDATER_FILES', UPDATER . 'files/');
define('DIST', CMS42 . 'dist/');
define('DEMO', CMS42 . 'demo/');
