/**
 * Reading Mode Toggle
 *
 * CRITICAL: Handles switching between Light, Dark, and Sepia reading modes.
 * Persists user preference in localStorage.
 *
 * @package Versalia
 * @since 1.0.0
 */

(function() {
	'use strict';

	const STORAGE_KEY = 'versalia_reading_mode';
	const MODES = ['light', 'dark', 'sepia'];
	const body = document.body;
	const toggle = document.getElementById('reading-mode-toggle');

	if (!toggle) {
		return;
	}

	/**
	 * Get stored reading mode or detect system preference
	 */
	function getInitialMode() {
		// Check localStorage first
		const stored = localStorage.getItem(STORAGE_KEY);
		if (stored && MODES.includes(stored)) {
			return stored;
		}

		// Check system preference
		if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
			return 'dark';
		}

		return 'light';
	}

	/**
	 * Apply reading mode
	 */
	function applyMode(mode) {
		// Remove all mode classes
		MODES.forEach(m => {
			body.classList.remove(`reading-mode-${m}`);
		});

		// Add current mode class
		body.classList.add(`reading-mode-${mode}`);

		// Set data attribute
		body.setAttribute('data-reading-mode', mode);

		// Store preference
		localStorage.setItem(STORAGE_KEY, mode);

		// Update toggle button state
		toggle.setAttribute('aria-pressed', 'true');

		// Add temporary indicator
		body.classList.add('reading-mode-changing');
		setTimeout(() => {
			body.classList.remove('reading-mode-changing');
		}, 1500);
	}

	/**
	 * Get next mode in cycle
	 */
	function getNextMode(currentMode) {
		const currentIndex = MODES.indexOf(currentMode);
		const nextIndex = (currentIndex + 1) % MODES.length;
		return MODES[nextIndex];
	}

	/**
	 * Toggle reading mode
	 */
	function toggleMode() {
		const currentMode = body.getAttribute('data-reading-mode') || 'light';
		const nextMode = getNextMode(currentMode);
		applyMode(nextMode);
	}

	/**
	 * Initialize
	 */
	function init() {
		// Apply initial mode
		const initialMode = getInitialMode();
		applyMode(initialMode);

		// Add click listener to toggle
		toggle.addEventListener('click', toggleMode);

		// Listen for system preference changes
		if (window.matchMedia) {
			const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');

			// Check if addEventListener is supported (modern browsers)
			if (darkModeQuery.addEventListener) {
				darkModeQuery.addEventListener('change', (e) => {
					// Only auto-switch if user hasn't manually set a preference
					if (!localStorage.getItem(STORAGE_KEY)) {
						applyMode(e.matches ? 'dark' : 'light');
					}
				});
			} else if (darkModeQuery.addListener) {
				// Fallback for older browsers
				darkModeQuery.addListener((e) => {
					if (!localStorage.getItem(STORAGE_KEY)) {
						applyMode(e.matches ? 'dark' : 'light');
					}
				});
			}
		}

		// Keyboard shortcut: L key to toggle reading mode
		document.addEventListener('keydown', (e) => {
			// Only if not typing in an input
			if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
				if (e.key === 'l' || e.key === 'L') {
					e.preventDefault();
					toggleMode();
				}
			}
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
