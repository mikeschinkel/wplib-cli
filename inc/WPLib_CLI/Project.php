<?php
/**
 *
 */
namespace WPLib_CLI;

/**
 * Class Project
 * @package WPLib_CLI
 */
class Project
{

    public $repo_org= '';
    public $description = '';
    public $project_slug = '';
    public $project_name = '';
    public $project_prefix = '';
    public $app_slug = '';
    public $author_name = '';
    public $author_email = '';
    public $author_homepage = '';
    public $author_role = '';
    public $license = 'GPL-2.0+';

    function __construct()
    {
        $defaults = new Defaults();
        $defaults->load();
        foreach( get_object_vars( $defaults ) as $var_name => $value ) {
            if ( property_exists( $this, $var_name ) ) {
                $this->$var_name = $defaults->$var_name;
            }
        }
    }

}


