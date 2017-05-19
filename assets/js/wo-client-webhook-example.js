jQuery( document ).ready( function(){
    var $link = jQuery( "<a href='" + example_webhook.href + "' target='_blank'>Verify</a>" );
    var $redirect_uri = jQuery( 'input[name=redirect_uri]' );
    $redirect_uri.before( $link );
});