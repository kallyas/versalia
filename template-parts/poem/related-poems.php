<?php
/**
 * Template part for displaying related poems
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$related = versalia_get_related_poems( get_the_ID(), 3 );

if ( ! $related || ! $related->have_posts() ) {
	return;
}
?>

<aside class="related-poems">
	<h2 class="related-poems-title">
		<?php echo esc_html( versalia_get_related_poems_title( get_the_ID() ) ); ?>
	</h2>

	<div class="related-poems-grid">
		<?php
		while ( $related->have_posts() ) :
			$related->the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'related-poem-card' ); ?>>
				<header class="poem-card-header">
					<h3 class="poem-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_title(); ?>
						</a>
					</h3>

					<div class="poem-meta">
						<span class="poem-author">
							<?php
							printf(
								/* translators: %s: Author name */
								esc_html__( 'by %s', 'versalia' ),
								'<span class="author-name">' . esc_html( get_the_author() ) . '</span>'
							);
							?>
						</span>

						<?php
						$forms = get_the_terms( get_the_ID(), 'poetry_form' );
						if ( $forms && ! is_wp_error( $forms ) ) :
							$form = array_shift( $forms );
							?>
							<span class="poem-separator" aria-hidden="true">•</span>
							<span class="poem-form"><?php echo esc_html( $form->name ); ?></span>
						<?php endif; ?>
					</div>
				</header>

				<?php if ( has_excerpt() ) : ?>
					<div class="poem-excerpt">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>

				<footer class="poem-card-footer">
					<a href="<?php the_permalink(); ?>" class="read-more">
						<?php esc_html_e( 'Read poem', 'versalia' ); ?>
						<span aria-hidden="true"> →</span>
					</a>
				</footer>
			</article>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</aside>
