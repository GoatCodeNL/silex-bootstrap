<?php

require_once __DIR__ . '/../vendor/autoload.php';

$environmentConfig = [];
if (file_exists('../../webmodule-downloads-environment.php')) {
    $environmentConfig = require_once '../../webmodule-downloads-environment.php';
}

$config = array_replace_recursive(
        require_once '../config/application.php', $environmentConfig
);

return $config;
