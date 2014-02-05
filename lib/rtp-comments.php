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
	$GLOBALS[ 'comment' ] = $comment;
	global $rtp_post_comments;
	?>
	<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID(); ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix"><?php
	if ( $rtp_post_comments[ 'gravatar_show' ] ) { // check if gravatar support is enabled
		if ( isset( $rtp_post_comments[ 'gravatar_size' ] ) ) {
			$gravatar_size = apply_filters( 'rtp_gravatar_size', $rtp_post_comments[ 'gravatar_size' ] );
		} else {
			$gravatar_size = apply_filters( 'rtp_gravatar_size', 48 );
		}
		?>
		<div class="vcard">
			<?php echo get_avatar( $comment, $gravatar_size );
			rtp_hook_after_comment_author_avatar()
			?>
		</div><?php
}
			?>

		<div class="comment-author clearfix <?php echo ( $rtp_post_comments[ 'gravatar_show' ] ) ? '' : 'no-gravatar'; ?>">
			<cite class="fn"><?php comment_author_link(); ?></cite>
			<span class="comment-meta">
				<a class="rtp-common-link rtp-comment-date" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php comment_date(); ?>">
					<time datetime="<?php comment_date( 'Y-m-d' ); ?>"><?php printf( __( '%1$s at %2$s', 'rtPanel' ), get_comment_date(), get_comment_time() ); ?></time>
				</a>
			<?php edit_comment_link( __( '[ edit ]', 'rtPanel' ) ); ?>
			</span>
			<?php echo ( $comment->comment_approved == '0' ) ? '<span class="rtp-comment-await">' . __( 'Your comment is awaiting moderation. ', 'rtPanel' ) . '</span>' : ''; ?>
		</div>

		<div class="comment-text">
			<?php comment_text(); ?>
		</div>
		<div class="rtp-reply rtp-common-link"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ], 'reply_text' => __( 'Reply', 'rtPanel' ), ) ) ); ?></div>

	</div><!-- .comment-body --><?php
}

/**
 * Displays the Pingback/Trackback List
 *
 * @uses $rtp_post_comments Array
 * @param Object $comment The Comment Objects
 *
 * @since rtPanel 2.0
 */
function rtp_ping_list( $comment ) {
	$GLOBALS[ 'comment' ] = $comment;
	global $rtp_post_comments;
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>><?php comment_author_link(); ?> <em>(<?php comment_type( __( 'Comment', 'rtPanel' ), __( 'Trackback', 'rtPanel' ), __( 'Pingback', 'rtPanel' ) ); ?>)</em><?php
}

/**
 * Retrieve the only the amount of comments ( excluding Pingback/Trackbacks ) a post has.
 *
 * @param int $count The Comment Count
 * @param int $post_id The Post ID
 * @return int The number of Comments a post has
 *
 * @since rtPanel 2.1
 */
function rtp_only_comment_count( $count, $post_id ) {
	$comments		 = get_approved_comments( $post_id );
	$comment_count	= 0;
	foreach ( $comments as $comment ) {
		if ( $comment->comment_type == '' ) {
			$comment_count++;
		}
	}
	return $comment_count;
}

/**
 * Retrieve the amount of Pingback/Trackbacks a post has.
 *
 * @param int $count The Comment Count
 * @param int $post_id The Post ID
 * @return int The number of Pingback/Trackbacks a post has
 *
 * @since rtPanel 2.0
 */
function pingback_trackback_count( $count, $post_id ) {
	$comments		 = get_approved_comments( $post_id );
	$pingtrack_count = 0;
	foreach ( $comments as $comment ) {
		if ( $comment->comment_type != '' ) {
			$pingtrack_count++;
		}
	}
	return $pingtrack_count;
}