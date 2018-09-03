<?php

define('DIR_CMS', str_replace('/42', '/', __DIR__));
define('DIR_LIB', DIR_CMS . 'lib/');

define('RAWGIT_URL', 'https://raw.githubusercontent.com/HTML42/H_CMS42/master/');
define('RAWGIT_FILES', RAWGIT_URL . 'updater/files/');

include DIR_LIB . 'functions.php';

define('VERSION', trim(file_get_contents(DIR_CMS . 'version')));
define('CDN_VERSION', _get(RAWGIT_FILES . 'version'));
