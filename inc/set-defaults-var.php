<?php

list( $defaults_var, $defaults_value ) = explode( '=', $argv[1] );

require __DIR__ . '/WPLib_CLI/Defaults.php';

$defaults = new \WPLib_CLI\Defaults();

if ( ! isset( $defaults->$defaults_var ) ) {
    $defaults->show();
} else {
    $defaults->load();
    $defaults->$defaults_var = $defaults_value;
    $defaults->save();
    $defaults->show();
}
exit;


