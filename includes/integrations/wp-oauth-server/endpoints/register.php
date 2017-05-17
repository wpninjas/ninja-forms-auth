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

        $site_url = parse_url( $client_redirect );

        $client_insert = $this->create_client( array(
            'secret' => $client_secret,
            'name' => $site_url[ 'host' ]
        ));

        $client_id = get_post_meta( $client_insert, 'client_id', /* single */ true );

        $client_redirect = add_query_arg( 'client_id', $client_id, $client_redirect );

        wp_redirect( $client_redirect );
        exit();
    }

    /**
     * @param null $client_data
     * @return bool|int $client_insert
     */
    private function create_client( $client_data = null )
    {
        $client_data = array_merge( array(
            'name' => '',
            'secret' => '',
            'grant_types' => array(),
            'redirect_uri' => '',
            'user_id' => '',
            'scope' => ''
        ), $client_data );

        if ( empty( $client_data[ 'secret' ] ) ) {
            exit( 'Client secret not found.' );
            return false;
        }

        do_action( 'wo_before_create_client', array( $client_data ) );

        $client_id     = wo_gen_key();
        $client_secret = $client_data[ 'secret' ]; // TODO: Sanatize this.

        $client = array(
            'post_title'     => wp_strip_all_tags( $client_data[ 'name' ] ),
            'post_status'    => 'publish',
            'post_author'    => get_current_user_id(),
            'post_type'      => 'wo_client',
            'comment_status' => 'closed',
            'meta_input'     => array(
                'client_id'     => $client_id,
                'client_secret' => $client_secret,
                'grant_types'   => $client_data[ 'grant_types' ],
                'redirect_uri'  => $client_data[ 'redirect_uri' ],
                'user_id'       => $client_data[ 'user_id' ],
                'scope'         => $client_data[ 'scope' ]
            )

        );

        // Insert the post into the database
        $client_insert = wp_insert_post( $client );
        if ( is_wp_error( $client_insert ) ) {
            exit( $client_insert->get_error_message() );
        }

        return $client_insert;
    }
}
