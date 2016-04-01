<?php
/**
 *
 */
namespace WPLib_CLI;

/**
 * Class Config
 * @package WPLib_CLI
 */
class Config
{
    const CONFIG_DIR = '~/.wplib';
    const CONFIG_FILE = '~/.wplib/config.json';

    public $organization = '';
    public $description = '';
    public $project_name = '';
    public $project_prefix = '';
    public $project_slug = '';
    public $app_slug = '';
    public $license = 'GPL-2.0+';

    function __construct()
    {
        if ( ! is_dir( $dir = $this->filepath( self::CONFIG_DIR ) ) ) {
            mkdir( $dir );
        }
    }

    function load()
    {
        $json = $this->load_json();
        foreach ( array_keys( get_object_vars( $this ) ) as $var_name ) {
            if ( isset( $json->$var_name ) ) {
                $this->$var_name = $json->$var_name;
            }
        }
    }

    function show()
    {
        $properties = get_object_vars( $this );
        $pad_width = 0;
        $pad_width = array_reduce(
            array_keys($properties),
            function( $pad_width,$key) {
                return max($pad_width,strlen($key));
            }
        );

        echo "\nWPLib Config:\n";
        echo str_repeat( '-', 40 ) ."\n";
        foreach ( $properties as $name => $value ) {
            echo str_pad( "${name}:", 2+$pad_width );
            echo "{$value}\n";
        }
        echo "\n";
    }

    function save()
    {
        $json = json_encode( (array)$this );
        file_put_contents( $this->filepath(self::CONFIG_FILE), $json );
    }

    function filepath($dir)
    {
        $filepath = preg_replace('#~/(.*)$#', getenv('HOME') . "/$1", $dir );
        return $filepath;
    }

    function load_json()
    {
        $filepath = $this->filepath(self::CONFIG_FILE);
        $config = is_file($filepath)
            ? file_get_contents($filepath)
            : '{}';
        $json = json_decode($config ? $config : '{}');
        return $json;
    }

}


