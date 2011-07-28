<?php
/**
 * rtPanel Custom Comments List
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

/**
 * Displays the Comment List
 * 
 * @uses $rtp_post_comments Array 
 * @param Object $comment The Comment Objects
 * @param Array $args The default arguments to override
 * @param Int $depth The Depth of threaded comments
 *
 * @since rtPanel 2.0
 */
function rtp_comment_list( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    global $rtp_post_comments;
?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment-author">
                    <cite class="fn"><?php comment_author_link(); ?></cite>
                    <span class="comment-meta">
                        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php comment_date(); ?>">
                            <abbr title="<?php comment_date(); ?>"><?php printf( __( '%1$s at %2$s', 'rtPanel' ), get_comment_date(), get_comment_time() ); ?></abbr>
                        </a>
                        <?php edit_comment_link( __( 'edit', 'rtPanel' ), '<span class="rtp-edit-link"><span class="rtp-courly-bracket">[ </span>', '<span class="rtp-courly-bracket"> ]</span></span>' ); ?>
                    </span>
                    <?php echo ( $comment->comment_approved == '0' ) ? '<em>' . _e( 'Your comment is awaiting moderation. ', 'rtPanel' ) . '</em>' : ''; ?>
                </div><!-- .comment-author --><?php
                    if ( $rtp_post_comments['gravatar_show'] ) { //check if gravatar support is enabled
                        $gravatar_size = $rtp_post_comments['gravatar_size']; ?>
                        <div class="vcard">
                            <?php echo get_avatar( $comment, $gravatar_size ); ?>
                        </div><!-- .vcard -->
                <?php } ?>
                <div class="comment-text"><?php comment_text(); ?></div>
                <div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '<p>', 'after' => '</p>', 'reply_text' => __( 'Reply <span class="rtp-courly-bracket">&rarr;</span>', 'rtPanel' ), ) ) ); ?></div>
            </div><!-- .comment-body --><?php
} ?>