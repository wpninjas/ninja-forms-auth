<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Auth_Plugin
{
    private $version;
    private $url;
    private $dir;

    public function __construct( $version, $file )
    {
        $this->version = $version;
        $this->url = plugin_dir_url( $file );
        $this->dir = plugin_dir_path( $file );
    }

    /*
    |--------------------------------------------------------------------------
    | Plugin Methods
    |--------------------------------------------------------------------------
    */

    public function version()
    {
        return $this->version;
    }

    public function url( $url = '' )
    {
        return trailingslashit( $this->url ) . $url;
    }

    public function dir( $path = '' )
    {
        return trailingslashit( $this->dir ) . $path;
    }

    public function template( $file, $args = array() )
    {
        $path = $this->dir( 'templates/' . $file );
        if( ! file_exists(  $path ) ) return '';
        extract( $args );

        ob_start();
        include $path;
        return ob_get_clean();
    }

}
