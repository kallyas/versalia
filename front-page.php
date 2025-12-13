<?php
/**
 * The front page template file
 *
 * This is the template that displays the homepage.
 * Inspired by Typology theme with featured content sections.
 *
 * @package Versalia
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		// Hero Slider Section (replaces old featured section when enabled)
		get_template_part( 'template-parts/hero/hero-slider' );
		?>

		<?php
		// Hero/Intro Section
		if ( is_active_sidebar( 'homepage-hero' ) ) :
			?>
			<div class="homepage-hero-section">
				<?php dynamic_sidebar( 'homepage-hero' ); ?>
			</div>
			<?php
		endif;
		?>

		<?php
		// Main Content Section - Latest Poems
		$latest_layout = get_theme_mod( 'homepage_layout', 'layout-a' );
		?>
		<div class="homepage-content homepage-<?php echo esc_attr( $latest_layout ); ?>">

			<?php if ( get_theme_mod( 'homepage_show_title', true ) ) : ?>
				<h2 class="homepage-section-title"><?php echo esc_html( get_theme_mod( 'homepage_section_title', __( 'Latest Poems', 'versalia' ) ) ); ?></h2>
			<?php endif; ?>

			<div class="poems-grid">
				<?php
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$homepage_args = array(
					'post_type'      => 'poem',
					'posts_per_page' => get_theme_mod( 'homepage_posts_count', 9 ),
					'paged'          => $paged,
					'post__not_in'   => array(), // Could exclude featured posts
				);

				$homepage_query = new WP_Query( $homepage_args );

				if ( $homepage_query->have_posts() ) :
					while ( $homepage_query->have_posts() ) :
						$homepage_query->the_post();

						// Use different templates based on layout
						if ( 'layout-c' === $latest_layout ) {
							get_template_part( 'template-parts/content/content', 'minimal' );
						} else {
							get_template_part( 'template-parts/content/content', 'excerpt' );
						}
					endwhile;

					// Pagination
					the_posts_navigation(
						array(
							'prev_text' => __( 'Older poems', 'versalia' ),
							'next_text' => __( 'Newer poems', 'versalia' ),
						)
					);

					wp_reset_postdata();
				else :
					get_template_part( 'template-parts/content/content', 'none' );
				endif;
				?>
			</div>
		</div>

		<?php
		// Bottom Widget Area
		if ( is_active_sidebar( 'homepage-bottom' ) ) :
			?>
			<div class="homepage-bottom-section">
				<?php dynamic_sidebar( 'homepage-bottom' ); ?>
			</div>
			<?php
		endif;
		?>

	</main><!-- #main -->

<?php
// Conditional sidebar based on layout - Sidebar disabled
// if ( in_array( $latest_layout, array( 'layout-a', 'layout-b' ) ) && is_active_sidebar( 'sidebar-1' ) ) {
// 	get_sidebar();
// }

get_footer();
