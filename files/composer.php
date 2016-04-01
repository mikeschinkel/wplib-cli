<?php


$config = new WPLib_CLI\Config();
$config->load();

$php_open_tag= '<' . '?php';
$json=<<<JSON
{
    "name": "{$config->organization}/{$config->project_slug}",
    "description": "{$config->description}",
    "license": "{$config->license}",
    "type": "project",
    "authors": [
        {
            "name": "A fan of WPLib",
            "email": "fan@wplib.org",
            "homepage": "http://wplib.org",
            "role": "WPLib-based Website Project Developer Library Author"
        }
    ],
    "repositories": [
        {
            "type": "composer",
            "url": "http://wpackagist.org"
        },
        {
            "type": "git",
            "url": "http://github.org/wplib/installers"
        },
        {
            "type": "git",
            "url": "http://github.org/wplib/wplib"
        }
    ],
    "require": {
        "composer/installers": "dev-master",
        "wplib/wplib": "0.12.2",
        "wplib/wordpress": "4.4",
        "wpackagist-plugin/query-monitor": "2.8.1",
        "wpackagist-plugin/helpful-information": "1.0.2"
    },
    "extra": {
        "wplib" : {
            "name": "{$config->project_name}",
            "prefix": "{$config->project_prefix}",
            "comments": "'app' can start with '~' (local file), 'http' (remote file), '{' (object), or have a single slash meaning it comes from 'require'",
            "app": "~/www/content/mu-plugins/{$config->app_slug}",
            "theme": {}
        },
        "wordpress-install-dir": "www/wp",
        "installer-paths": {
            "www/content/mu-plugins/planit/modules/{\$name}": [
                "type:wplib-module"
            ],
            "www/content/mu-plugins/{\$name}": [
                "type:wordpress-library",
                "type:wordpress-muplugin",
                "wpackagist-plugin/wp-redis"
            ],
            "www/content/plugins/{\$name}": [
                "type:wordpress-plugin"
            ],
            "www/content/themes/{\$name}": [
                "type:wordpress-theme"
            ]
        }
    },
    "config": {
        "vendor-dir": "www/content/vendor"
    },
    "scripts": {
        "post-install-cmd": "php composer/scripts/sanitize-wp.php",
        "post-update-cmd": "php composer/scripts/sanitize-wp.php",
        "generate-salts": [
            "echo 'Creating salt.php file...'",
            "echo '{$php_open_tag}' > www/salt.php && curl -L https://api.wordpress.org/secret-key/1.1/salt/ >> www/salt.php"
        ]
    }
}
JSON;
echo $json;