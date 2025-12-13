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
			<span class="meta-value">
				<?php
				$form_links = array();
				foreach ( $forms as $form ) {
					$form_links[] = sprintf(
						'<a href="%s">%s</a>',
						esc_url( get_term_link( $form ) ),
						esc_html( $form->name )
					);
				}
				echo wp_kses_post( implode( ', ', $form_links ) );
				?>
			</span>
		</div>
	<?php endif; ?>

	<?php if ( $collections && ! is_wp_error( $collections ) ) : ?>
		<div class="poem-meta-item collection">
			<span class="meta-label"><?php esc_html_e( 'Collection:', 'versalia' ); ?></span>
			<span class="meta-value">
				<?php
				$collection_links = array();
				foreach ( $collections as $collection ) {
					$collection_links[] = sprintf(
						'<a href="%s">%s</a>',
						esc_url( get_term_link( $collection ) ),
						esc_html( $collection->name )
					);
				}
				echo wp_kses_post( implode( ', ', $collection_links ) );
				?>
			</span>
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
			<span class="meta-value">
				<?php
				$tag_links = array();
				foreach ( $tags as $tag ) {
					$tag_links[] = sprintf(
						'<a href="%s">%s</a>',
						esc_url( get_tag_link( $tag ) ),
						esc_html( $tag->name )
					);
				}
				echo wp_kses_post( implode( ', ', $tag_links ) );
				?>
			</span>
		</div>
	<?php endif; ?>
</div><!-- .poem-meta -->
