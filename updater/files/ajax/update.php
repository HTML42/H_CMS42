<?php

include '../lib/bootstrap.php';

if ($CONFIGS_CMS['update_direct']) {
    $UPDATER_FILES = DIR_CMS . '../../updater/files/';
    $files = updater_files();
    foreach($files as $file) {
        file_put_contents(DIR_CMS . $file, file_get_contents($UPDATER_FILES . $file));
    }
    echo 2;
} else {
    if (is_file(DIR_CMS . 'update.php')) {
        include DIR_CMS . 'update.php';
        echo 1;
    } else {
        echo 0;
    }
}

function updater_files() {
    $_file_list = array();
    $UPDATER_FILES = DIR_CMS . '../../updater/files/';
    if (is_dir($UPDATER_FILES)) {
        foreach (scandir($UPDATER_FILES) as $updater_files_dim1) {
            if (in_array($updater_files_dim1, array('.', '..'))) {
                //
            } else if (is_file($UPDATER_FILES . $updater_files_dim1)) {
                array_push($_file_list, $updater_files_dim1);
            } else {
                $folder_dim1 = $UPDATER_FILES . $updater_files_dim1 . '/';
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
    }
    return $_file_list;
}
