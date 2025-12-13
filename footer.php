<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
