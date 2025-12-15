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
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="footer-widgets">
				<div class="footer-widgets-inner">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="footer-column">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="footer-column">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="footer-column">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="footer-column">
							<?php dynamic_sidebar( 'footer-4' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<div class="footer-bottom-inner">
				<div class="site-info">
					<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
				</div>

				<?php if ( get_theme_mod( 'versalia_enable_back_to_top', true ) ) : ?>
					<button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'versalia' ); ?>">
						<svg class="icon" aria-hidden="true" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10 4L10 16M10 4L4 10M10 4L16 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</button>
				<?php endif; ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
