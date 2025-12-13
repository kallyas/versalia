<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'versalia' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'versalia' ); ?></p>

			<?php
			get_search_form();
			?>

			<?php
			// Show recent poems
			$args = array(
				'post_type'      => 'poem',
				'posts_per_page' => 5,
				'orderby'        => 'date',
				'order'          => 'DESC',
			);

			$recent_poems = new WP_Query( $args );

			if ( $recent_poems->have_posts() ) :
				?>
				<div class="recent-poems">
					<h2><?php esc_html_e( 'Recent Poems', 'versalia' ); ?></h2>
					<ul>
						<?php
						while ( $recent_poems->have_posts() ) :
							$recent_poems->the_post();
							?>
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<?php
				wp_reset_postdata();
			endif;
			?>

		</div><!-- .page-content -->
	</section><!-- .error-404 -->

</main><!-- #primary -->

<?php
get_footer();
