<?php
/**
 * Template part for displaying minimal poem layout (Layout C)
 *
 * @package Versalia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'poem-minimal' ); ?>>

	<header class="entry-header">
		<?php
		the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		?>

		<div class="entry-meta">
			<?php
			// Display date
			$date_written = get_post_meta( get_the_ID(), 'poem_date_written', true );
			if ( $date_written ) {
				echo '<time class="poem-date">' . esc_html( $date_written ) . '</time>';
			} else {
				versalia_posted_on();
			}

			// Display poetry form
			$poetry_forms = get_the_terms( get_the_ID(), 'poetry_form' );
			if ( $poetry_forms && ! is_wp_error( $poetry_forms ) ) {
				echo '<span class="meta-separator">•</span>';
				echo '<span class="poetry-form">' . esc_html( $poetry_forms[0]->name ) . '</span>';
			}
			?>
		</div>
	</header>

</article><!-- #post-<?php the_ID(); ?> -->
