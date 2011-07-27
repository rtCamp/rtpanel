<?php
/**
 * The template for displaying comments
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

    global $rtp_post_comments;

    if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
        die ( 'Please do not load this page directly. Thanks!' );
    }

    if ( post_password_required() ) { ?>
        <p class="alert"><?php _e( 'This post is password protected. Enter the password to view comments.', 'rtPanel' ); ?></p><?php
        return;
    }

    if ( have_comments() ) { ?>
        <div class="rtp-comment-count" id="comments">
            <span class="alignleft"><span class="rtp-courly-bracket">{ </span><?php printf( _n( '<span class="count">%1$s</span> Comment', '<span class="count">%1$s</span> Comments', get_comments_number(), 'rtPanel' ), number_format_i18n( get_comments_number() ) ); ?>... <?php printf( __( 'Add your <a href="%s" title="Add your thoughts">thoughts</a>', 'rtPanel' ), '#respond' ); ?> <span class="rtp-courly-bracket"> }</span></span>
            <?php if ( current_user_can( 'moderate_comments' ) ) { ?>
                    <span class="alignright rtp-manage-comments"><span class="rtp-courly-bracket">{ </span><a href="<?php echo get_admin_url( '', 'edit-comments.php?p=' . get_the_ID() ); ?>"><?php _e( 'Manage Comments', 'rtPanel' ); ?></a><span class="rtp-courly-bracket"> }</span></span>
            <?php } ?>
        </div>
        <div class="clear"></div>

        <ol class="commentlist"><?php
            $args = ( $rtp_post_comments['comment_separate'] ) ? 'callback=rtp_comment_list&type=comment' : 'callback=rtp_comment_list&type=all';
            wp_list_comments( $args ); ?>
        </ol>

        <!-- Comment Pagination --><?php
        if ( get_previous_comments_link() || get_next_comments_link() ) { ?>
            <div class="rtp-comments-pagination">
                <div class="alignleft"><?php previous_comments_link( '&larr; '.__( 'Previous Comments', 'rtPanel' ) ); ?></div>
                <div class="alignright"><?php next_comments_link( __( 'Next Comments', 'rtPanel' ) . ' &rarr;' ); ?></div>
                <div class="clear"></div>
            </div><?php
        }
    } else { // this is displayed if there are no comments so far
        if ( comments_open() ) {
            // If comments are open, but there are no comments.
        } else {
            // comments are closed
        }
    }
    
    // Including Comment form using comment_form() function
    if ( comments_open() ) {
        if ( $rtp_post_comments['hide_labels'] ) {
            $hide_class = ' hide-labels';
            $label_author = '';
            $author_value = 'Name';
            $label_email = '';
            $email_value = 'Email';
            $label_url = '';
            $url_value = 'Website';
            $comment_value = 'Comment';
        } else {
            $hide_class = '';
            $label_author = '<label for="author">' . __( 'Name', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' );
            $author_value = '';
            $label_email = '<label for="email">' . __( 'Email', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' );
            $email_value = '';
            $label_url = '<label for="url">' . __( 'Website', 'rtPanel' ) . '</label> ';
            $url_value = '';
            $comment_value = '';
        }

        if ( $rtp_post_comments['comment_textarea'] ) {
            $fields = '';
            if ( $rtp_post_comments['compact_form'] ) {
                $comments_after = '<p class="comment-form-author compact-comment-form' . $hide_class . '">' . $label_author . '<input id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : $author_value ) . '" size="30" /></p>
                                    <p class="comment-form-email compact-comment-form' . $hide_class . '">' . $label_email . '<input id="email" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : $email_value ) . '" size="30" /></p>
                                    <p class="comment-form-url compact-comment-form' . $hide_class . '">' . $label_url . '<input id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : $url_value ) . '" size="30" /></p>';
            } else {
                $comments_after = '<p class="comment-form-author' . $hide_class . '"><input class="alignleft" id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : $author_value ) . '" size="30" />' . $label_author . '</p>
                                    <p class="comment-form-email' . $hide_class . '"><input class="alignleft" id="email" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : $email_value ) . '" size="30" />' . $label_email . '</p>
                                    <p class="comment-form-url' . $hide_class . '"><input class="alignleft" id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : $url_value ) . '" size="30" />' . $label_url . '</p>';
            }
        } else {
           if ( $rtp_post_comments['compact_form'] ) {
                $comments_after = '';
                $fields =  array(
                          'author' => '<p class="comment-form-author compact-comment-form' . $hide_class . '">' . $label_author . '<input id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : $author_value ) . '" size="30" /></p>',
                          'email'  => '<p class="comment-form-email compact-comment-form' . $hide_class . '">' . $label_email . '<input id="email" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : $email_value ) . '" size="30" /></p>',
                          'url'    => '<p class="comment-form-url compact-comment-form' . $hide_class . '">' . $label_url . '<input id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : $url_value ) . '" size="30" /></p>',
                 );
           } else {
               $comments_after = '';
               $fields =  array(
                          'author' => '<p class="comment-form-author' . $hide_class . '"><input class="alignleft" id="author" name="author" type="text" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : $author_value ) . '" size="30" />' . $label_author . '</p>',
                          'email'  => '<p class="comment-form-email' . $hide_class . '"><input class="alignleft" id="email" name="email" type="text" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : $email_value ) . '" size="30" />' . $label_email . '</p>',
                          'url'    => '<p class="comment-form-url' . $hide_class . '"><input class="alignleft" id="url" name="url" type="text" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : $url_value ) . '" size="30" />' . $label_url . '</p>',
               );
           }
        }
       
       $comments_before = '<p class="comment-notes">' . __( 'Your email address will not be published.', 'rtPanel' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</p>';

       comment_form( array(
                'fields' => apply_filters( 'comment_form_default_fields', $fields ) ,
                'comment_notes_before' => $comments_before,
                'comment_notes_after' => $comments_after,
                'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8">Comment...</textarea></p>',
                'title_reply' => __( '<span class="comment-title">Leave a Comment</span>', 'rtPanel' ),
                'title_reply_to' => __( '<span class="comment-title">Leave a Comment</span>', 'rtPanel' ),
                'cancel_reply_link' => __( 'Cancel reply', 'rtPanel' ),
                'label_submit' => __( 'Submit', 'rtPanel' ),
            )
       );

    } // if you delete this the sky will fall on your head

    /*
     * Pingbacks and/or Trackbacks
     */
    if ( $rtp_post_comments['comment_separate'] ) {
        $num_ping_backs = 0;
        $num_comments  = 0;

        // Loop throught comments to count these totals
        foreach ( $comments as $comment ) {
            if ( get_comment_type() != "comment" ) {
                $num_ping_backs++;
            } else {
                $num_comments++;
            }
        }

        if ( $num_ping_backs != 0 ) { ?>
            <h3 class="rtp-comments-header"><span class="rtp-courly-bracket">{</span> <span class="count"><?php echo $num_ping_backs; ?></span> <?php ( $num_ping_backs == 1 ) ? _e( 'Trackback', 'rtPanel') : _e( 'Trackbacks', 'rtPanel' ); ?> <span class="rtp-courly-bracket">}</span></h3>
            <ol id="trackbacks"><?php
                foreach ( $comments as $comment ) {
                    if ( get_comment_type() != "comment" ) {
                        $thiscomment = 'odd'; ?>
                        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( $thiscomment ); ?>><?php comment_author_link(); ?> <em>(<?php comment_type( __( 'Comment', 'rtPanel' ), __( 'Trackback', 'rtPanel' ), __( 'Pingback', 'rtPanel' ) ); ?>)</em></li><?php
                        $thiscomment = ( 'odd' == $thiscomment ) ? 'even' : 'odd';
                    }
                } ?>
            </ol><?php
        }
    } // End of Pingbacks and/or Trackbacks
?>