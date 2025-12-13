<?php
/**
 * Template part for poem navigation (previous/next)
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$prev_post = get_previous_post( true, '', 'poetry_form' );
$next_post = get_next_post( true, '', 'poetry_form' );

if ( ! $prev_post && ! $next_post ) {
	return;
}
?>

<nav class="poem-navigation" aria-label="<?php esc_attr_e( 'Poem navigation', 'versalia' ); ?>">
	<div class="nav-links">
		<?php if ( $prev_post ) : ?>
			<div class="nav-previous">
				<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" rel="prev">
					<span class="nav-arrow" aria-hidden="true">←</span>
					<span class="nav-label"><?php esc_html_e( 'Previous', 'versalia' ); ?></span>
					<span class="nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
				</a>
			</div>
		<?php endif; ?>

		<div class="nav-home">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'poem' ) ); ?>" class="nav-archive">
				<span class="screen-reader-text"><?php esc_html_e( 'All Poems', 'versalia' ); ?></span>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
				</svg>
			</a>
		</div>

		<?php if ( $next_post ) : ?>
			<div class="nav-next">
				<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" rel="next">
					<span class="nav-label"><?php esc_html_e( 'Next', 'versalia' ); ?></span>
					<span class="nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
					<span class="nav-arrow" aria-hidden="true">→</span>
				</a>
			</div>
		<?php endif; ?>
	</div>

	<div class="keyboard-hint">
		<small><?php esc_html_e( 'Use ← → arrow keys to navigate', 'versalia' ); ?></small>
	</div>
</nav><!-- .poem-navigation -->
