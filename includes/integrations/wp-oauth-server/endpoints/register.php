<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Auth_Integrations_WPOAuthServer_Endpoints_Register
 *
 * @vars client_secret
 * @endpoint /oauth/register
 */
final class NF_Auth_Integrations_WPOAuthServer_Endpoints_Register
{
    public function init()
    {
        add_filter( 'query_vars', array( $this, 'add_vars' ) );
        add_filter( 'wo_endpoints', array( $this, 'register_endpoint' ) );
    }

    public function add_vars( $vars )
    {
        $vars[] = 'client_secret';
        $vars[] = 'client_redirect';
        return $vars;
    }

    public function register_endpoint( $endpoints )
    {
        $endpoints[ 'register' ] = array(
            'public' => true,
            'func' => array( $this, 'callback' )
        );
        return $endpoints;
    }

    public function callback()
    {
        if ( ! is_user_logged_in() ) auth_redirect();

        $client_secret   = get_query_var( 'client_secret' ); // TODO: How should we sanatize this?
        $client_redirect = get_query_var( 'client_redirect' );

        if( ! $client_secret ){
            echo json_encode( [ 'error' => 'Client Secret not found.' ] ); // TODO: Update this to match WO responses.
            return;
        }

        if( ! $client_redirect ){
            echo json_encode( [ 'error' => 'Client Redirect not found.' ] ); // TODO: Update this to match WO responses.
            return;
        }

        // TODO: Create Client and return client_id
        wp_redirect( $client_redirect );
        exit();
    }

}