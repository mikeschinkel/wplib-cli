<?php

list( $config_var, $config_value ) = explode( '=', $argv[1] );

require __DIR__ . '/WPLib_CLI/Config.php';

$config = new \WPLib_CLI\Config();

if ( ! isset( $config->$config_var ) ) {
    $status = 1;
} else if ( ! isset( $config_value ) ) {
    $status = 2;
} else {
    $config->load();
    $config->$config_var = $config_value;
    $config->save();
    $config->show();
    $status = 0;
}
exit($status);


