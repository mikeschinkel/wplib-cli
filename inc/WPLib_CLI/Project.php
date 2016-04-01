<?php
/**
 *
 */
namespace WPLib_CLI;

/**
 * Class Project
 * @package WPLib_CLI
 * @mixin Defaults
 * @todo Need to add get/set error handling
 */
class Project
{
    const PROJECT_FILE = 'composer.json';

    public $project_title = '';
    public $project_slug = '';
    public $project_name = '';
    public $project_prefix = '';
    public $app_slug = '';
    private $_defaults;

    function __construct()
    {
        $this->_defaults = new Defaults();
        $this->_defaults->load();
    }

    function __set( $property_name, $value )
    {
        if ( property_exists( $this->_defaults, $property_name ) ) {
            $this->_defaults->$property_name = $value;
        }
    }

    function __get( $property_name )
    {
        return property_exists( $this->_defaults, $property_name )
            ? $this->_defaults->$property_name
            : null;
    }

    /**
     * Loads Project Info from composer.json file.
     */
    function load()
    {
        $json = $this->load_composer_json();
        if ( property_exists( $json, 'name' ) ) {
            if ( false !== strpos( $json->name, '/' ) ) {
                list( $this->repo_org, $this->project_slug ) = explode( '/', $json->name );
            }
        }
        if ( property_exists( $json, 'description' ) ) {
            $this->project_title = $json->description;
        }
        if ( property_exists( $json, 'license' ) ) {
            $this->license = $json->license;
        }
        if ( property_exists( $json, 'require' ) ) {
            foreach( $json->require as $slug => $version_spec ) {
                list( $void, $name ) = explode( '/', $slug );
                if ( isset( $this->require[$name] ) ) {
                    $this->require[$name] = $version_spec;
                }
            }
        }
        if ( property_exists( $json, 'extra' ) ) {
            if ( property_exists( $json->extra, 'wplib' ) ) {
                if ( property_exists( $json->extra->wplib, 'name' ) ) {
                    $this->project_name = $json->extra->wplib->name;
                }
                if ( property_exists( $json->extra->wplib, 'prefix' ) ) {
                    $this->project_prefix = $json->extra->wplib->prefix;
                }
                if ( property_exists( $json->extra->wplib, 'app' ) ) {
                    $app_path = $json->extra->wplib->app;
                    $pos = strrpos( $app_path, '/' );
                    $this->app_slug = substr( $app_path, $pos + 1 );
                }
            }
        }

    }

    function load_composer_json()
    {
        $filepath = $this->filepath(self::PROJECT_FILE);
        $composer_json = is_file($filepath)
            ? file_get_contents($filepath)
            : '{}';
        return json_decode($composer_json ? $composer_json : '{}');
    }

    function filepath($filepath)
    {
        return __DIR__ . "/{$filepath}";
    }





}


