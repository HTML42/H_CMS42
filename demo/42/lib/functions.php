<?php

function _get($url) {
    if (is_string($url) && strlen($url) > 5) {
        $url = trim($url);
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $ch_exec = curl_exec($ch);
        curl_close($ch);
        $return = ob_get_clean();
        if (!in_array(trim($return), array('404: Not Found'))) {
            return $return;
        } else {
            return null;
        }
    }
    return null;
}
