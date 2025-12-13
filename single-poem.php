<?php
/**
 * The template for displaying single poems
 *
 * This is the most important template in the Versalia theme,
 * specifically designed for displaying individual poems with
 * optimal typography and reading experience.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

<main id="primary" class="site-main poem-single">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content/content', 'poem' );

		// Poem navigation (previous/next)
		versalia_poem_navigation();

		// Related poems section
		get_template_part( 'template-parts/poem/related', 'poems' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

</main><!-- #primary -->

<?php
get_footer();
