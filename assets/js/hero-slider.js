/**
 * Hero Slider
 *
 * Handles the hero slider carousel functionality for featured poems.
 *
 * @package Versalia
 * @since 1.0.0
 */

class HeroSlider {
	constructor(element) {
		this.slider = element;
		this.slides = element.querySelectorAll('.slide');
		this.dots = element.querySelectorAll('.dot');
		this.prevButton = element.querySelector('.slider-prev');
		this.nextButton = element.querySelector('.slider-next');
		this.pauseButton = element.querySelector('.slider-pause');
		this.currentSlide = 0;
		this.totalSlides = this.slides.length;
		this.autoAdvanceTimer = null;
		this.isPaused = false;

		// Get settings from data attributes
		this.autoAdvance = this.slider.dataset.autoAdvance === 'true';
		this.advanceSpeed = parseInt(this.slider.dataset.advanceSpeed, 10) || 5000;
		this.transition = this.slider.dataset.transition || 'fade';

		// Check for reduced motion preference
		this.prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		this.init();
	}

	init() {
		// Only initialize if we have multiple slides
		if (this.totalSlides <= 1) {
			return;
		}

		this.setupControls();
		this.setupKeyboard();
		this.setupTouch();
		this.setupHoverPause();

		// Respect reduced motion preference
		if (this.prefersReducedMotion) {
			this.autoAdvance = false;
		}

		if (this.autoAdvance) {
			this.startAutoAdvance();
		}

		// Announce first slide to screen readers
		this.announceSlide(0);
	}

	setupControls() {
		// Previous button
		if (this.prevButton) {
			this.prevButton.addEventListener('click', () => this.previousSlide());
		}

		// Next button
		if (this.nextButton) {
			this.nextButton.addEventListener('click', () => this.nextSlide());
		}

		// Dots
		this.dots.forEach((dot) => {
			dot.addEventListener('click', () => {
				const slideIndex = parseInt(dot.dataset.slide, 10);
				this.goToSlide(slideIndex);
			});
		});

		// Pause button
		if (this.pauseButton) {
			this.pauseButton.addEventListener('click', () => this.togglePause());
		}
	}

	setupKeyboard() {
		this.slider.addEventListener('keydown', (e) => {
			switch (e.key) {
			case 'ArrowLeft':
				e.preventDefault();
				this.previousSlide();
				break;
			case 'ArrowRight':
				e.preventDefault();
				this.nextSlide();
				break;
			case 'Home':
				e.preventDefault();
				this.goToSlide(0);
				break;
			case 'End':
				e.preventDefault();
				this.goToSlide(this.totalSlides - 1);
				break;
			}
		});
	}

	setupTouch() {
		let touchStartX = 0;
		let touchEndX = 0;
		const minSwipeDistance = 50;

		this.slider.addEventListener('touchstart', (e) => {
			touchStartX = e.changedTouches[0].screenX;
		}, { passive: true });

		this.slider.addEventListener('touchend', (e) => {
			touchEndX = e.changedTouches[0].screenX;
			const swipeDistance = touchStartX - touchEndX;

			if (Math.abs(swipeDistance) > minSwipeDistance) {
				if (swipeDistance > 0) {
					// Swipe left - next slide
					this.nextSlide();
				} else {
					// Swipe right - previous slide
					this.previousSlide();
				}
			}
		}, { passive: true });
	}

	setupHoverPause() {
		this.slider.addEventListener('mouseenter', () => {
			if (this.autoAdvance && !this.isPaused) {
				this.stopAutoAdvance();
			}
		});

		this.slider.addEventListener('mouseleave', () => {
			if (this.autoAdvance && !this.isPaused) {
				this.startAutoAdvance();
			}
		});
	}

	goToSlide(index) {
		// Ensure index is within bounds
		if (index < 0 || index >= this.totalSlides) {
			return;
		}

		// Remove active class from current slide
		this.slides[this.currentSlide].classList.remove('active');
		this.dots[this.currentSlide].classList.remove('active');
		this.dots[this.currentSlide].setAttribute('aria-selected', 'false');

		// Update current slide
		this.currentSlide = index;

		// Add active class to new slide
		this.slides[this.currentSlide].classList.add('active');
		this.dots[this.currentSlide].classList.add('active');
		this.dots[this.currentSlide].setAttribute('aria-selected', 'true');

		// Announce to screen readers
		this.announceSlide(index);

		// Reset auto-advance timer
		if (this.autoAdvance && !this.isPaused) {
			this.stopAutoAdvance();
			this.startAutoAdvance();
		}
	}

	nextSlide() {
		const nextIndex = (this.currentSlide + 1) % this.totalSlides;
		this.goToSlide(nextIndex);
	}

	previousSlide() {
		const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
		this.goToSlide(prevIndex);
	}

	startAutoAdvance() {
		this.autoAdvanceTimer = setInterval(() => {
			this.nextSlide();
		}, this.advanceSpeed);
	}

	stopAutoAdvance() {
		if (this.autoAdvanceTimer) {
			clearInterval(this.autoAdvanceTimer);
			this.autoAdvanceTimer = null;
		}
	}

	togglePause() {
		this.isPaused = !this.isPaused;

		const pauseIcon = this.pauseButton.querySelector('.pause-icon');
		const playIcon = this.pauseButton.querySelector('.play-icon');

		// Get localized labels from WordPress
		const labels = window.versaliaHeroSlider || { pauseLabel: 'Pause slider', playLabel: 'Play slider' };

		if (this.isPaused) {
			this.stopAutoAdvance();
			this.pauseButton.setAttribute('aria-pressed', 'true');
			this.pauseButton.setAttribute('aria-label', labels.playLabel);
			pauseIcon.style.display = 'none';
			playIcon.style.display = 'inline';
		} else {
			this.startAutoAdvance();
			this.pauseButton.setAttribute('aria-pressed', 'false');
			this.pauseButton.setAttribute('aria-label', labels.pauseLabel);
			pauseIcon.style.display = 'inline';
			playIcon.style.display = 'none';
		}
	}

	announceSlide(index) {
		// Create or update live region for screen reader announcements
		let liveRegion = this.slider.querySelector('.slider-live-region');
		if (!liveRegion) {
			liveRegion = document.createElement('div');
			liveRegion.className = 'slider-live-region';
			liveRegion.setAttribute('aria-live', 'polite');
			liveRegion.setAttribute('aria-atomic', 'true');
			liveRegion.style.position = 'absolute';
			liveRegion.style.left = '-10000px';
			liveRegion.style.width = '1px';
			liveRegion.style.height = '1px';
			liveRegion.style.overflow = 'hidden';
			this.slider.appendChild(liveRegion);
		}

		const slideTitle = this.slides[index].querySelector('.slide-title').textContent;
		liveRegion.textContent = `Slide ${index + 1} of ${this.totalSlides}: ${slideTitle}`;
	}
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
	const slider = document.querySelector('.hero-slider');
	if (slider) {
		new HeroSlider(slider);
	}
});
