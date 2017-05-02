<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Auth_Endpoints_Example extends NF_Auth_Endpoints_Endpoint
{
    protected $method = 'GET';
    protected $endpoint = 'example';

    function process()
    {
        echo json_encode( array( 'foo' => 'bar' ) );
    }
}