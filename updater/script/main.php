<?php

#include variables.php

#include check_environment.php

echo 'CMS-Version: ' . CMS_VERSION;
echo '<br/>';
echo 'Update needed: ' . strval($UPDATE_NEED);
