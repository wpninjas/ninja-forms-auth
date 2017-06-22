<?php if ( ! defined( 'ABSPATH' ) ) exit;

//wp_remote_retrieve_body( $response )

class NF_Auth_Integrations_WPOAuthServer_Webhook
{
    public $client_id;
    public $client_url;
    public $client_secret;
    public $response;

    public function init( $post_id )
    {
        $this->client_id = get_post_meta( $post_id, 'client_id', true );
        $this->client_url = get_post_meta( $post_id, 'redirect_uri', true );
        $this->client_secret = get_post_meta( $post_id, 'client_secret', true );
    }

    public function send( $name, $payload, $blocking = false )
    {
        $payload = json_encode( $payload );
        return $this->response = wp_remote_post( $this->client_url, array(
            'blocking' => $blocking,
            'body' => array(
                'nf_webhook' => $name,
                'nf_webhook_payload' => $payload,
                'nf_webhook_hash' => $this->get_hash( $payload )
            )
        ) );
    }

    private function get_hash( $payload )
    {
        return sha1( $payload . $this->client_id . $this->client_secret );
    }
}