<?php
/**
 * Template part for displaying post excerpts
 *
 * Used in archive and search results.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'poem-excerpt' ); ?>>
	<header class="entry-header">
		<?php
		if ( 'poem' === get_post_type() ) :
			// Display poetry form badges
			versalia_taxonomy_badges( 'poetry_form', get_the_ID(), 1 );

			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
			<div class="entry-meta">
				<span class="author-name"><?php echo esc_html( get_the_author() ); ?></span>
			</div>
			<?php
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<a href="<?php the_permalink(); ?>" class="read-more">
			<?php
			if ( 'poem' === get_post_type() ) :
				esc_html_e( 'Read poem', 'versalia' );
			else :
				esc_html_e( 'Continue reading', 'versalia' );
			endif;
			?>
			<span aria-hidden="true"> →</span>
		</a>
		<?php if ( 'poem' === get_post_type() ) : ?>
			<?php get_template_part( 'template-parts/buttons/bookmark-button' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
