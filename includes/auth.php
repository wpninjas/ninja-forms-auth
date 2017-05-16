<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Auth extends NF_Auth_Plugin
{
    public function __construct( $version, $file )
    {
        parent::__construct( $version, $file );

        (new NF_Auth_Integrations_WPOAuthServer_Endpoints_Register())->init();
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
