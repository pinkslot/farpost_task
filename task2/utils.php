<?php
namespace app\utils;

function render_php($path, array $args){
    ob_start();
    require($path);
    $var=ob_get_contents();
    ob_end_clean();
    return $var;
}

function redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}
