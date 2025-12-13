<?php
/**
 * Displays the site navigation
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'versalia' ); ?>">
	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
		<span class="menu-toggle-icon"></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'versalia' ); ?></span>
	</button>

	<?php
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'primary-menu',
				'container'      => false,
			)
		);
	}
	?>

	<?php if ( is_singular( 'poem' ) ) : ?>
		<div class="poem-controls">
			<button id="reading-mode-toggle" class="reading-mode-toggle" aria-label="<?php esc_attr_e( 'Toggle reading mode', 'versalia' ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
				</svg>
			</button>
		</div>
	<?php endif; ?>
</nav><!-- #site-navigation -->
