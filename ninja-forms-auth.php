<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Name: Ninja Forms - Auth
 * Version: 3.0.0-alpha
 */

require_once plugin_dir_path( __FILE__ ) . 'includes/autoload.php';

if( ! function_exists( 'NF_Auth' ) ) {
    function NF_Auth()
    {
        static $instance;
        if( ! isset( $instance ) ) {
            $instance = new NF_Auth( '3.0.0-alpha', __FILE__ );
        }
        return $instance;
    }
}
NF_Auth();
