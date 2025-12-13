<?php
/**
 * Template part for social sharing buttons
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$poem_title = get_the_title();
$poem_url   = get_permalink();
$author     = get_the_author();

// Generate tweet text
$tweet_text = sprintf(
	/* translators: 1: Poem title, 2: Author name */
	__( '"%1$s" by %2$s', 'versalia' ),
	$poem_title,
	$author
);
?>

<div class="social-share">
	<h3 class="social-share-title"><?php esc_html_e( 'Share this poem', 'versalia' ); ?></h3>

	<ul class="share-buttons">
		<li class="share-button-item">
			<a href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode( $tweet_text ); ?>&url=<?php echo rawurlencode( $poem_url ); ?>&hashtags=poetry"
			   target="_blank"
			   rel="noopener noreferrer"
			   class="share-button share-twitter"
			   aria-label="<?php esc_attr_e( 'Share on Twitter', 'versalia' ); ?>">
				<svg class="icon" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor">
					<path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
				</svg>
				<span class="button-text"><?php esc_html_e( 'Twitter', 'versalia' ); ?></span>
			</a>
		</li>

		<li class="share-button-item">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $poem_url ); ?>"
			   target="_blank"
			   rel="noopener noreferrer"
			   class="share-button share-facebook"
			   aria-label="<?php esc_attr_e( 'Share on Facebook', 'versalia' ); ?>">
				<svg class="icon" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor">
					<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
				</svg>
				<span class="button-text"><?php esc_html_e( 'Facebook', 'versalia' ); ?></span>
			</a>
		</li>

		<li class="share-button-item">
			<a href="mailto:?subject=<?php echo rawurlencode( $poem_title ); ?>&body=<?php echo rawurlencode( sprintf( __( 'I thought you might enjoy this poem: %s', 'versalia' ), $poem_url ) ); ?>"
			   class="share-button share-email"
			   aria-label="<?php esc_attr_e( 'Share via email', 'versalia' ); ?>">
				<svg class="icon" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor">
					<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
					<polyline points="22,6 12,13 2,6"/>
				</svg>
				<span class="button-text"><?php esc_html_e( 'Email', 'versalia' ); ?></span>
			</a>
		</li>

		<li class="share-button-item">
			<button type="button"
			        class="share-button share-copy"
			        data-url="<?php echo esc_url( $poem_url ); ?>"
			        aria-label="<?php esc_attr_e( 'Copy link', 'versalia' ); ?>">
				<svg class="icon" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor">
					<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
					<path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
				</svg>
				<span class="button-text"><?php esc_html_e( 'Copy Link', 'versalia' ); ?></span>
			</button>
		</li>

		<li class="share-button-item">
			<button type="button"
			        class="share-button share-print"
			        onclick="window.print()"
			        aria-label="<?php esc_attr_e( 'Print poem', 'versalia' ); ?>">
				<svg class="icon" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor">
					<polyline points="6 9 6 2 18 2 18 9"/>
					<path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
					<rect x="6" y="14" width="12" height="8"/>
				</svg>
				<span class="button-text"><?php esc_html_e( 'Print', 'versalia' ); ?></span>
			</button>
		</li>
	</ul>
</div>
