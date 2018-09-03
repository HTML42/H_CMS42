<?php

$UPDATER_FILES = json_decode('["index.php","lib\/_html.php","lib\/bootstrap.php","lib\/render.php","version"]');

function _get($url) {
    if (is_string($url) && strlen($url) > 5) {
        $url = trim($url);
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $ch_exec = curl_exec($ch);
        curl_close($ch);
        $return = ob_get_clean();
        if (!in_array(trim($return), array('404: Not Found'))) {
            return $return;
        } else {
            return null;
        }
    }
    return null;
}

function ensure_structure($folders) {
    if (is_string($folders)) {
        $folders = array($folders);
    }
    if (is_array($folders)) {
        foreach ($folders as $folder) {
            $parts = explode('/', $folder);
            $parts = array_filter($parts, 'strlen');
            $current_folder_path = (substring($folder, 0, 1) == '/' ? '/' : '');
            foreach ($parts as $part) {
                $current_folder_path .= $part . '/';
                if (!is_dir($current_folder_path)) {
                    mkdir($current_folder_path);
                }
            }
        }
    }
}
define('DIR_CMS', str_replace('/42', '', __DIR__) . '/42/');

$UPDATE_NEED = null;

$CMS_VERSION_FILE = DIR_CMS . 'version';
define('CMS_VERSION', (is_file($CMS_VERSION_FILE) ? trim(file_get_contents($CMS_VERSION_FILE)) : NULL));


$baseurl = 'https://raw.githubusercontent.com/HTML42/H_CMS42/master/';
$baseurl_files = $baseurl . 'updater/files/';

$parent_folder = scandir(dirname(__DIR__));
if (substr(__DIR__, -4) == 'dist' && in_array('demo', $parent_folder) && in_array('updater', $parent_folder)) {
    exit('<div>You are currently accessing to a source-File.</div>');
}


$_cdn_version = _get($baseurl_files . 'version');
define('CDN_VERSION', is_string($_cdn_version) ? $_cdn_version : null);

$UPDATE_NEED = false;

if (!is_dir(DIR_CMS)) {
    mkdir(DIR_CMS);
    $UPDATE_NEED = true;
}

if (!is_string(CMS_VERSION) || strlen(CMS_VERSION) < 1) {
    $UPDATE_NEED = true;
} else if(CMS_VERSION != CDN_VERSION) {
    $UPDATE_NEED = true;
}

if($UPDATE_NEED) {
    if (isset($UPDATER_FILES) && is_array($UPDATER_FILES)) {
    foreach ($UPDATER_FILES as $relative_filepath) {
        ensure_structure(dirname(DIR_CMS . $relative_filepath));
        file_put_contents(DIR_CMS . $relative_filepath, _get($baseurl_files . $relative_filepath));
    }
}

file_put_contents(DIR_CMS . 'update.php', _get($baseurl . 'dist/updater.min.php'));
}