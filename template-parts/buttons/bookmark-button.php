<?php
/**
 * Template part for displaying a bookmark button
 *
 * @package Versalia
 * @since 1.0.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$poem_id = get_the_ID();
if ( ! $poem_id ) {
	return;
}
?>

<button class="bookmark-toggle" 
		data-poem-id="<?php echo esc_attr( (string) $poem_id ); ?>"
		data-default-text="<?php esc_attr_e( 'Save for later', 'versalia' ); ?>"
		data-saved-text="<?php esc_attr_e( 'Saved', 'versalia' ); ?>"
		aria-label="<?php esc_attr_e( 'Save this poem for later', 'versalia' ); ?>"
		aria-pressed="false"
		type="button">
	<svg class="bookmark-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M5 2C4.44772 2 4 2.44772 4 3V18L10 14L16 18V3C16 2.44772 15.5523 2 15 2H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
	<span class="bookmark-text"><?php esc_html_e( 'Save for later', 'versalia' ); ?></span>
</button>
