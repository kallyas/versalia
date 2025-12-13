<?php
/**
 * Template part for displaying author bio box
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$author_id          = get_the_author_meta( 'ID' );
$author_name        = get_the_author();
$author_description = get_the_author_meta( 'description' );
$author_url         = get_author_posts_url( $author_id );
$posts_count        = count_user_posts( $author_id, 'poem' );

// Only display if author has a description
if ( ! $author_description ) {
	return;
}
?>

<aside class="author-bio-box">
	<div class="author-bio-header">
		<h3 class="author-bio-title"><?php esc_html_e( 'About the Author', 'versalia' ); ?></h3>
	</div>

	<div class="author-bio-content">
		<div class="author-avatar">
			<a href="<?php echo esc_url( $author_url ); ?>" rel="author">
				<?php echo get_avatar( $author_id, 100, '', esc_attr( $author_name ) ); ?>
			</a>
		</div>

		<div class="author-info">
			<h4 class="author-name">
				<a href="<?php echo esc_url( $author_url ); ?>" rel="author">
					<?php echo esc_html( $author_name ); ?>
				</a>
			</h4>

			<p class="author-description">
				<?php echo wp_kses_post( $author_description ); ?>
			</p>

			<div class="author-meta">
				<a href="<?php echo esc_url( $author_url ); ?>" class="view-all-posts">
					<?php
					printf(
						/* translators: %s: Number of poems */
						_n( 'View %s poem', 'View all %s poems', $posts_count, 'versalia' ),
						number_format_i18n( $posts_count )
					);
					?>
					<span aria-hidden="true"> →</span>
				</a>
			</div>
		</div>
	</div>
</aside>
