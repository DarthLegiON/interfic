<?php

$params = getParams();

initDatabase();


/** ---------------------------------------  */

function getParams()
{
    $rawParams = [];
    if (isset($_SERVER['argv'])) {
        $rawParams = $_SERVER['argv'];
        array_shift($rawParams);
    }

    $params = [];
    foreach ($rawParams as $param) {
        if (preg_match('/^--(\w+)(=(.*))?$/', $param, $matches)) {
            $name = $matches[1];
            $params[$name] = isset($matches[3]) ? $matches[3] : true;
        } else {
            $params[] = $param;
        }
    }
    return $params;
}

function initDatabase()
{
    global $params;

    $installTemplate = file_get_contents('./config/db.install.php');

    foreach ($params as $key => $value) {
        if (substr($key, 0, 3) == 'db_') {
            $setting = substr($key, 3);
            $installTemplate = str_replace('{' . $setting . '}', $value, $installTemplate);
        }
    }

    file_put_contents('./config/db.php', $installTemplate);
}