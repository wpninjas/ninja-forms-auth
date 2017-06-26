//console.log(eddStuff);
//console.log(oauthStuff);
jQuery('document').ready(function(){
    var html = '<select id="site-select">';
    for( var site in oauthStuff.client_data ) {
        site = oauthStuff.client_data[site];
        html += '<option value="' + site.url + '"';
        if (site.id == oauthStuff.current_site) {
            html += ' selected';
            var current = site.url;
        };
        html += '>' + site.url + '</option>';
    };
    html += '</select><div id="plugin-list"></div>';
    jQuery(".entry-content").html(html);
    jQuery("#plugin-list").html(updateSiteList(current));
    jQuery("#site-select").change(function(e) {
        var site = e.target.value;
        jQuery("#plugin-list").html(updateSiteList(site));
    });
    function updateSiteList( site ) {
        var plugins = '';
        for(var plugin in eddStuff) {
            plugin = eddStuff[plugin];
            if( 0 <= plugin.slug.indexOf('membership')) continue;
            plugins += '<p><div>' + plugin.label + '</div><div>';
            if( 0 <= plugin.sites.indexOf(site)) {
                plugins += 'Active';
            } else {
                plugins += '<a href="https://s23156.p100.sites.pressdns.com/wp-admin/?nf_install_license=' + plugin.id + '&nf_install_client=' + getClientID(jQuery("#site-select").val()) + '" target="_blank">Activate</a>';
            }
            plugins += '</div></p>'; 
        };
        return plugins;
    }
    function getClientID( site ) {
        for(var client in oauthStuff.client_data) {
            client = oauthStuff.client_data[client];
            if(client.url == site) return client.id;
        }
        return 0;
    }
});