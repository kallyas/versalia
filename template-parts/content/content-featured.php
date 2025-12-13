<?php
/**
 * Template part for displaying featured poems
 *
 * @package Versalia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'featured-poem' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		// Display poetry form
		$poetry_forms = get_the_terms( get_the_ID(), 'poetry_form' );
		if ( $poetry_forms && ! is_wp_error( $poetry_forms ) ) :
			?>
			<div class="entry-meta">
				<span class="poetry-form">
					<?php
					$forms = array();
					foreach ( $poetry_forms as $form ) {
						$forms[] = $form->name;
					}
					echo esc_html( implode( ', ', $forms ) );
					?>
				</span>
			</div>
			<?php
		endif;

		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>

		<div class="entry-meta">
			<?php
			versalia_posted_on();
			versalia_posted_by();
			?>
		</div>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<a href="<?php the_permalink(); ?>" class="read-more">
			<?php esc_html_e( 'Read Poem', 'versalia' ); ?>
			<span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span>
		</a>
		<?php get_template_part( 'template-parts/buttons/bookmark-button' ); ?>
	</footer>

</article><!-- #post-<?php the_ID(); ?> -->
