<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Auth_Endpoints_Endpoint
{
    protected $slug = 'ninja-forms';
    protected $method = 'GET';
    protected $endpoint = '';

    public function __construct()
    {
        add_filter( 'query_vars', array( $this, 'query_vars' ) );
        add_action( 'parse_request', array( $this, 'parse_request' ) );
    }

    public function query_vars( $vars )
    {
        if( ! in_array( $this->slug, $vars ) ) {
            $vars[] = $this->slug;
        }
        return $vars;
    }

    public function parse_request( $wp )
    {
        if( $this->method != $_SERVER['REQUEST_METHOD'] ) return;
        if( ! isset( $wp->query_vars[ $this->slug ] ) ) return;
        if( $this->endpoint != $wp->query_vars[ $this->slug ] ) return;
        $this->process();
        die();
    }

    abstract function process();
}