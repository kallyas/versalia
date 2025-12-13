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
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( '← Previous', 'versalia' ),
				'next_text' => __( 'Next →', 'versalia' ),
			)
		);

	else :

		get_template_part( 'template-parts/content/content', 'none' );

	endif;
	?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
