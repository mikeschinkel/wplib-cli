<?php


$project = new WPLib_CLI\Project();

$php_open_tag= '<' . '?php';
$json=<<<JSON
{
    "name": "{$project->repo_org}/{$project->project_slug}",
    "description": "{$project->description}",
    "license": "{$project->license}",
    "type": "project",
    "authors": [
        {
            "name": "{$project->author_name}",
            "email": "{$project->author_email}",
            "homepage": "{$project->author_homepage}",
            "role": "{$project->author_role}",
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
            "name": "{$project->project_name}",
            "prefix": "{$project->project_prefix}",
            "comments": "'app' can start with '~' (local file), 'http' (remote file), '{' (object), or have a single slash meaning it comes from 'require'",
            "app": "~/www/content/mu-plugins/{$project->app_slug}",
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
    "defaults": {
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