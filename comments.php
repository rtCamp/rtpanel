<?php
/**
 * The template for displaying comments
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

    global $rtp_post_comments;

    if ( post_password_required() ) { ?>
        <p class="alert"><?php _e( 'This post is password protected. Enter the password to view comments.', 'rtPanel' ); ?></p><?php
        return;
    } ?>

    <div class="comments-container"><?php
        if ( have_comments() ) { ?>
            <div class="rtp-comment-count" id="comments">
                <?php 
                add_filter( 'get_comments_number', 'rtp_only_comment_count', 11, 2 );
                $comment_count = sprintf( _n( '<span class="count">%1$s</span> Comment', '<span class="count">%1$s</span> Comments', get_comments_number(), 'rtPanel' ), number_format_i18n( get_comments_number() ) ) . '... ';
                $comment_count .= ( comments_open() ) ? sprintf( __( '<span class="rtp-thoughts">Add your <a href="%s" title="Add your thoughts">thoughts</a></span>', 'rtPanel' ), '#respond' ) : '';
                remove_filter( 'get_comments_number', 'rtp_only_comment_count' );
                if ( ( get_comments_number() && comments_open() ) || get_comments_number() ) { ?>
                    <h2><?php echo $comment_count; ?></h2><?php
                } ?>
                <?php if ( current_user_can( 'moderate_comments' ) ) { ?>
                        <span class="alignright rtp-manage-comments"><span class="rtp-curly-bracket">{ </span><a href="<?php echo get_admin_url( '', 'edit-comments.php?p=' . get_the_ID() ); ?>"><?php _e( 'Manage Comments', 'rtPanel' ); ?></a><span class="rtp-curly-bracket"> }</span></span>
                <?php } ?>
            </div><!-- .rtp-comment-count -->

            <ol class="commentlist"><?php
                $args = ( $rtp_post_comments['comment_separate'] ) ? 'callback=rtp_comment_list&type=comment' : 'callback=rtp_comment_list&type=all';
                wp_list_comments( $args ); ?>
            </ol><!-- .commentlist -->

            <!-- Comment Pagination --><?php
            if ( get_previous_comments_link() || get_next_comments_link() ) { ?>
                <div class="rtp-comments-pagination">
                    <div class="alignleft"><?php previous_comments_link( '&larr; '.__( 'Previous Comments', 'rtPanel' ) ); ?></div>
                    <div class="alignright"><?php next_comments_link( __( 'Next Comments', 'rtPanel' ) . ' &rarr;' ); ?></div>
                    <div class="clear"></div>
                </div><?php
            }
        }

        // Including Comment form using comment_form() function
        if ( ( !is_attachment() && comments_open() ) || ( is_attachment() && $rtp_post_comments['attachment_comments'] ) ) {
            if ( $rtp_post_comments['hide_labels'] ) {
                $hide_class = ' hide-labels';
                $label_author = '';
                $author_value = __( 'Name*', 'rtPanel' );
                $label_email = '';
                $email_value = __( 'Email*', 'rtPanel' );
                $label_url = '';
                $url_value = __( 'Website', 'rtPanel' );
            } else {
                $hide_class = '';
                $label_author = '<label for="author">' . __( 'Name', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' );
                $author_value = '';
                $label_email = '<label for="e-mail">' . __( 'Email', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' );
                $email_value = '';
                $label_url = '<label for="url">' . __( 'Website', 'rtPanel' ) . '</label> ';
                $url_value = '';
            }

            if ( $rtp_post_comments['comment_textarea'] && !is_user_logged_in() ) {
                $fields = '';
                if ( $rtp_post_comments['compact_form'] ) {
                    $comments_after = '<p class="comment-form-author compact-comment-form' . $hide_class . '">' . $label_author . '<input id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_name_placeholder', $author_value ). '" size="30" /></p>
                                        <p class="comment-form-email compact-comment-form' . $hide_class . '">' . $label_email . '<input id="e-mail" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_email_placeholder', $email_value ) . '" size="30" /></p>
                                        <p class="comment-form-url compact-comment-form' . $hide_class . '">' . $label_url . '<input id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_website_placeholder', $url_value ) . '" size="30" /></p>';
                } else {
                    $comments_after = '<p class="comment-form-author' . $hide_class . '"><input class="alignleft" id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_name_placeholder', $author_value ) . '" size="30" />' . $label_author . '</p>
                                        <p class="comment-form-email' . $hide_class . '"><input class="alignleft" id="e-mail" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_email_placeholder', $email_value ) . '" size="30" />' . $label_email . '</p>
                                        <p class="comment-form-url' . $hide_class . '"><input class="alignleft" id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_website_placeholder', $url_value ) . '" size="30" />' . $label_url . '</p>';
                }
            } else {
               if ( $rtp_post_comments['compact_form'] ) {
                    $comments_after = '';
                    $fields =  array(
                              'author' => '<p class="comment-form-author compact-comment-form' . $hide_class . '">' . $label_author . '<input id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_name_placeholder', $author_value ) . '" size="30" /></p>',
                              'email'  => '<p class="comment-form-email compact-comment-form' . $hide_class . '">' . $label_email . '<input id="e-mail" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_email_placeholder', $email_value ) . '" size="30" /></p>',
                              'url'    => '<p class="comment-form-url compact-comment-form' . $hide_class . '">' . $label_url . '<input id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_website_placeholder', $url_value ) . '" size="30" /></p>',
                     );
               } else {
                   $comments_after = '';
                   $fields =  array(
                              'author' => '<p class="comment-form-author' . $hide_class . '"><input class="alignleft" id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_name_placeholder', $author_value ) . '" size="30" />' . $label_author . '</p>',
                              'email'  => '<p class="comment-form-email' . $hide_class . '"><input class="alignleft" id="e-mail" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_email_placeholder', $email_value ) . '" size="30" />' . $label_email . '</p>',
                              'url'    => '<p class="comment-form-url' . $hide_class . '"><input class="alignleft" id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : '' ) . '" placeholder="' . apply_filters( 'rtp_website_placeholder', $url_value ) . '" size="30" />' . $label_url . '</p>',
                   );
               }
            }

           $comments_before = '<p class="comment-notes">' . __( 'Your email address will not be published.', 'rtPanel' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</p>';

           comment_form( array(
                    'fields' => apply_filters( 'comment_form_default_fields', $fields ) ,
                    'comment_notes_before' => $comments_before,
                    'comment_notes_after' => $comments_after,
                    'comment_field' => '<p class="comment-form-comment"><textarea id="comment"  placeholder="' . apply_filters( 'rtp_comment_placeholder', __( 'Comment...', 'rtPanel' ) ) . '" name="comment" cols="45" rows="8"></textarea></p>',
                    'title_reply' => '<span class="comment-title">' . __( 'Leave a Comment', 'rtPanel' ) . '</span>',
                    'title_reply_to' => '<span class="comment-title">' . __( 'Leave a Comment', 'rtPanel' ) . '</span>',
                    'cancel_reply_link' => __( 'Cancel reply', 'rtPanel' ),
                    'label_submit' => __( 'Submit', 'rtPanel' ),
                )
           );

        } // if you delete this the sky will fall on your head
    
        /*
         * Pingbacks and/or Trackbacks
         */
        add_filter( 'get_comments_number', 'pingback_trackback_count', 11, 2 );
        if ( $rtp_post_comments['comment_separate'] && get_comments_number() ) { ?>
                <h3 class="rtp-comments-header"><span class="rtp-curly-bracket">{</span> <span class="count"><?php echo get_comments_number(); ?></span> <?php ( 1 == get_comments_number() ) ? _e( 'Trackback', 'rtPanel') : _e( 'Trackbacks', 'rtPanel' ); ?> <span class="rtp-curly-bracket">}</span></h3>
                <ol id="trackbacks"><?php
                        $args = 'callback=rtp_ping_list&type=pings';
                        wp_list_comments( $args ); ?>
                </ol><?php
        } // End of Pingbacks and/or Trackbacks
        remove_filter( 'get_comments_number', 'pingback_trackback_count' )?>
    </div>