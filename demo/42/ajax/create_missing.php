<?php

include '../lib/bootstrap.php';

$nothing_changed = true;
#Check CMS Config
if(!file_exists($configfiles_cms)) {
    file_put_contents($configfiles_cms, json_encode($CONFIGS_CMS_default));
    $nothing_changed = false;
}
#Check APP Config
if(!file_exists($configfiles_app)) {
    file_put_contents($configfiles_app, json_encode($CONFIGS_APP_default));
    $nothing_changed = false;
}
#Check PAGES Config
if(!file_exists($configfiles_pages)) {
    file_put_contents($configfiles_pages, json_encode($CONFIGS_PAGES_default));
    $nothing_changed = false;
}

ob_clean();
echo ($nothing_changed ? 2 : 1);
die();