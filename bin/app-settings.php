#!/usr/bin/env php
<?php

require __DIR__ . '/commandline.php';
$container = $app->getContainer();
$settings = $container->get('settings')->all();
$value = $settings;
if (count($argv) > 1) {
    foreach (explode('.', $argv[1]) as $key) {
        if (!array_key_exists($key, $value)) {
            exit(1);
        }
        $value = &$value[$key];
    }
}

if (is_array($value)) {
    print_r($value);
} else {
    echo $value;
}
?>