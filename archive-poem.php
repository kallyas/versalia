<?php
/**
 * The template for displaying poem archives
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

get_header();
?>

<main id="primary" class="site-main poem-archive">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<div class="poem-archive-container <?php echo esc_attr( 'view-' . get_theme_mod( 'versalia_archive_view', 'list' ) ); ?>">

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'excerpt' );

			endwhile;
			?>

		</div><!-- .poem-archive-container -->

		<?php
		// Load More button for AJAX pagination
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) :
			$taxonomy = '';
			$term_id = 0;
			
			// Get taxonomy and term if on taxonomy archive
			if ( is_tax() ) {
				$queried_object = get_queried_object();
				if ( $queried_object ) {
					$taxonomy = $queried_object->taxonomy;
					$term_id = $queried_object->term_id;
				}
			}
			?>
			<div class="load-more-wrapper">
				<button class="load-more-button button" 
						data-page="1" 
						data-max-pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
						data-post-type="poem"
						data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>"
						data-term-id="<?php echo esc_attr( $term_id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( VERSALIA_LOAD_MORE_ACTION ) ); ?>"
						data-loading-text="<?php esc_attr_e( 'Loading...', 'versalia' ); ?>">
					<?php esc_html_e( 'Load More Poems', 'versalia' ); ?>
				</button>
			</div>
		<?php endif; ?>

	<?php

	else :

		get_template_part( 'template-parts/content/content', 'none' );

	endif;
	?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
