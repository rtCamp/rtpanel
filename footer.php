<?php
/**
 * The template for displaying the footer
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
global $rtp_general;

rtp_hook_end_content_row();
?>

</div> <!-- End of content-wrapper row -->

<?php rtp_hook_end_content_wrapper(); ?>

</div><!-- #content-wrapper -->

<?php rtp_hook_after_content_wrapper(); ?>



<footer id="footer-wrapper" role="contentinfo" class="clearfix rtp-footer-wrapper rtp-section-wrapper">
	<?php rtp_hook_before_footer(); ?>

	<div id="footer" class="rtp-footer rtp-section-container row">
		<?php rtp_hook_begin_footer(); ?>

		<?php $rtp_set_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' ); ?>
		<div class="rtp-footer-section <?php echo esc_attr( $rtp_set_grid_class ); ?>">
			<?php rtp_hook_within_footer(); ?>
		</div>

		<?php rtp_hook_end_footer(); ?>
	</div><!-- #footer -->

	<?php rtp_hook_after_footer(); ?>

</footer><!-- #footer-wrapper-->

<?php rtp_hook_end_main_wrapper(); ?>

</div><!-- #main-wrapper -->

<?php wp_footer(); ?>
</body>
</html>