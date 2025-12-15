/**
 * Back to Top Button
 *
 * @package Versalia
 * @since 1.0.0
 */

document.addEventListener('DOMContentLoaded', () => {
	const backToTop = document.getElementById('back-to-top');

	if (!backToTop) {
		return;
	}

	// Show/hide based on scroll position
	window.addEventListener('scroll', () => {
		if (window.scrollY > 300) {
			backToTop.classList.add('visible');
		} else {
			backToTop.classList.remove('visible');
		}
	});

	// Smooth scroll to top
	backToTop.addEventListener('click', () => {
		window.scrollTo({
			top: 0,
			behavior: 'smooth',
		});
	});
});
