<?php

function autoloader($class)
{
    $path = str_replace('_', '/', $class);
    require_once $path . '.php';
}

spl_autoload_register('autoloader');
