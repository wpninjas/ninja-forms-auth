<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Auth extends NF_Auth_Plugin
{
    public function __construct( $version, $file )
    {
        parent::__construct( $version, $file );

        $this->endpoint = new NF_Auth_Endpoints_Example();
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
