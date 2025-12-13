<?php
/**
 * Displays footer site info
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="site-info">
	<div class="site-info-text">
		<?php
		printf(
			/* translators: 1: Year, 2: Site name */
			esc_html__( '&copy; %1$s %2$s', 'versalia' ),
			esc_html( gmdate( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
		?>
		<span class="sep"> | </span>
		<?php
		printf(
			/* translators: %s: Theme name */
			esc_html__( 'Theme: %s', 'versalia' ),
			'<a href="https://versalia.tumuhirwe.dev">Versalia</a>'
		);
		?>
	</div>

	<?php
	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'menu_class'     => 'footer-menu',
				'container'      => 'nav',
				'container_class' => 'footer-navigation',
				'depth'          => 1,
			)
		);
	}
	?>
</div><!-- .site-info -->
