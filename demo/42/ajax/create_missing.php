<?php

include '../lib/bootstrap.php';

$type = payload('type');

if (is_string($type)) {
    $type = strtolower($type);
    switch ($type) {
        case 'appconfig':
            if (!is_file(DIR_CMS . 'appconfig/app.json')) {
                file_put_contents(DIR_CMS . 'appconfig/app.json', json_encode($CONFIGS_CMS_default));
            }
            break;
    }
}