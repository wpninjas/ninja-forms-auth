<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Auth extends NF_Auth_Plugin
{
    public function __construct( $version, $file )
    {
        parent::__construct( $version, $file );

        (new NF_Auth_Integrations_WPOAuthServer_Endpoints_Register())->init();

        add_action( 'rest_api_init', function () {
            register_rest_route( 'ninja-forms-auth/v1', '/example-subscriber', array(
                'methods' => 'GET',
                'callback' => function(){
                    return [ 'current_user_can' => 'read' ];
                },
                'permission_callback' => function () {
                    return current_user_can( 'read' );
                }
            ) );
            register_rest_route( 'ninja-forms-auth/v1', '/example-admin', array(
                'methods' => 'GET',
                'callback' => function(){
                    return [ 'current_user_can' => 'manage_options' ];
                },
                'permission_callback' => function () {
                    return current_user_can( 'manage_options' );
                }
            ) );
        } );
    }

    /*
    |--------------------------------------------------------------------------
    | Action & Filter Hooks
    |--------------------------------------------------------------------------
    */

    // This section intentionally left blank.

    /*
    |--------------------------------------------------------------------------
    | Internal API
    |--------------------------------------------------------------------------
    */

    // This section intentionally left blank.

}
