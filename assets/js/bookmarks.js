/**
 * Bookmark Toggle
 *
 * Handles saving and managing bookmarked poems using localStorage.
 * Provides a client-side bookmark system with visual feedback.
 *
 * @package Versalia
 * @since 1.0.0
 */

(function() {
	'use strict';

	const STORAGE_KEY = 'versalia_saved_poems';

	/**
	 * Get saved poems from localStorage
	 */
	function getSavedPoems() {
		try {
			const saved = localStorage.getItem(STORAGE_KEY);
			return saved ? JSON.parse(saved) : [];
		} catch (error) {
			console.warn('Error reading saved poems:', error);
			return [];
		}
	}

	/**
	 * Save poems array to localStorage
	 */
	function setSavedPoems(poems) {
		try {
			localStorage.setItem(STORAGE_KEY, JSON.stringify(poems));
			return true;
		} catch (error) {
			console.warn('Error saving poems:', error);
			return false;
		}
	}

	/**
	 * Check if a poem is bookmarked
	 */
	function isBookmarked(poemId) {
		const saved = getSavedPoems();
		return saved.includes(poemId);
	}

	/**
	 * Toggle bookmark state for a poem
	 */
	function toggleBookmark(poemId) {
		let saved = getSavedPoems();
		const wasBookmarked = saved.includes(poemId);

		if (wasBookmarked) {
			saved = saved.filter(id => id !== poemId);
		} else {
			saved.push(poemId);
		}

		const success = setSavedPoems(saved);
		if (success) {
			return !wasBookmarked;
		}
		return wasBookmarked;
	}

	/**
	 * Update UI state for a bookmark button
	 */
	function updateButtonUI(button, isBookmarked) {
		const icon = button.querySelector('.bookmark-icon');
		const text = button.querySelector('.bookmark-text');

		if (isBookmarked) {
			button.classList.add('is-bookmarked');
			button.setAttribute('aria-pressed', 'true');
			if (text) {
				text.textContent = button.dataset.savedText || 'Saved';
			}
			if (icon) {
				icon.classList.add('is-saved');
			}
		} else {
			button.classList.remove('is-bookmarked');
			button.setAttribute('aria-pressed', 'false');
			if (text) {
				text.textContent = button.dataset.defaultText || 'Save for later';
			}
			if (icon) {
				icon.classList.remove('is-saved');
			}
		}
	}

	/**
	 * Add animation feedback
	 */
	function animateButton(button) {
		button.classList.add('bookmark-animating');
		setTimeout(() => {
			button.classList.remove('bookmark-animating');
		}, 300);
	}

	/**
	 * Handle bookmark button click
	 */
	function handleBookmarkClick(event) {
		event.preventDefault();
		const button = event.currentTarget;
		const poemId = parseInt(button.dataset.poemId, 10);

		if (!poemId) {
			console.warn('No poem ID found');
			return;
		}

		const newState = toggleBookmark(poemId);
		
		// Update all buttons for this poem
		const allButtons = document.querySelectorAll(`[data-poem-id="${poemId}"]`);
		allButtons.forEach(btn => {
			updateButtonUI(btn, newState);
			animateButton(btn);
		});

		// Announce to screen readers
		announceChange(newState);
	}

	/**
	 * Announce state change to screen readers
	 */
	function announceChange(isBookmarked) {
		const message = isBookmarked 
			? 'Poem saved for later' 
			: 'Poem removed from saved';
		
		// Create or update live region
		let liveRegion = document.getElementById('bookmark-announcements');
		if (!liveRegion) {
			liveRegion = document.createElement('div');
			liveRegion.id = 'bookmark-announcements';
			liveRegion.className = 'screen-reader-text';
			liveRegion.setAttribute('aria-live', 'polite');
			liveRegion.setAttribute('aria-atomic', 'true');
			document.body.appendChild(liveRegion);
		}
		
		liveRegion.textContent = message;
	}

	/**
	 * Initialize bookmark buttons
	 */
	function initBookmarks() {
		const buttons = document.querySelectorAll('.bookmark-toggle');
		
		if (buttons.length === 0) {
			return;
		}

		buttons.forEach(button => {
			const poemId = parseInt(button.dataset.poemId, 10);
			
			if (!poemId) {
				return;
			}

			// Check if already initialized
			if (button.dataset.bookmarkInitialized === 'true') {
				return;
			}

			// Set initial state
			const bookmarked = isBookmarked(poemId);
			updateButtonUI(button, bookmarked);

			// Add click handler
			button.addEventListener('click', handleBookmarkClick);

			// Mark as initialized
			button.dataset.bookmarkInitialized = 'true';
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initBookmarks);
	} else {
		initBookmarks();
	}

	// Re-initialize when new content is loaded (for AJAX pagination)
	document.addEventListener('versalia:contentLoaded', initBookmarks);

})();
