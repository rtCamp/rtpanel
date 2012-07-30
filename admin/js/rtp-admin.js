/**
 * rtPanel Admin Scripts
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
jQuery(document).ready(function() {

    var expand = false;
    var post_date_u = jQuery('#post_date_u').attr('checked');
    var post_date_l = jQuery('#post_date_l').attr('checked');
    var post_author_u = jQuery('#post_author_u').attr('checked');
    var post_author_l = jQuery('#post_author_l').attr('checked');
    var gravatar_fields = jQuery('#gravatar_show').attr('checked');
    var logo_show = jQuery('#logo_show').attr('checked');
    var favicon_show = jQuery('#favicon_show').attr('checked');
    var summary_show = jQuery('#summary_show').attr('checked');

    jQuery('input[name=rtp_reset]').click( function(){
        if ( !confirm('Are you sure you want to reset all the options?'))
            return false;
    });

    jQuery('.expand-collapse').live( 'click', function(){
        expand = false;
        jQuery('#normal-sortables .postbox').each( function() {
            if( jQuery(this).hasClass('closed') ) {
                expand = true;
            }
        });

        jQuery('#normal-sortables .postbox').each( function(){
            if ( expand ) {
                if( jQuery(this).hasClass('closed') ) {
                    jQuery(this).children('h3').trigger('click');
                }
            } else {
                if( !jQuery(this).hasClass('closed') ) {
                    jQuery(this).children('h3').trigger('click');
                }
            }
        });
        return false;
    } );

    date_format('u');
    date_format('l');

    jQuery('strong.rtpanel').parent().addClass('current');
    jQuery('strong.rtpanel').parent().parent().addClass('current');
    jQuery('.postbox .inside h3').remove();

    jQuery('.rtp_logo').change(function(){
        var imgurl;
        if( jQuery(this).val() == 'use_logo_url'){
            imgurl=jQuery('#logo_url').val();            
            if( imgurl!='' )
                jQuery('#logo_metabox img').attr('src', imgurl);
            jQuery('#logo_upload').attr('disabled', 'disabled');
            jQuery('#logo_url').removeAttr('disabled');
        } else {
            imgurl=jQuery('#logo_upload_url').val();            
            if( imgurl!='' )
                jQuery('#logo_metabox img').attr('src', imgurl);
            jQuery('#logo_url').attr('disabled','disabled');
            jQuery('#logo_upload').removeAttr('disabled');
        }
    })

    jQuery('.rtp_favicon').change(function(){
        var imgurl;
        if( jQuery(this).val()=='use_favicon_url'){
            imgurl=jQuery('#favicon_url').val();
            if( imgurl!='' )
                jQuery('#favicon_metabox  img').attr('src', imgurl);
            jQuery('#favicon_upload').attr('disabled', 'disabled');
            jQuery('#favicon_url').removeAttr('disabled');
        } else {
            imgurl=jQuery('#favicon_upload_url').val();
            if( imgurl!='' )
                jQuery('#favicon_metabox img').attr('src', imgurl);
            jQuery('#favicon_url').attr('disabled','disabled');
            jQuery('#favicon_upload').removeAttr('disabled');
        }
    })

    jQuery('#logo_url').keyup(function () {
        imgurl = jQuery(this).val();
        jQuery('#logo_metabox  img').attr('src', imgurl);
        jQuery('#logo_metabox  img').attr('alt', 'Logo / URL Not Valid');
    });

    jQuery('#favicon_url').keyup(function () {
        imgurl = jQuery(this).val();
        jQuery('#favicon_metabox img').attr('src', imgurl);
        jQuery('#favicon_metabox img').attr('alt', 'Favicon / URL Not Valid');
        imgurl = jQuery(this).val();
        var extension = imgurl.substr( (imgurl.lastIndexOf('.') +1) );
        if(extension != 'ico'){
            jQuery('#favicon_metabox img').attr('src','' );
            jQuery('#favicon_metabox img').attr('alt', 'Favicon / URL Not Valid');}

    });

    media_upload( '#logo_upload', '#logo_upload_url', '#logo_options', 'Logo' );
    media_upload( '#favicon_upload', '#favicon_upload_url', '#fav_options', 'Favicon' );

    toggle_handler( post_date_u, '.post_date_format_u', '#post_date_u' );
    toggle_handler( post_date_l, '.post_date_format_l', '#post_date_l' );
    toggle_handler( post_author_u, '.post_author_u-sub', '#post_author_u' );
    toggle_handler( post_author_l, '.post_author_l-sub', '#post_author_l' );
    toggle_handler( gravatar_fields, '.gravatar-size', '#gravatar_show' );
    toggle_handler( logo_show, '.show-fields-logo', '#logo_show' );
    toggle_handler( favicon_show, '.show-fields-favicon', '#favicon_show' );

    if (typeof summary_show !== 'undefined' && summary_show !== false) {
        jQuery('#post_thumbnail_options .inside .form-table').show();
        jQuery('#post_thumbnail_options .inside .rtp_submit').show();
        jQuery('#post_thumbnail_options .inside .post-summary-hide').hide();

        jQuery('#summary_show').click(function() {
            jQuery('#post_thumbnail_options .inside .form-table').toggle();
            jQuery('#post_thumbnail_options .inside .rtp_submit').toggle();
            jQuery('#post_thumbnail_options .inside .post-summary-hide').toggle();
        });
    } else {
        jQuery('#post_thumbnail_options .inside .form-table').hide();
        jQuery('#post_thumbnail_options .inside .rtp_submit').hide();
        jQuery('#post_thumbnail_options .inside .post-summary-hide').show();
        
        jQuery('#summary_show').click(function() {
            jQuery('#post_thumbnail_options .inside .form-table').toggle();
            jQuery('#post_thumbnail_options .inside .rtp_submit').toggle();
            jQuery('#post_thumbnail_options .inside .post-summary-hide').toggle();
        });
    }

    init_content('#post_summaries_options');
    init_content('#post_thumbnail_options');
    init_content('#pagination_options');
    contentshow_table('#post_summaries_options .inside .form-table tr.custom', '#summary_show');
    contentshow_table('#post_thumbnail_options .inside .form-table tr.custom', '#thumbnail_show');
    contentshow_table('#pagination_options .inside .form-table tr.custom', '#pagination_show');

});

/* Show and hide sections on checked */
function init_content( container ) {
    jQuery(container+' .inside .form-table tr:first').css('visibility','visible');
    jQuery(container+' .inside .form-table tr:first').css('display', 'block');
    jQuery(container+' .inside .form-table tr').addClass('custom');
    jQuery(container+' .inside .form-table tr:first').removeClass('custom');
}

