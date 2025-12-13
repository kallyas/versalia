<?php
/**
 * Template part for displaying poem metadata
 *
 * This is CRITICAL for displaying all poem-specific information.
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = $args['post_id'] ?? get_the_ID();

// Get customizer settings
$show_date_written  = get_theme_mod( 'versalia_show_date_written', true );
$show_poetry_form   = get_theme_mod( 'versalia_show_poetry_form', true );
$show_reading_time  = get_theme_mod( 'versalia_show_reading_time', true );

// Get poem data
$date_written  = versalia_get_poem_date_written( $post_id );
$reading_time  = versalia_get_poem_reading_time( $post_id );
$forms         = get_the_terms( $post_id, 'poetry_form' );
$collections   = get_the_terms( $post_id, 'collection' );
?>

<div class="poem-meta">
	<?php if ( $show_date_written && $date_written ) : ?>
		<div class="poem-meta-item date-written">
			<span class="meta-label"><?php esc_html_e( 'Written:', 'versalia' ); ?></span>
			<span class="meta-value"><?php echo esc_html( $date_written ); ?></span>
		</div>
	<?php endif; ?>

	<?php if ( $show_poetry_form && $forms && ! is_wp_error( $forms ) ) : ?>
		<div class="poem-meta-item poetry-form">
			<span class="meta-label"><?php esc_html_e( 'Form:', 'versalia' ); ?></span>
			<div class="meta-value">
				<?php versalia_taxonomy_badges( 'poetry_form', $post_id ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $collections && ! is_wp_error( $collections ) ) : ?>
		<div class="poem-meta-item collection">
			<span class="meta-label"><?php esc_html_e( 'Collection:', 'versalia' ); ?></span>
			<div class="meta-value">
				<?php versalia_taxonomy_badges( 'collection', $post_id ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $show_reading_time && $reading_time ) : ?>
		<div class="poem-meta-item reading-time">
			<span class="meta-label"><?php esc_html_e( 'Reading time:', 'versalia' ); ?></span>
			<span class="meta-value">
				<?php
				printf(
					_n( '%s minute', '%s minutes', $reading_time, 'versalia' ),
					number_format_i18n( $reading_time )
				);
				?>
			</span>
		</div>
	<?php endif; ?>

	<div class="poem-meta-item published-date">
		<span class="meta-label"><?php esc_html_e( 'Published:', 'versalia' ); ?></span>
		<span class="meta-value">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
		</span>
	</div>

	<?php
	// Display tags if any
	$tags = get_the_tags();
	if ( $tags && ! is_wp_error( $tags ) ) :
		?>
		<div class="poem-meta-item tags">
			<span class="meta-label"><?php esc_html_e( 'Tags:', 'versalia' ); ?></span>
			<div class="meta-value">
				<?php versalia_taxonomy_badges( 'post_tag', $post_id ); ?>
			</div>
		</div>
	<?php endif; ?>
</div><!-- .poem-meta -->
