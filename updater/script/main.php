<?php

#include functions.php
#include variables.php

#include check_environment.php
#include check_files.php

echo 'CDN-Version: ' . CDN_VERSION;
echo '<br/>';
echo 'CMS-Version: ' . CMS_VERSION;
echo '<br/>';
echo 'Update needed: ' . strval($UPDATE_NEED);
