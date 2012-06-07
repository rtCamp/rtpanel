<?php
/**
 * The template for displaying Image Attachments
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.1
 */
get_header(); ?>

    <section id="content" class="rtp-grid-12">
        <?php rtp_hook_begin_content(); ?>

        <?php 
        while( have_posts() ) {
            the_post(); ?>
            <div class="rtp-navigation clearfix">
                <div class="alignleft"><a role="link" href="<?php echo get_permalink( $post->post_parent ); ?>">&larr; <?php echo get_the_title( $post->post_parent ); ?></a></div>
            </div>

            <article <?php post_class( 'rtp-image-box' ); ?>>
                <?php rtp_hook_begin_post(); ?>

                <header class="post-header clearfix">
                    <?php rtp_hook_begin_post_title(); ?>

                    <?php   if ( is_singular() ) { ?>
                                <h1 class="post-title"><?php the_title(); ?></h1><?php
                            } else { ?>
                                <h2 class="post-title"><a role="link" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permanent Link to %s', 'rtPanel' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2><?php
                            } ?>

                    <?php rtp_hook_end_post_title(); ?>

                    <?php rtp_hook_post_meta( 'top' ); ?>

                </header><!-- .post-title -->

                <div class="post-content clearfix">
                    <?php rtp_hook_begin_post_content(); ?><?php

                    $img_info = wp_get_attachment_image_src( '', 'full' ); ?>

                    <figure role="img" class="wp-caption aligncenter" aria-describedby="figcaption_attachment_<?php echo get_the_ID(); ?>">
                        <a role="link" href="<?php echo $img_info[0]; ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo wp_get_attachment_image( '', 'full' ); ?></a><?php
                        echo ( get_the_excerpt() ) ? '<figcaption id="figcaption_attachment_' . get_the_ID() . '" class="wp-caption-text">' . get_the_excerpt() . '</figcaption>' : ''; ?>
                    </figure>

                    <?php the_content(); ?>

                    <?php 
                        $args = array(
                            'numberposts'   => -1,
                            'order'         => 'ASC',
                            'post_mime_type'=> 'image',
                            'post_parent'   => $post->post_parent,
                            'post_status'   => null,
                            'post_type'     => 'attachment'
                        );

                        $attachments = get_children( $args );

                        if ( $attachments ) { ?>
                            <ul role="list" class="rtp-sibling-attachments rtp-container-12 rtp-alpha rtp-omega clearfix"><?php
                                $count = 1;
                                foreach( $attachments as $attachment ) {
                                    if ( get_the_ID() != $attachment->ID ) {
                                        $alpha_omega = NULL;
                                        if ( $count % 6 == 1 ) {
                                            $alpha_omega = ' rtp-alpha';
                                        } elseif ( $count %6 == 0 ) {
                                            $alpha_omega = ' rtp-omega';
                                        }
                                        echo '<li role="listitem" class="rtp-grid-2' . $alpha_omega . '">' . wp_get_attachment_link( $attachment->ID, 'thumbnail', true ) . '</li>';
                                        $count++;
                                    }
                                } ?>
                            </ul><?php
                        } ?>

                    <?php rtp_hook_end_post_content(); ?>

                </div><!-- .post-content -->

                <?php rtp_hook_post_meta( 'bottom' ); ?>

                <?php rtp_hook_end_post(); ?>
            </article><!-- .rtp-post-box --><?php
            rtp_hook_comments();
        } ?>

        <?php rtp_hook_end_content(); ?>
    </section><!-- #content -->

<?php get_footer(); ?>