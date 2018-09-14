<?php

include '../lib/bootstrap.php';

if ($CONFIGS_CMS['update_direct']) {
    echo 2;
} else {
    if (is_file(DIR_CMS . 'update.php')) {
        include DIR_CMS . 'update.php';
        echo 1;
    } else {
        echo 0;
    }
}
