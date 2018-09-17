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

function validate($input, $as_int = false) {
    $orig_string = false;
    if (is_string($input)) {
        $input = array($input);
        $orig_string = true;
    }
    if (is_array($input)) {
        foreach ($input as &$part) {
            if (is_string($part)) {
                $part = trim($part);
                $part = strip_tags($part);
                $part = htmlspecialchars($part);
                if ($as_int) {
                    $part = (is_numeric($part) ? intval($part) : 0);
                }
            } else {
                $part = validate($part, $as_int);
            }
        }
    }
    if($orig_string && is_array($input)) {
        $input = reset($input);
    }
    return $input;
}

function payload($key, $mode = '*', $validate = true) {
    $return = null;
    switch (strtolower($mode)) {
        case 'get':
        case '_get':
            if (isset($_GET[$key])) {
                $return = $_GET[$key];
            } else {
                $return = null;
            }
            break;
        case 'post':
        case '_post':
            if (isset($_POST[$key])) {
                $return = $_POST[$key];
            } else {
                $return = null;
            }
            break;
        case '*':
        case 'all':
            if (isset($_GET[$key])) {
                $return = $_GET[$key];
            } else if (isset($_POST[$key])) {
                $return = $_POST[$key];
            } else if (isset($_REQUEST[$key])) {
                $return = $_REQUEST[$key];
            } else {
                $return = null;
            }
            break;
    }
    //
    if ($validate) {
        $return = validate($return);
    }
    //
    if (strtolower($return) === 'true') {
        $return = true;
    } else if (strtolower($return) === 'false') {
        $return = false;
    } else if (strtolower($return) === 'null') {
        $return = null;
    }
    return $return;
}
