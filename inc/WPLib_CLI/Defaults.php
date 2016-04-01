<?php
/**
 *
 */
namespace WPLib_CLI;

/**
 * Class Defaults
 * @package WPLib_CLI
 */
class Defaults
{
    const DEFAULTS_DIR = '~/.wplib';
    const DEFAULTS_FILE = '~/.wplib/defaults.json';

    public $repo_org= '';
    public $author_name = '';
    public $author_email = '';
    public $author_homepage = '';
    public $author_role = '';
    public $license = 'GPL-2.0+';

    function __construct()
    {
        if ( ! is_dir( $dir = $this->filepath( self::DEFAULTS_DIR ) ) ) {
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

        echo "\n\tWPLib Defaults:\n";
        echo "\t" . str_repeat( '-', 40 ) ."\n";
        foreach ( $properties as $name => $value ) {
            echo "\t" . str_pad( "${name}:", 3+$pad_width ) . "{$value}\n";
        }
        echo "\n";
    }

    function save()
    {
        $json = json_encode( (array)$this );
        file_put_contents( $this->filepath(self::DEFAULTS_FILE), $json );
    }

    function filepath($dir)
    {
        $filepath = preg_replace('#~/(.*)$#', getenv('HOME') . "/$1", $dir );
        return $filepath;
    }

    function load_json()
    {
        $filepath = $this->filepath(self::DEFAULTS_FILE);
        $defaults = is_file($filepath)
            ? file_get_contents($filepath)
            : '{}';
        $json = json_decode($defaults ? $defaults : '{}');
        return $json;
    }

}


