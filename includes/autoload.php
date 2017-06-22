<?php if ( ! defined( 'ABSPATH' ) ) exit;

require_once plugin_dir_path( __FILE__ ) . 'functions.php';
require_once plugin_dir_path( __FILE__ ) . 'plugin.php';
require_once plugin_dir_path( __FILE__ ) . 'auth.php';

/*
 |--------------------------------------------------------------------------
 | Integrations
 |--------------------------------------------------------------------------
 */
require_once plugin_dir_path( __FILE__ ) . 'integrations/wp-oauth-server/webhook.php';
require_once plugin_dir_path( __FILE__ ) . 'integrations/wp-oauth-server/endpoints/register.php';
