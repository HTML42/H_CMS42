<?php

$script_root = __DIR__;
include '../library/quick_bootstrap.php';
//
$updatescript = updater_include('main.php', UPDATER_SCRIPT);
$updatescript = str_replace('#PLACEHOLDER-UPDATERFILES#', '$UPDATER_FILES = json_decode(\'' . json_encode(updater_files()) . '\');', $updatescript);
//
$updatescript_min = php_minimize($updatescript);
$updatescript_min = php_var_shortener($updatescript_min);
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

function php_minimize($php_code) {
    php_strip_whitespace_($php_code);
    //
    $php_code = preg_replace('/\s+/s', ' ', $php_code);
    foreach (array('\;', '\&\&', '\|\|', '\=\=', '\!\=', '\{', '\}', '\(', '\)', '\=', '\?', '\<', '\>') as $a) {
        $php_code = preg_replace('/\s*' . $a . '\s*/', str_replace('\\', '', $a), $php_code);
    }
    $php_code = preg_replace('/\<\?php\s*/i', '<?php ', $php_code);
    $php_code = preg_replace('/(.+\(.+), (.+\))/isU', '$1,$2', $php_code);
    $php_code = preg_replace('/\s+\.\s+/isU', '.', $php_code);
    $php_code = preg_replace('/(.+\(.+) : (.+\))/isU', '$1:$2', $php_code);
    $php_code = preg_replace('/(.+\(.+): (.+\))/isU', '$1:$2', $php_code);
    $php_code = preg_replace('/(.+\(.+) :(.+\))/isU', '$1:$2', $php_code);
    //Commands
    $php_code = preg_replace('/echo\s*([\'\"])/', 'echo$1', $php_code);
    $php_code = preg_replace('/else if/', 'elseif', $php_code);
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

function php_var_shortener($php_code, $counter = 0, $symbol_offset = 0) {
    if (preg_match_all('/\$[\w_]+/', $php_code, $php_var_matches) && isset($php_var_matches[0]) && is_array($php_var_matches[0])) {
        $php_var_reminder = array();
        $php_var_symbols = array_merge(range('a', 'z'), range('A', 'Z'));
        foreach ($php_var_matches[0] as $php_var) {
            if (strlen($php_var) > 3 && !in_array($php_var, $php_var_reminder)) {
                $new_varname = $php_var_symbols[count($php_var_reminder) + $symbol_offset];
                $php_code = preg_replace('/\\' . $php_var . '/isU', '\$Z' . $new_varname, $php_code);
                array_push($php_var_reminder, $php_var);
            }
        }
    }
    if ($counter < 2) {
        $php_code = php_var_shortener($php_code, $counter + 1, count($php_var_reminder) + $symbol_offset);
    }
    return $php_code;
}

function updater_files() {
    $_file_list = array();
    foreach (scandir(UPDATER_FILES) as $updater_files_dim1) {
        if (in_array($updater_files_dim1, array('.', '..'))) {
            //
        } else if (is_file(UPDATER_FILES . $updater_files_dim1)) {
            array_push($_file_list, $updater_files_dim1);
        } else {
            $folder_dim1 = UPDATER_FILES . $updater_files_dim1 . '/';
            //DIM2 Start
            foreach (scandir($folder_dim1) as $updater_files_dim2) {
                if (in_array($updater_files_dim2, array('.', '..'))) {
                    //
                } else if (is_file($folder_dim1 . $updater_files_dim2)) {
                    array_push($_file_list, $updater_files_dim1 . '/' . $updater_files_dim2);
                } else {
                    $folder_dim3 = $folder_dim1 . $updater_files_dim2 . '/';
                    //Only 2 Dimensions
                }
            }
            //DIM2 End
        }
    }
    return $_file_list;
}
