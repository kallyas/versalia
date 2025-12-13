/**
 * Load More Pagination
 *
 * Handles AJAX-based "Load More" pagination for poem archives.
 * Provides smooth loading animations and accessibility features.
 *
 * @package Versalia
 * @since 1.0.0
 */

/* global versaliaLoadMore */

(function() {
	'use strict';

	let isLoading = false;

	/**
	 * Announce status change to screen readers
	 */
	function announceToScreenReader(message) {
		let liveRegion = document.getElementById('load-more-announcements');
		if (!liveRegion) {
			liveRegion = document.createElement('div');
			liveRegion.id = 'load-more-announcements';
			liveRegion.className = 'screen-reader-text';
			liveRegion.setAttribute('aria-live', 'polite');
			liveRegion.setAttribute('aria-atomic', 'true');
			document.body.appendChild(liveRegion);
		}
		liveRegion.textContent = message;
	}

	/**
	 * Fade in new content with animation
	 */
	function fadeInContent(elements) {
		// Check if user prefers reduced motion
		const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		
		if (prefersReducedMotion) {
			// No animation for users who prefer reduced motion
			return;
		}

		elements.forEach((element, index) => {
			element.style.opacity = '0';
			element.style.transform = 'translateY(20px)';
			element.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
			
			setTimeout(() => {
				element.style.opacity = '1';
				element.style.transform = 'translateY(0)';
			}, index * 100);
		});
	}

	/**
	 * Handle Load More button click
	 */
	async function handleLoadMore(event) {
		event.preventDefault();
		
		if (isLoading) {
			return;
		}

		const button = event.currentTarget;
		const container = document.querySelector('.poem-archive-container');
		
		if (!container) {
			return;
		}

		// Get data from button
		const currentPage = parseInt(button.dataset.page, 10);
		const postType = button.dataset.postType || 'poem';
		const taxonomy = button.dataset.taxonomy || '';
		const termId = button.dataset.termId || '';
		const nonce = button.dataset.nonce || '';

		// Set loading state
		isLoading = true;
		button.disabled = true;
		button.classList.add('is-loading');
		
		const originalText = button.textContent;
		button.textContent = button.dataset.loadingText || 'Loading...';
		
		announceToScreenReader('Loading more poems...');

		try {
			// Prepare form data
			const formData = new URLSearchParams({
				action: 'load_more_poems',
				page: currentPage + 1,
				post_type: postType,
				taxonomy: taxonomy,
				term_id: termId,
				nonce: nonce,
			});

			// Make AJAX request
			const response = await fetch(versaliaLoadMore.ajaxUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: formData,
			});

			// Check if response is ok
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}

			const data = await response.json();

			if (data.success) {
				// Create temporary container to parse HTML
				const tempDiv = document.createElement('div');
				tempDiv.innerHTML = data.data.html;
				
				// Get all new articles
				const newArticles = Array.from(tempDiv.children);
				
				// Append new content to container
				newArticles.forEach(article => {
					container.appendChild(article);
				});

				// Apply fade-in animation to new articles
				fadeInContent(newArticles);

				// Re-initialize bookmarks for new content
				document.dispatchEvent(new CustomEvent('versalia:contentLoaded'));

				// Update button state
				const newPage = data.data.current_page;
				button.dataset.page = newPage;

				if (newPage >= data.data.max_pages) {
					// No more posts - remove button
					button.remove();
					announceToScreenReader('All poems loaded. No more content available.');
				} else {
					// Reset button state
					button.textContent = originalText;
					button.disabled = false;
					button.classList.remove('is-loading');
					isLoading = false;
					
					announceToScreenReader(`${newArticles.length} more poems loaded. Page ${newPage} of ${data.data.max_pages}.`);
				}

				// Update URL without page reload (optional, for browser history)
				if (window.history && window.history.pushState) {
					const url = new URL(window.location);
					url.searchParams.set('paged', newPage);
					window.history.pushState({ page: newPage }, '', url);
				}

			} else {
				// Error handling
				button.textContent = originalText;
				button.disabled = false;
				button.classList.remove('is-loading');
				isLoading = false;
				
				announceToScreenReader('Error loading more poems. Please try again.');
			}

		} catch (error) {
			button.textContent = originalText;
			button.disabled = false;
			button.classList.remove('is-loading');
			isLoading = false;
			
			// Provide more specific error message
			const errorMessage = error instanceof TypeError 
				? 'Network error. Please check your connection and try again.'
				: 'Error loading more poems. Please try again.';
			
			announceToScreenReader(errorMessage);
		}
	}

	/**
	 * Initialize Load More functionality
	 */
	function initLoadMore() {
		const button = document.querySelector('.load-more-button');
		
		if (!button) {
			return;
		}

		// Add click handler
		button.addEventListener('click', handleLoadMore);
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initLoadMore);
	} else {
		initLoadMore();
	}

})();
