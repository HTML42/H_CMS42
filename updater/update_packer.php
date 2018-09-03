<?php

$script_root = __DIR__;
include '../library/quick_bootstrap.php';
//
$updatescript = updater_include('main.php', UPDATER_SCRIPT);
$updatescript_min = minimize__php_file($updatescript);
//
if (!is_dir(DIST)) {
    mkdir(DIST);
}
//
file_put_contents(DIST . 'updater.php', $updatescript);
file_put_contents(DIST . 'updater.min.php', $updatescript_min);
usleep(500);
show_created(DIST . 'updater.php');
show_created(DIST . 'updater.min.php');
//
file_put_contents(DEMO . 'updater.min.php', $updatescript_min);

//
//##Helper Functions
//
function updater_include($filepath, $root = null) {
    $file_content = '';
    if (!is_string($root)) {
        $root = UPDATER_SCRIPT;
    }
    $filepath = $root . $filepath;
    if (is_file($filepath)) {
        $file_content = file_get_contents($filepath);
        if (preg_match_all('/\#include\s+([\w\d_\.]+)/', $file_content, $updatescript_includes)) {
            for ($i = 0; $i < count($updatescript_includes[0]); $i++) {
                $include_code = $updatescript_includes[0][$i];
                $include_file_name = $updatescript_includes[1][$i];
                //
                $include_file_content = updater_include($include_file_name);
                $include_file_content = trim($include_file_content);
                //
                if (substr($include_file_content, 0, 5) == '<?php') {
                    $include_file_content = substr($include_file_content, 5);
                }
                if (substr($include_file_content, 0, 2) == '<?') {
                    $include_file_content = substr($include_file_content, 2);
                }
                if (substr($include_file_content, -2) == '?>') {
                    $include_file_content = substr($include_file_content, 0, strlen($include_file_content) - 2);
                }
                $include_file_content = trim($include_file_content);
                //
                $file_content = str_replace($include_code, $include_file_content, $file_content);
            }
        }
    }
    $file_content = trim($file_content);
    return $file_content;
}

function minimize__php_file($php_code) {
    php_strip_whitespace_($php_code);
    //
    $php_code = preg_replace('/\s+/s', ' ', $php_code);
    foreach (array('\;', '\&\&', '\|\|', '\=\=', '\!\=', '\{', '\}', '\(', '\)') as $a) {
        $php_code = preg_replace('/\s*' . $a . '\s*/', str_replace('\\', '', $a), $php_code);
    }
    $php_code = preg_replace('/\<\?php\s*/i', '<?php ', $php_code);
    $php_code = preg_replace('/(.+\(.+), (.+\))/isU', '$1,$2', $php_code);
    $php_code = preg_replace('/\s+\.\s+/isU', '.', $php_code);
    //Commands
    $php_code = preg_replace('/echo\s*([\'\"])/', 'echo$1', $php_code);
    return $php_code;
}

function show_created($filepath) {
    echo '<div class="file_created">' . $filepath . ' created. (' . return_filesize($filepath) . ')</div>';
}

function php_strip_whitespace_(&$php_code) {
    $tmp_filepath = CMS42 . '__tmp_file__.php';
    //
    file_put_contents($tmp_filepath, $php_code);
    usleep(500);
    //
    $php_code = php_strip_whitespace($tmp_filepath);
    usleep(500);
    //
    unlink($tmp_filepath);
}
