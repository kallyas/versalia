/**
 * Navigation JavaScript
 *
 * Handles mobile menu toggle and keyboard accessibility.
 *
 * @package Versalia
 * @since 1.0.0
 */

(function() {
	'use strict';

	const siteNavigation = document.getElementById('site-navigation');
	if (!siteNavigation) {
		return;
	}

	const menuToggle = siteNavigation.querySelector('.menu-toggle');
	const menu = siteNavigation.querySelector('.primary-menu');

	if (!menuToggle || !menu) {
		return;
	}

	/**
	 * Toggle mobile menu
	 */
	menuToggle.addEventListener('click', function() {
		const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

		menuToggle.setAttribute('aria-expanded', !isExpanded);
		menu.classList.toggle('toggled');
	});

	/**
	 * Close menu on ESC key
	 */
	document.addEventListener('keydown', function(event) {
		if (event.key === 'Escape' || event.keyCode === 27) {
			if (menu.classList.contains('toggled')) {
				menuToggle.setAttribute('aria-expanded', 'false');
				menu.classList.remove('toggled');
				menuToggle.focus();
			}
		}
	});

	/**
	 * Close menu when clicking outside
	 */
	document.addEventListener('click', function(event) {
		if (!siteNavigation.contains(event.target) && menu.classList.contains('toggled')) {
			menuToggle.setAttribute('aria-expanded', 'false');
			menu.classList.remove('toggled');
		}
	});

	/**
	 * Trap focus within menu when open
	 */
	const focusableElements = menu.querySelectorAll('a, button');
	const firstFocusable = focusableElements[0];
	const lastFocusable = focusableElements[focusableElements.length - 1];

	menu.addEventListener('keydown', function(event) {
		if (event.key === 'Tab' || event.keyCode === 9) {
			if (event.shiftKey) {
				// Shift + Tab
				if (document.activeElement === firstFocusable) {
					event.preventDefault();
					lastFocusable.focus();
				}
			} else {
				// Tab
				if (document.activeElement === lastFocusable) {
					event.preventDefault();
					firstFocusable.focus();
				}
			}
		}
	});

})();
