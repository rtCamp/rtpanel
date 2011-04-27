<?php
/**
 * The template for displaying Custom Comment List
 * 
 * @uses $rtp_post_comments Array 
 * @param Object $comment The Comment Objects
 * @param Array $args The default arguments to override
 * @param Int $depth The Depth of threaded comments
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */
function rtp_comment_list( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    global $rtp_post_comments; //get the theme options

    if ( !empty( $comment->comment_type ) ) { ?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( $thiscomment ); ?>><?php comment_author_link(); ?><em>(<?php comment_type( __( 'Comment', 'rtPanel' ), __( 'Trackback', 'rtPanel' ), __( 'Pingback', 'rtPanel' ) ); ?>)</em><?php
    } else { ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-body"> <!-- comment-body begins -->
                <div class="comment-author">
                    <cite class="fn"><?php comment_author_link(); ?></cite>
                    <span class="comment-meta">
                        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php comment_date(); ?>">
                            <abbr title="<?php comment_date(); ?>"><?php printf( __( '%1$s at %2$s', 'rtPanel' ), get_comment_date(), get_comment_time() ); ?></abbr>
                        </a>
                        <?php edit_comment_link( __( 'Edit', 'rtPanel' ), '<span class="rtp-edit-link"><span class="rtp-courly-bracket"> .&nbsp; </span>', '</span>' ); ?>
                    </span>
                    <?php echo ( $comment->comment_approved == '0' ) ? '<em>' . _e( 'Your comment is awaiting moderation. ', 'rtPanel' ) . '</em>' : ''; ?>
                </div><!-- .comment-author --><?php
                    if ( $rtp_post_comments['gravatar_show'] ) { //check if gravatar support is enabled
                        $gravatar_size = explode( ' ', $rtp_post_comments['gravatar_size'] ); //take the gravatar size from rtpanel options ( exploding since format in rtpanel options is 64 x 64 ); ?>
                        <div class="vcard"> <!-- vcard begins -->
                            <?php echo get_avatar( $comment, $gravatar_size[0] ); ?>
                        </div> <!-- end vcard -->
                <?php } ?>
                <div class="comment-text"><?php comment_text(); ?></div>
                <div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '<p>', 'after' => '</p>', 'reply_text' => __( 'Reply <span class="rtp-courly-bracket">&#8629;</span>', 'rtPanel' ), ) ) ); ?></div>
            </div> <!-- end comment-body --><?php
    } //if comment type
} ?>