function contentshow_table( container, event_handler ) {
    if( typeof jQuery(event_handler).attr('checked') !== 'undefined' && jQuery(event_handler).attr('checked') != false ) {
        jQuery( jQuery(container) ).css('visibility','visible');
        jQuery( jQuery(container) ).css('display','block');
    } else {
        jQuery( jQuery(container) ).css('visibility','hidden');
        jQuery( jQuery(container) ).css('display','none');
    }
    jQuery(event_handler).click(function () {
        if (( jQuery(container+':hidden').length > 1)) {
            jQuery( jQuery(container) ).css('visibility','visible');
            jQuery( jQuery(container) ).css('display','block');
        } else {
            jQuery( jQuery(container) ).css('visibility','hidden');
            jQuery( jQuery(container) ).css('display','none');
        }
        });
}
    
/* Format date according to changes in custom date field */
function date_format( position ) {
    jQuery('input[name="rtp_post_comments[post_date_format_'+position+']"]').click(function(){
        if ( 'post_date_custom_format_'+position != jQuery(this).attr('id') ) {
            if ( 'full-date-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rtp_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.full-date-'+position).text() );
            } else if ( 'y-m-d-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rtp_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.y-m-d-'+position).text() );
            } else if ( 'm-d-y-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rtp_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.m-d-y-'+position).text() );
            } else if ( 'd-m-y-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rtp_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.d-m-y-'+position).text() );
            }
            jQuery('#post_date_custom_format_'+position).val(jQuery(this).val());
            jQuery('#post_date_custom_format_'+position).siblings('label').attr('title', jQuery(this).val());
        }
    });

    jQuery('#custom-date-'+position).keyup(function () {
        jQuery('#post_date_custom_format_'+position).val(jQuery(this).val());
        jQuery('#post_date_custom_format_'+position).siblings('label').attr('title', jQuery(this).val());
    });

    jQuery('input[name="rtp_post_comments[post_date_custom_format_'+position+']"]').focus(function(){
        jQuery('#post_date_custom_format_'+position).attr('checked', 'checked');
    });

    jQuery('input[name="rtp_post_comments[post_date_custom_format_'+position+']"]').change( function() {
        var format = jQuery(this);
        format.siblings('img').css('visibility','visible');
        jQuery.post(ajaxurl, { action: 'date_format', date : format.val() }, function(d) { format.siblings('img').css('visibility','hidden'); format.siblings('span').text(d); } );
    });
}

