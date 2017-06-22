<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Auth extends NF_Auth_Plugin
{
    public function __construct( $version, $file )
    {
        parent::__construct( $version, $file );

        add_action( 'admin_init', function(){
            if(
                ! isset( $_REQUEST[ 'nf_install_license' ] )
                || ! isset( $_REQUEST[ 'nf_install_client' ] )
            ) return;

            $client_id = absint( $_REQUEST[ 'nf_install_client' ] );

            $license_key = get_post_meta( $_REQUEST[ 'nf_install_license' ], '_edd_sl_key', true );
            $download_id = get_post_meta( $_REQUEST[ 'nf_install_license' ], '_edd_sl_download_id', true );
            $download = get_post( $download_id );

            $webhook = new NF_Auth_Integrations_WPOAuthServer_Webhook();
            $webhook->init( $client_id );
            $webhook->send( 'install', array(
                'download' => $download->post_title,
                'license' => $license_key,
                'slug' => $download->post_name
            ), true );

            echo "<pre>";
            var_dump($webhook);
            echo "</pre>";
            die();
        });

        add_shortcode( 'site_manager', function(){
            $user_id = get_current_user_id();
            $licenses = get_edd_data( $user_id );

            foreach( $licenses as &$license ){
                $sites = maybe_unserialize( $license[ 'sites' ] );
                $license[ 'sites' ] = array_values( $sites );
            }

            $clients = get_posts(array(
               'post_type' => 'wo_client',
                'meta_key' => 'user_id',
                'meta_value' => $user_id
            ));

            $sites = array();
            foreach( $clients as $client ){
                $url = get_post_meta( $client->ID, 'redirect_uri', true );
                $url = parse_url( $url, PHP_URL_HOST );
                $sites[ $client->ID ] = trailingslashit( $url );
            }

            wp_enqueue_script( 'nf_site_manager', NF_Auth()->url( 'client/site-manager/main.js' ), array( 'jquery' ) );
            wp_localize_script( 'nf_site_manager', 'nfSiteManager', array(
                'sites' => $sites,
                'licenses' => $licenses,
            ));

            return '<div id="nfSiteManager"></div>';
        });

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

        add_action( 'admin_enqueue_scripts', function( $hook ){
            if( $hook != 'admin_page_wo_edit_client' ) return;
            if( ! isset( $_GET[ 'id' ] ) ) return;
            wp_register_script( 'wo-client-webhook-example', $this->url( 'assets/js/wo-client-webhook-example.js' ), array( 'jquery' ) );

            $id = $_GET[ 'id' ];
            $site_url = get_post_meta( $id, 'redirect_uri', true );
            $client_id = get_post_meta( $id, 'client_id', true );
            $client_secret = get_post_meta( $id, 'client_secret', true );
            $payload = json_encode( array( 'foo' => 'bar' ) );
            $hash = sha1( $payload . $client_id . $client_secret );
            wp_localize_script( 'wo-client-webhook-example', 'example_webhook', array(
                'href' => add_query_arg( array(
                    'nf_webhook' => 'example',
                    'nf_webhook_payload' => $payload,
                    'nf_webhook_hash' => $hash
                ), $site_url )
            ));
            wp_enqueue_script( 'wo-client-webhook-example' );
        });
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
