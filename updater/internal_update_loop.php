<?php

$script_root = __DIR__;
include '../library/quick_bootstrap.php';

$files = updater_files();
foreach ($files as $file) {
    $source = file_get_contents(UPDATER_FILES . $file);
    $target_path = DEMO . '42/' . $file;
    $target = file_get_contents($target_path);
    if ($targe != $source) {
        file_put_contents($target_path, $source);
    }
}

ob_clean();
header("refresh:5;url=" . basename(__FILE__));
die;

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
