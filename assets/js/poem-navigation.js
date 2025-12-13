/**
 * Poem Navigation via Keyboard
 *
 * Implements keyboard shortcuts for navigating between poems.
 * Keyboard shortcuts: ← → (previous/next), H (home), R (random), ? (help)
 *
 * @package Versalia
 * @since 1.0.0
 */

(function() {
	'use strict';

	// Get navigation URLs from WordPress localized data
	const prevLink = document.querySelector('.poem-navigation .nav-previous a');
	const nextLink = document.querySelector('.poem-navigation .nav-next a');
	const homeLink = document.querySelector('.poem-navigation .nav-archive');

	/**
	 * Navigate to URL
	 */
	function navigateTo(url) {
		if (url) {
			window.location.href = url;
		}
	}

	/**
	 * Show keyboard shortcuts help modal
	 */
	function showKeyboardHelp() {
		const helpText = [
			'Keyboard Shortcuts:',
			'',
			'← → Arrow keys - Navigate between poems',
			'H - Go to poems archive',
			'R - Random poem',
			'L - Toggle reading mode (Light/Dark/Sepia)',
			'? - Show this help'
		].join('\n');

		alert(helpText);
	}

	/**
	 * Handle keyboard events
	 */
	function handleKeyboard(event) {
		// Don't trigger if user is typing in an input
		if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
			return;
		}

		switch(event.key) {
			case 'ArrowLeft':
			case 'Left':
				// Previous poem
				event.preventDefault();
				if (prevLink) {
					navigateTo(prevLink.href);
				}
				break;

			case 'ArrowRight':
			case 'Right':
				// Next poem
				event.preventDefault();
				if (nextLink) {
					navigateTo(nextLink.href);
				}
				break;

			case 'h':
			case 'H':
				// Home/Archive
				event.preventDefault();
				if (homeLink) {
					navigateTo(homeLink.href);
				}
				break;

			case 'r':
			case 'R':
				// Random poem
				event.preventDefault();
				// Navigate to archive with a random parameter (server-side implementation needed)
				const archiveUrl = homeLink ? homeLink.href : '/poems/';
				navigateTo(archiveUrl + '?random=1');
				break;

			case '?':
				// Show help
				event.preventDefault();
				showKeyboardHelp();
				break;
		}
	}

	/**
	 * Enable swipe gestures on touch devices
	 */
	function enableSwipe() {
		let touchStartX = 0;
		let touchEndX = 0;
		const minSwipeDistance = 50;

		document.addEventListener('touchstart', (e) => {
			touchStartX = e.changedTouches[0].screenX;
		}, false);

		document.addEventListener('touchend', (e) => {
			touchEndX = e.changedTouches[0].screenX;
			handleSwipe();
		}, false);

		function handleSwipe() {
			const swipeDistance = touchEndX - touchStartX;

			if (Math.abs(swipeDistance) > minSwipeDistance) {
				if (swipeDistance > 0 && prevLink) {
					// Swipe right - previous poem
					navigateTo(prevLink.href);
				} else if (swipeDistance < 0 && nextLink) {
					// Swipe left - next poem
					navigateTo(nextLink.href);
				}
			}
		}
	}

	/**
	 * Initialize
	 */
	function init() {
		// Add keyboard event listener
		document.addEventListener('keydown', handleKeyboard);

		// Enable swipe gestures on touch devices
		if ('ontouchstart' in window) {
			enableSwipe();
		}

		// Add visual hint about keyboard shortcuts
		const keyboardHint = document.querySelector('.poem-navigation .keyboard-hint');
		if (keyboardHint) {
			keyboardHint.innerHTML += ' <span class="hint-help">Press <kbd>?</kbd> for all shortcuts</span>';
		}
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
