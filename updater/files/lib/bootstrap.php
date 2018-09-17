<?php

define('DIR_CMS', str_replace('/lib', '/', str_replace('\\', '/', __DIR__)));
define('DIR_LIB', DIR_CMS . 'lib/');

define('RAWGIT_URL', 'https://raw.githubusercontent.com/HTML42/H_CMS42/master/');
define('RAWGIT_FILES', RAWGIT_URL . 'updater/files/');

include DIR_LIB . 'functions.php';

define('VERSION', trim(file_get_contents(DIR_CMS . 'version')));
define('CDN_VERSION', _get(RAWGIT_FILES . 'version'));

define('IS_DEMO', (strstr(DIR_LIB, '/demo/42/lib') && in_array('updater', scandir(str_replace('/demo/42/lib', '', DIR_LIB)))));

//Configs
$configfiles_cms = DIR_CMS . 'appconfig/cms.json';
$CONFIGS_CMS_default = array(
    'update_direct' => false
);
if (is_file($configfiles_cms)) {
    $CONFIGS_CMS = json_decode(file_get_contents($configfiles_cms), true);
} else {
    $CONFIGS_CMS = $CONFIGS_CMS_default;
}
