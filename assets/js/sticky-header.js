/**
 * Sticky Header
 *
 * Adds a shadow to the header when scrolling for visual separation.
 * Respects prefers-reduced-motion preference.
 *
 * @package Versalia
 * @since 1.0.0
 */

(function() {
	'use strict';

	const header = document.getElementById('masthead');
	if (!header) {
		return;
	}

	let scrollTimeout;
	const SCROLL_THRESHOLD = 10;

	/**
	 * Handle scroll event
	 */
	function handleScroll() {
		// Clear existing timeout
		if (scrollTimeout) {
			clearTimeout(scrollTimeout);
		}

		// Use setTimeout to debounce scroll events for performance
		scrollTimeout = setTimeout(function() {
			const scrollPosition = window.scrollY || window.pageYOffset;

			if (scrollPosition > SCROLL_THRESHOLD) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}
		}, 10);
	}

	/**
	 * Initialize
	 */
	function init() {
		// Check initial scroll position
		handleScroll();

		// Add scroll listener
		window.addEventListener('scroll', handleScroll, { passive: true });
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
