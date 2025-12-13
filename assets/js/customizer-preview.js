/**
 * Customizer Live Preview
 *
 * Handles live preview of customizer changes.
 *
 * @package Versalia
 * @since 1.0.0
 */

(function($) {
	'use strict';

	// Site title
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a').text(to);
		});
	});

	// Site description
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});

	// Header text color
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip': 'auto',
					'position': 'relative'
				});
				$('.site-title a, .site-description').css({
					'color': to
				});
			}
		});
	});

	// Accent color
	wp.customize('versalia_accent_color', function(value) {
		value.bind(function(to) {
			document.documentElement.style.setProperty('--color-accent', to);
		});
	});

	// Font preset
	wp.customize('versalia_font_preset', function(value) {
		value.bind(function(to) {
			// Remove all font preset classes
			$('body').removeClass('font-preset-classic font-preset-modern font-preset-contemporary font-preset-traditional');

			// Add new preset class
			if (to !== 'classic') {
				$('body').addClass('font-preset-' + to);
			}

			// Update font preset data attribute
			$('body').attr('data-font-preset', to);
		});
	});

	// Archive view style
	wp.customize('versalia_archive_view', function(value) {
		value.bind(function(to) {
			$('.poem-archive-container').removeClass('view-list view-grid').addClass('view-' + to);
		});
	});

	// Show/hide poem meta fields
	wp.customize('versalia_show_date_written', function(value) {
		value.bind(function(to) {
			$('.poem-meta-item.date-written').toggle(to);
		});
	});

	wp.customize('versalia_show_poetry_form', function(value) {
		value.bind(function(to) {
			$('.poem-meta-item.poetry-form').toggle(to);
		});
	});

	wp.customize('versalia_show_reading_time', function(value) {
		value.bind(function(to) {
			$('.poem-meta-item.reading-time').toggle(to);
		});
	});

})(jQuery);
