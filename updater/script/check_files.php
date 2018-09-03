<?php

$baseurl = 'https://raw.githubusercontent.com/HTML42/H_CMS42/master/';
$baseurl_files = $baseurl . 'updater/files/';

$_cdn_version = _get($baseurl_files . 'version');
define('CDN_VERSION', is_string($_cdn_version) ? $_cdn_version : null);
