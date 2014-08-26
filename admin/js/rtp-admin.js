/**
 * rtPanel Admin Scripts
 *
 * @package rtPanel
 *
 * @since rtPanel 1.1
 */

jQuery( document ).ready( function() {

	/* Plugins */
	jQuery( '.rtp-manage-plugin  a.rtp-manage-plugin-action' ).click( function( e ) {
		var elem = jQuery( this ),
				plugin_action = elem.data( 'action' ),
				plugin = elem.data( 'plugin' ),
				plugin_title = elem.data( 'plugin-title' ),
				nonce = elem.data( 'nonce' ),
				that = this;

		if ( plugin_action === 'purchase' ) {
			return true;
		} else {
			e.preventDefault();
		}

		if ( elem.hasClass( 'delete' ) && !confirm( 'Are you sure you want to delete "' + plugin_title + '" plugin' ) ) {
			return false;
		}

		//@todo:Add Loading
		var siteUrl = elem.attr( 'data-site-url' );
		elem.after( '<img class="rtp-ajax-loder" src="' + siteUrl + '/img/ajax-loader.gif" alt="loader" />' );

		jQuery.ajax( {
			url: ajaxurl,
			type: 'post',
			data: { 'action': 'rtpanel_plugin_manage', 'plugin_action': jQuery( this ).data( 'action' ), 'plugin': jQuery( this ).data( 'plugin' ), 'nonce': jQuery( this ).data( 'nonce' ) },
			success: function( data ) {
				if ( data.success === false ) {
					//@todo:Handle Error : data.data - for error messege
				} else {
					location.reload();
					jQuery( '.rtp-ajax-loder' ).remove();
				}
			}
		} );
	} );

	/*
	 * Tabs
	 */
	var tab = jQuery( '.rtp-tabs a' ),
			tab_content = jQuery( '.tab-content' );

	/* Hide All Tab Contents */
	tab_content.hide();

	/* Show First Tab Content */
	tab_content.first().show();

	/* Add active Class to first Tab */
	tab.first().addClass( 'nav-tab-active' );

	/* Click Event */
	tab.on( 'click', function( e ) {
		e.preventDefault();

		var elem = jQuery( this );

		if ( !elem.hasClass( 'nav-tab-active' ) ) {

			/* Remove Active Class From All Tabs */
			tab.removeClass( 'nav-tab-active' );

			/* Hide All Tab Contents */
			tab_content.hide();

			/* Add Active Class to Current Tab */
			elem.addClass( 'nav-tab-active' );

			/* Show Active Tab Content */
			var activeTab = elem.attr( 'href' );
			jQuery( activeTab ).fadeIn();
		}
	} );

	/*
	 * 
	 */
	jQuery( '#rtpanel-submit-request' ).click( function() {
		var flag = true;
		var name = jQuery( '#name' ).val();
		var email = jQuery( '#email' ).val();
		var website = jQuery( '#website' ).val();
		var phone = jQuery( '#phone' ).val();
		var subject = jQuery( '#subject' ).val();
		var details = jQuery( '#details' ).val();
		var request_type = jQuery( 'input[name="request_type"]' ).val();
		var request_id = jQuery( 'input[name="request_id"]' ).val();
		var server_address = jQuery( 'input[name="server_address"]' ).val();
		var ip_address = jQuery( 'input[name="ip_address"]' ).val();
		var server_type = jQuery( 'input[name="server_type"]' ).val();
		var user_agent = jQuery( 'input[name="user_agent"]' ).val();
		var form_data = { name: name, email: email, website: website, phone: phone, subject: subject, details: details, request_id: request_id, request_type: 'premium_support', server_address: server_address, ip_address: ip_address, server_type: server_type, user_agent: user_agent };
		if ( request_type == "bug_report" ) {
			var wp_admin_username = jQuery( '#wp_admin_username' ).val();
			if ( wp_admin_username == "" ) {
				alert( "Please enter WP Admin Login." );
				return false;
			}
			var wp_admin_pwd = jQuery( '#wp_admin_pwd' ).val();
			if ( wp_admin_pwd == "" ) {
				alert( "Please enter WP Admin password." );
				return false;
			}
			var ssh_ftp_host = jQuery( '#ssh_ftp_host' ).val();
			if ( ssh_ftp_host == "" ) {
				alert( "Please enter SSH / FTP host." );
				return false;
			}
			var ssh_ftp_username = jQuery( '#ssh_ftp_username' ).val();
			if ( ssh_ftp_username == "" ) {
				alert( "Please enter SSH / FTP login." );
				return false;
			}
			var ssh_ftp_pwd = jQuery( '#ssh_ftp_pwd' ).val();
			if ( ssh_ftp_pwd == "" ) {
				alert( "Please enter SSH / FTP password." );
				return false;
			}
			form_data = { name: name, email: email, website: website, phone: phone, subject: subject, details: details, request_id: request_id, request_type: 'premium_support', server_address: server_address, ip_address: ip_address, server_type: server_type, user_agent: user_agent, wp_admin_username: wp_admin_username, wp_admin_pwd: wp_admin_pwd, ssh_ftp_host: ssh_ftp_host, ssh_ftp_username: ssh_ftp_username, ssh_ftp_pwd: ssh_ftp_pwd };
		}
		for ( formdata in form_data ) {
			if ( form_data[formdata] == "" && formdata != 'phone' ) {
				alert( "Please enter " + formdata.replace( "_", " " ) + " field." );
				return false;
			}
		}
		data = {
			action: "rtpanel_submit_request",
			form_data: form_data
		};
		jQuery.post( ajaxurl, data, function( data ) {
			data = data.trim();
			if ( data == "false" ) {
				alert( "Please fill all the fields." );
				return false;
			}
			jQuery( '#rtpanel_service_contact_container' ).empty();
			jQuery( '#rtpanel_service_contact_container' ).append( data );
		} );
		return false;
	} );

} );