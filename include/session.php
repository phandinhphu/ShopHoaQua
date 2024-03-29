<?php

function setSession($key, $value)
{
    return $_SESSION[$key] = $value;
}

function getSession($key)
{
    return $_SESSION[$key];
}

function removeSession($key)
{
    unset($_SESSION[$key]);
}

function setFlashData($key, $value)
{
    $key = 'flash_' . $key;
    setSession($key, $value);
}

function getFlashData($key)
{
    $key = 'flash_' . $key;
    $value = getSession($key);
    removeSession($key);
    return $value;
}