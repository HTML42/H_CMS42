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
    if ($orig_string && is_array($input)) {
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

function inc($file) {
    foreach (array('', DIR_CMS, DIR_LIB) as $prefix) {
        foreach (array('.html', '.php', '') as $affix) {
            if (is_file($prefix . $file . $affix)) {
                ob_start();
                include $prefix . $file . $affix;
                return ob_get_clean();
            }
            if (is_file($prefix . '_' . $file . $affix)) {
                ob_start();
                include $prefix . '_' . $file . $affix;
                return ob_get_clean();
            }
        }
    }
    return null;
}

function debug($var, $height = 'auto', $width = 'auto') {
    $backtrace = debug_backtrace();
    $file = 'Unknown';
    $line = 'Unknown';
    if (count($backtrace) > 1 && isset($backtrace[1]['function']) && in_array($backtrace[1]['function'], array('debug'))) {
        $file = '<span title="Through a debug from: ' . $backtrace[0]['file'] . '">' . $backtrace[1]['file'] . '</span>';
        $line = $backtrace[1]['line'];
    } else if (isset($backtrace[0]['file']) && isset($backtrace[0]['line'])) {
        $file = $backtrace[0]['file'];
        $line = $backtrace[0]['line'];
    }
    echo '<pre style="' .
    'word-break:break-word;border: 1px dashed #BBB;background-color: #CCC;padding:10px;color:#333;' . ($height == 'auto' ? '' : 'overflow-y:scroll;') .
    'height:' . ($height == 'auto' ? 'auto' : $height . 'px') . ';width:' . (strstr($width, '%') || strstr($width, 'px') ? $width : (strstr($width, 'auto') ? 'auto' : $width . 'px')) .
    ';' . ($width != '100%' ? 'margin: 0 auto 10px;' : '') . '">';
    echo '<span style="display: block; margin-bottom: 5px; font-weight: 700;">' . $file . ' (line ' . $line . '):</span>';
    ob_start();
    var_dump($var);
    echo htmlspecialchars(ob_get_clean());
    echo '</pre>';
}
