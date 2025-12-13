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
	<?php
	// Display featured image if available
	if ( has_post_thumbnail() ) :
		?>
		<div class="poem-featured-image">
			<?php the_post_thumbnail( 'large', array( 'class' => 'featured-image' ) ); ?>
		</div>
	<?php endif; ?>

	<header class="poem-header">
		<?php the_title( '<h1 class="poem-title">', '</h1>' ); ?>

		<div class="poem-meta-bar">
			<span class="meta-item meta-author">
				<span class="meta-label"><?php esc_html_e( 'By', 'versalia' ); ?></span>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-link">
					<?php echo esc_html( get_the_author() ); ?>
				</a>
			</span>

			<?php
			$forms = get_the_terms( get_the_ID(), 'poetry_form' );
			if ( $forms && ! is_wp_error( $forms ) ) :
				$form = array_shift( $forms );
				?>
				<span class="meta-separator" aria-hidden="true">•</span>
				<span class="meta-item meta-form">
					<a href="<?php echo esc_url( get_term_link( $form ) ); ?>">
						<?php echo esc_html( $form->name ); ?>
					</a>
				</span>
			<?php endif; ?>

			<span class="meta-separator" aria-hidden="true">•</span>
			<span class="meta-item meta-date">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</span>

			<?php
			$reading_time = versalia_get_poem_reading_time();
			if ( $reading_time ) :
				?>
				<span class="meta-separator" aria-hidden="true">•</span>
				<span class="meta-item meta-reading-time">
					<?php
					printf(
						_n( '%s Min Read', '%s Min Read', $reading_time, 'versalia' ),
						number_format_i18n( $reading_time )
					);
					?>
				</span>
			<?php endif; ?>
		</div>
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

	<?php
	// Display author bio box if enabled
	if ( get_theme_mod( 'versalia_show_author_bio', true ) ) :
		get_template_part( 'template-parts/author/author', 'bio' );
	endif;
	// Display social sharing buttons
	get_template_part( 'template-parts/social/share', 'buttons' );
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
