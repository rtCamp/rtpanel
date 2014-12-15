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

<?php rtp_hook_before_footer(); ?>

<footer id="footer-wrapper" role="contentinfo" class="clearfix rtp-footer-wrapper rtp-section-wrapper">

	<?php rtp_hook_begin_footer(); ?>

	<?php rtp_hook_end_footer(); ?>

</footer><!-- #footer-wrapper-->

<?php rtp_hook_after_footer(); ?>

<?php rtp_hook_end_main_wrapper(); ?>

</div><!-- #main-wrapper -->

<?php wp_footer(); ?>
</body>
</html>