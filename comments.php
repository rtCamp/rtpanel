<?php
/**
 * The template for displaying Comments on Single Page.
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

global $rtp_post_comments;
    if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
        die ( 'Please do not load this page directly. Thanks!' );
    }
    if ( post_password_required() ) { ?>
        <p class="alert"><?php _e( 'This post is password protected. Enter the password to view comments.', 'rtPanel' ); ?></p>
    <?php
        return;
    }
    ?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
    <div class="rtp-comment-count" id="comments">
        <span class="alignleft"><?php printf( _n( '<span class="count">%1$s</span> Comment', '<span class="count">%1$s</span> Comments', get_comments_number(), 'rtPanel' ), number_format_i18n( get_comments_number() ) ); ?></span>
    <?php if ( current_user_can( 'moderate_comments' ) ) { ?>
        <span class="alignright rtp-manage-comments"><a href="<?php echo get_admin_url( '', 'edit-comments.php?p=' . get_the_ID() ); ?>"><?php _e( 'Manage Comments', 'rtPanel' ); ?></a></span>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <ol class="commentlist">
    <?php
        $args = ( $rtp_post_comments['comment_separate'] ) ? 'callback=rtp_comment_list&type=comment' : 'callback=rtp_comment_list&type=all';
        wp_list_comments( $args );
    ?>
    </ol>
    <!-- ========== [ Comment pagination ] ========== -->
    <!-- can be controlled from "Dashboard >> Settings >> Discussion" -->
    <?php if ( get_previous_comments_link() || get_next_comments_link() ) { ?>
        <div class="rtp-comments-pagination">
            <div class="alignleft"><?php previous_comments_link( '&larr; '.__( 'Previous Comments', 'rtPanel' ) ); ?></div>
            <div class="alignright"><?php next_comments_link( __( 'Next Comments', 'rtPanel' ) . ' &rarr;' ); ?></div>
            <div class="clear"></div>
        </div>
    <?php } ?>
<?php else : // this is displayed if there are no comments so far
        if ( comments_open() ) :
            // If comments are open, but there are no comments.
        else : // comments are closed
        endif;
    endif;

// Including Comment form using comment_form() function
     if ( comments_open() ) :
        if ( $rtp_post_comments['name_email_url_show'] ) {
            update_option( 'require_name_email', 1 );
            if ( $rtp_post_comments['comment_textarea'] ) {
                $fields = '';
                if ( is_user_logged_in() ) {
                    $comments_after = '';
                } else {
                    $comments_after = '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /> <label for="author">' . __( 'Name', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>
                                       <p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" /> <label for="email">' . __( 'Email', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>
                                       <p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> <label for="url">' . __( 'Website', 'rtPanel' ) . '</label>' . '</p>';
                }                
            } else {
               $comments_after = '';
               $fields =  array(
                          'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /> <label for="author">' . __( 'Name', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
                          'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /> <label for="email">' . __( 'Email', 'rtPanel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
                          'url'    => '<p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> <label for="url">' . __( 'Website', 'rtPanel' ) . '</label>' . '</p>',
               );
           }
           $comments_before = '<p class="comment-notes">' . __( 'Your email address will not be published.', 'rtPanel' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</p>';
        } else {
            update_option( 'require_name_email', 0 );
            $fields = '';
            $comments_before = '';
            $comments_after = '';
        }

       /**
         *
         * $rt_comment_form_args = array( 'fields'=> $fields );
         *
         * Pass the $rt_comment_form_args to the comment_form() function after editing the $fields array to match the theme design need.
         * e.g comment_form($rt_comment_form_args);
         *
         * Set the $fields values for auther, email and url fields display.
         *
         */

           comment_form( array(
                'fields' => apply_filters( 'comment_form_default_fields', $fields ) ,
                'comment_notes_before' => $comments_before,
                'comment_notes_after' => $comments_after,
                'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8"></textarea></p>',
                'title_reply' => __( '<span class="comment-title">Leave a Comment</span>', 'rtPanel' ),
                'title_reply_to' => __( '<span class="comment-title">Leave a Comment</span>', 'rtPanel' ),
                'cancel_reply_link' => __( 'Cancel reply', 'rtPanel' ),
		'label_submit' => __( 'Submit', 'rtPanel' ),
           ) );

     endif; // if you delete this the sky will fall on your head

/*
 * Start of Pingback and Trackback comment list
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
    // This is a loop for printing pingbacks/trackbacks if there are any
    if ( $num_ping_backs != 0 ) : ?>
        <h3 class="rtp-comments-header"><span class="rtp-courly-bracket">{</span> <span class="count"><?php echo $num_ping_backs; ?></span> <?php ( $num_ping_backs == 1 ) ? _e( 'Trackback', 'rtPanel') : _e( 'Trackbacks', 'rtPanel' ); ?> <span class="rtp-courly-bracket">}</span></h3>
        <ol id="trackbacks"><?php
            foreach ( $comments as $comment ) :
                if ( get_comment_type() != "comment" ) :
                    $thiscomment = 'odd'; ?>
                    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( $thiscomment ); ?>><?php comment_author_link(); ?> <em>(<?php comment_type( __( 'Comment', 'rtPanel' ), __( 'Trackback', 'rtPanel' ), __( 'Pingback', 'rtPanel' ) ); ?>)</em></li><?php
                    $thiscomment = ( 'odd' == $thiscomment ) ? 'even' : 'odd';
                endif;
            endforeach; ?>
        </ol><?php
    endif;
} // End of Pingback and Trackback comment list
?>