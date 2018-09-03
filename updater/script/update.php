<?php

if (isset($UPDATER_FILES) && is_array($UPDATER_FILES)) {
    foreach ($UPDATER_FILES as $relative_filepath) {
        file_put_contents(DIR_CMS . $relative_filepath, _get($baseurl_files . $relative_filepath));
    }
}

file_put_contents(DIR_CMS . 'update.php', _get($baseurl . 'dist/updater.min.php'));
