<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Name: Ninja Forms - Auth
 * Version: 3.0.0-alpha
 * GitHub Plugin URI: https://github.com/wpninjas/ninja-forms-auth
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


/*
 * Allow Cross Origin Requests
 */
add_action( 'init', function() {
    header("Access-Control-Allow-Origin: " . get_http_origin());
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Credentials: true");

    if ( 'OPTIONS' == $_SERVER['REQUEST_METHOD'] ) {
        status_header(200);
        exit();
    }
} );
