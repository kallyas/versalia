/**
 * Social Sharing Functionality
 *
 * Handles copy-to-clipboard functionality for share buttons.
 *
 * @package Versalia
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Initialize share button functionality
	 */
	function initShareButtons() {
		const copyButtons = document.querySelectorAll('.share-copy');

		if (!copyButtons.length) {
			return;
		}

		copyButtons.forEach(button => {
			button.addEventListener('click', handleCopyClick);
		});
	}

	/**
	 * Handle copy button click
	 *
	 * @param {Event} event Click event
	 */
	async function handleCopyClick(event) {
		const button = event.currentTarget;
		const url = button.dataset.url;
		const buttonText = button.querySelector('.button-text');

		if (!url || !buttonText) {
			return;
		}

		try {
			// Try modern clipboard API first
			await navigator.clipboard.writeText(url);
			showSuccess(button, buttonText);
		} catch (err) {
			// Fallback for older browsers
			fallbackCopy(url, button, buttonText);
		}
	}

	/**
	 * Fallback copy method for older browsers
	 *
	 * @param {string} text Text to copy
	 * @param {HTMLElement} button Button element
	 * @param {HTMLElement} buttonText Button text element
	 */
	function fallbackCopy(text, button, buttonText) {
		const input = document.createElement('input');
		input.value = text;
		input.style.position = 'fixed';
		input.style.opacity = '0';
		document.body.appendChild(input);
		input.select();

		try {
			const success = document.execCommand('copy');
			if (success) {
				showSuccess(button, buttonText);
			}
		} catch (err) {
			console.error('Copy failed:', err);
		} finally {
			document.body.removeChild(input);
		}
	}

	/**
	 * Show success feedback
	 *
	 * @param {HTMLElement} button Button element
	 * @param {HTMLElement} buttonText Button text element
	 */
	function showSuccess(button, buttonText) {
		const originalText = buttonText.textContent;

		// Update button appearance
		buttonText.textContent = 'Copied!';
		button.classList.add('copied');
		button.setAttribute('aria-label', 'Link copied');

		// Reset after 2 seconds
		setTimeout(() => {
			buttonText.textContent = originalText;
			button.classList.remove('copied');
			button.setAttribute('aria-label', 'Copy link');
		}, 2000);
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initShareButtons);
	} else {
		initShareButtons();
	}
})();
