<?php
/**
 * Template part for displaying poem content
 *
 * This is the CRITICAL template for displaying individual poems
 * with proper typography and formatting.
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

<article id="post-<?php the_ID(); ?>" <?php post_class( 'poem-article' ); ?>>
	<header class="poem-header">
		<?php the_title( '<h1 class="poem-title">', '</h1>' ); ?>

		<?php
		// Display author name
		printf(
			'<div class="poem-byline"><span class="by-text">%s</span> <span class="author-name">%s</span></div>',
			esc_html__( 'by', 'versalia' ),
			esc_html( get_the_author() )
		);
		?>
	</header><!-- .poem-header -->

	<div class="poem-actions">
		<?php get_template_part( 'template-parts/buttons/bookmark-button' ); ?>
	</div>

	<?php
	// Display dedication if available
	$dedication = versalia_get_poem_dedication();
	if ( $dedication ) :
		?>
		<div class="poem-dedication">
			<em><?php echo esc_html( $dedication ); ?></em>
		</div>
	<?php endif; ?>

	<?php
	// Display epigraph if available
	$epigraph = versalia_get_poem_epigraph();
	if ( $epigraph['text'] ) :
		?>
		<div class="poem-epigraph">
			<blockquote>
				<em><?php echo esc_html( $epigraph['text'] ); ?></em>
			</blockquote>
			<?php if ( $epigraph['attribution'] ) : ?>
				<cite>— <?php echo esc_html( $epigraph['attribution'] ); ?></cite>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="poem-content entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current poem. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'versalia' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'versalia' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .poem-content -->

	<?php
	// Display poem metadata
	versalia_poem_meta();
	?>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current poem. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'versalia' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
