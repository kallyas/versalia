<?php
/**
 * Hero Slider Template
 *
 * Displays a hero slider/carousel for featured poems on the homepage.
 *
 * @package Versalia
 * @since 1.0.0
 */

// Get customizer settings
$slider_enabled    = get_theme_mod( 'hero_slider_enabled', true );
$auto_advance      = get_theme_mod( 'hero_slider_auto_advance', true );
$advance_speed     = get_theme_mod( 'hero_slider_speed', 5000 );
$transition_effect = get_theme_mod( 'hero_slider_transition', 'fade' );
$posts_count       = get_theme_mod( 'hero_slider_posts_count', 5 );

// Don't show if slider is disabled
if ( ! $slider_enabled ) {
	return;
}

// Query featured poems
$featured_args = array(
	'post_type'      => 'poem',
	'posts_per_page' => $posts_count,
	'meta_key'       => '_featured_poem',
	'meta_value'     => '1',
);

$featured_query = new WP_Query( $featured_args );

if ( ! $featured_query->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>

<section 
	class="hero-slider" 
	aria-label="<?php esc_attr_e( 'Featured Poems', 'versalia' ); ?>"
	data-auto-advance="<?php echo esc_attr( $auto_advance ? 'true' : 'false' ); ?>"
	data-advance-speed="<?php echo esc_attr( $advance_speed ); ?>"
	data-transition="<?php echo esc_attr( $transition_effect ); ?>"
>
	<div class="slider-container">
		<?php
		$slide_index = 0;
		while ( $featured_query->have_posts() ) :
			$featured_query->the_post();
			$poetry_forms = get_the_terms( get_the_ID(), 'poetry_form' );
			?>
			<div class="slide <?php echo 0 === $slide_index ? 'active' : ''; ?>" data-slide="<?php echo esc_attr( $slide_index ); ?>">
				<div class="slide-content">
					<?php if ( $poetry_forms && ! is_wp_error( $poetry_forms ) ) : ?>
						<div class="slide-form">
							<?php
							$forms = array();
							foreach ( $poetry_forms as $form ) {
								$forms[] = $form->name;
							}
							echo esc_html( implode( ', ', $forms ) );
							?>
						</div>
					<?php endif; ?>
					
					<h2 class="slide-title">
						<?php the_title(); ?>
					</h2>
					
					<p class="slide-author">
						<?php
						/* translators: %s: Author name */
						printf( esc_html__( 'by %s', 'versalia' ), '<span class="author-name">' . esc_html( get_the_author() ) . '</span>' );
						?>
					</p>
					
					<div class="slide-excerpt">
						<?php
						// Get the first few lines of the poem
						$content = get_the_content();
						$content = wp_strip_all_tags( $content );
						$lines   = explode( "\n", $content );
						$excerpt = implode( "\n", array_slice( $lines, 0, 3 ) );
						echo '<p>' . esc_html( wp_trim_words( $excerpt, 20, '...' ) ) . '</p>';
						?>
					</div>
					
					<a href="<?php the_permalink(); ?>" class="slide-cta">
						<?php esc_html_e( 'Read Poem', 'versalia' ); ?>
						<span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span>
					</a>
				</div>
			</div>
			<?php
			++$slide_index;
		endwhile;
		wp_reset_postdata();
		?>
	</div>
	
	<?php if ( $featured_query->post_count > 1 ) : ?>
		<div class="slider-controls">
			<button class="slider-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'versalia' ); ?>">
				<span aria-hidden="true">←</span>
			</button>
			
			<div class="slider-dots" role="tablist" aria-label="<?php esc_attr_e( 'Slides', 'versalia' ); ?>">
				<?php for ( $i = 0; $i < $featured_query->post_count; $i++ ) : ?>
					<button 
						class="dot <?php echo 0 === $i ? 'active' : ''; ?>" 
						role="tab"
						aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'versalia' ), $i + 1 ) ); ?>"
						aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
						data-slide="<?php echo esc_attr( $i ); ?>"
					></button>
				<?php endfor; ?>
			</div>
			
			<button class="slider-next" aria-label="<?php esc_attr_e( 'Next slide', 'versalia' ); ?>">
				<span aria-hidden="true">→</span>
			</button>
		</div>
		
		<button class="slider-pause" aria-label="<?php esc_attr_e( 'Pause slider', 'versalia' ); ?>" aria-pressed="false">
			<span class="pause-icon" aria-hidden="true">⏸</span>
			<span class="play-icon" aria-hidden="true" style="display: none;">▶</span>
		</button>
	<?php endif; ?>
</section>
