<?php
/**
 * Displays the site branding
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="site-branding">
	<?php
	if ( has_custom_logo() ) :
		the_custom_logo();
	endif;
	?>

	<div class="site-branding-text">
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>

		<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) :
			?>
			<p class="site-description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
	</div>

	<?php
	if ( has_nav_menu( 'social' ) ) :
		?>
		<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'versalia' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'social',
					'menu_class'     => 'social-links-menu',
					'container'      => false,
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
				)
			);
			?>
		</nav><!-- .social-navigation -->
		<?php
	endif;
	?>
</div><!-- .site-branding -->
