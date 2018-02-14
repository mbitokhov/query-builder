<?php

function class_basename($class)
{
    $class = get_class($class);
    $class = explode('\\', $class);
    return end($class);
}
