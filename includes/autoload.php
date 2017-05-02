<?php if ( ! defined( 'ABSPATH' ) ) exit;

require_once plugin_dir_path( __FILE__ ) . 'plugin.php';
require_once plugin_dir_path( __FILE__ ) . 'auth.php';

/*
 |--------------------------------------------------------------------------
 | Endpoints
 |--------------------------------------------------------------------------
 */

require_once plugin_dir_path( __FILE__ ) . 'endpoints/endpoint.php';
require_once plugin_dir_path( __FILE__ ) . 'endpoints/example.php';