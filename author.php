<?php
/**
 * The template for displaying author pages
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

// Display breadcrumb navigation
versalia_breadcrumb();
?>

<main id="primary" class="site-main author-archive">

	<?php if ( have_posts() ) : ?>

		<header class="page-header author-header">
			<?php
			$author_id          = get_the_author_meta( 'ID' );
			$author_avatar      = get_avatar( $author_id, 120 );
			$author_name        = get_the_author();
			$author_description = get_the_author_meta( 'description' );
			?>

			<div class="author-info">
				<?php if ( $author_avatar ) : ?>
					<div class="author-avatar">
						<?php echo wp_kses_post( $author_avatar ); ?>
					</div>
				<?php endif; ?>

				<div class="author-details">
					<h1 class="page-title author-title"><?php echo esc_html( $author_name ); ?></h1>

					<?php if ( $author_description ) : ?>
						<div class="author-description">
							<?php echo wp_kses_post( wpautop( $author_description ) ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header><!-- .page-header -->

		<div class="author-poems">
			<h2><?php esc_html_e( 'Poems by this author', 'versalia' ); ?></h2>

			<div class="poem-archive-container view-list">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content/content', 'excerpt' );

				endwhile;
				?>
			</div>

			<?php
			the_posts_navigation();
		?>
		</div>

	<?php
	else :

		get_template_part( 'template-parts/content/content', 'none' );

	endif;
	?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
