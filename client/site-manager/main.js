jQuery( document ).ready(function() {

    var $siteSelect = jQuery( '<select></select>' );
    jQuery.each( nfSiteManager.sites, function ( client_id, site ){
        console.log( client_id );
        console.log( site );
        $siteSelect.append( '<option value="' + client_id + '">' + site + '</option>' );
    } );

    var $pluginList = jQuery('<ul></ul>');
    nfSiteManager.licenses.forEach(function (license) {

        console.log( license );

        if (!license.label) return
        var installed = ( license.sites.includes( $siteSelect.val() ) )
            ? '<button disabled="disabled">Active</button>'
            : '<button>Activate</button>';
        $pluginList.append('<li>' + license.label + ' (' + installed + ')</li>');
    });


    jQuery( '#nfSiteManager' ).append( $siteSelect );
    jQuery( '#nfSiteManager' ).append( $pluginList );
});