/* Function to handle toggling of sub options */
function toggle_handler( the_option, the_class, the_id ) {
    if (typeof the_option !== 'undefined' && the_option !== false) {
        jQuery(the_class).show();
        jQuery(the_id).click(function(){
            jQuery(the_class).toggle();
        });
    } else {
        jQuery(the_class).hide();
        jQuery(the_id).click(function(){
            jQuery(the_class).toggle();
        });
    }
}

/* Function to upload files using the media library */
function media_upload( button_id, textbox_id, main_metabox_id, iframe_title ) {
    jQuery(button_id).click(function() {
        formfield = jQuery(textbox_id).attr('name');
        H = jQuery(window).height() - 80, W = ( 640 < jQuery(window).width() ) ? 640 : jQuery(window).width();
        tb_show( 'Upload '+iframe_title, 'media-upload.php?post_id=0&amp;rtp_theme=rtp_true&amp;logo_or_favicon='+iframe_title+'&amp;type=image&amp;TB_iframe=true&amp;width='+W+'&amp;height='+H);
        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            if( ( typeof(imgurl) !== 'undefined' ) && ( ( imgurl.match(/(.jpg|.jpeg|.jpe|.gif|.png|.bmp|.ico|.tif|.tiff)$/i) && ( iframe_title != 'Favicon' ) ) || ( imgurl.match(/(.ico)$/i) &&  ( iframe_title == 'Favicon' ) ) ) ) {
                jQuery(textbox_id).val(imgurl);
                jQuery(main_metabox_id+' .image-preview img').attr('src', imgurl);
                tb_remove();
            } else {
                if( iframe_title == 'Favicon' ) {
                    alert("Please select a valid favicon file (.ico)")
                } else {
                    alert("Please select a valid image file.");
                }
                tb_remove();
            }
        }
        return false;
    });
}

function delete_plugin_confirmation(plugin) {
    if (! confirm('Are you sure you want to delete \''+plugin+'\' plugin?')) { return false; }
    if ( plugin == 'rtPanel Hooks Editor'){
        jQuery('#rtp-hooks-editor-delete').val(1);
        jQuery('#rtp-hooks-editor-delete').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Subscribe To Comments'){
        jQuery('#subscribe-delete').val(1);
        jQuery('#subscribe-delete').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'WP PageNavi'){
        jQuery('#pagenavi-delete').val(1);
        jQuery('#pagenavi-delete').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Yoast WordPress SEO'){
        jQuery('#yoast_seo-delete').val(1);
        jQuery('#yoast_seo-delete').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Breadcrumb NavXT'){
        jQuery('#breadcrumb-delete').val(1);
        jQuery('#breadcrumb-delete').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Regenerate Thumbnails'){
        jQuery('#regenerate-delete').val(1);
        jQuery('#regenerate-delete').after('<input value="Save" name="rtp_submit" type="hidden" />');
    }
    jQuery('#rt_general_form').submit();
}

function activate_plugin(plugin) {
    if ( plugin == 'rtPanel Hooks Editor'){
        jQuery('#rtp-hooks-editor-activate').val(1);
        jQuery('#rtp-hooks-editor-activate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Subscribe To Comments'){
        jQuery('#subscribe-activate').val(1);
        jQuery('#subscribe-activate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'WP PageNavi'){
        jQuery('#pagenavi-activate').val(1);
        jQuery('#pagenavi-activate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Yoast WordPress SEO'){
        jQuery('#yoast_seo-activate').val(1);
        jQuery('#yoast_seo-activate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Breadcrumb NavXT'){
        jQuery('#breadcrumb-activate').val(1);
        jQuery('#breadcrumb-activate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Regenerate Thumbnails'){
        jQuery('#regenerate-activate').val(1);
        jQuery('#regenerate-activate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    }
    jQuery('#rt_general_form').submit();
}

function deactivate_plugin(plugin) {
    if ( plugin == 'rtPanel Hooks Editor'){
        jQuery('#rtp-hooks-editor-deactivate').val(1);
        jQuery('#rtp-hooks-editor-deactivate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Subscribe To Comments'){
        jQuery('#subscribe-deactivate').val(1);
        jQuery('#subscribe-deactivate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'WP PageNavi'){
        jQuery('#pagenavi-deactivate').val(1);
        jQuery('#pagenavi-deactivate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Yoast WordPress SEO'){
        jQuery('#yoast_seo-deactivate').val(1);
        jQuery('#yoast_seo-deactivate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Breadcrumb NavXT'){
        jQuery('#breadcrumb-deactivate').val(1);
        jQuery('#breadcrumb-deactivate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    } else if ( plugin == 'Regenerate Thumbnails'){
        jQuery('#regenerate-deactivate').val(1);
        jQuery('#regenerate-deactivate').after('<input value="Save" name="rtp_submit" type="hidden" />');
    }
    jQuery('#rt_general_form').submit();
}