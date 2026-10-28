/**
 * Main JavaScript for Workstation Theme
 *
 * @package Workstation
 * @since 1.0.0
 */

(function() {
	'use strict';

	// Add keyboard navigation for dropdown menus
	const menuItems = document.querySelectorAll('.primary-menu > li');

	menuItems.forEach(function(item) {
		const subMenu = item.querySelector('ul');

		if (!subMenu) {
			return;
		}

		const links = item.querySelectorAll('a');
		const firstLink = links[0];
		const lastLink = links[links.length - 1];

		// Handle keyboard navigation
		firstLink.addEventListener('keydown', function(e) {
			if (e.key === 'ArrowDown') {
				e.preventDefault();
				item.classList.add('is-focus-open');
				const firstSubLink = subMenu.querySelector('a');
				if (firstSubLink) {
					firstSubLink.focus();
				}
			}
		});

		lastLink.addEventListener('keydown', function(e) {
			if (e.key === 'ArrowUp') {
				e.preventDefault();
				firstLink.focus();
			}
		});

		// Close submenu on blur
		item.addEventListener('focusout', function(e) {
			if (!item.contains(e.relatedTarget)) {
				item.classList.remove('is-focus-open');
			}
		});
	});

	// Smooth scroll for anchor links
	document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
		anchor.addEventListener('click', function(e) {
			const href = this.getAttribute('href');
			const target = document.querySelector(href);

			if (target) {
				e.preventDefault();
				target.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});

				if (target.tagName === 'H1' || target.tagName === 'H2') {
					target.focus();
				}
			}
		});
	});

	// Set focus to form fields for better accessibility
	const forms = document.querySelectorAll('form');
	forms.forEach(function(form) {
		const inputs = form.querySelectorAll('input, textarea, select');
		inputs.forEach(function(input) {
			input.addEventListener('focus', function() {
				this.parentElement.classList.add('has-focus');
			});
			input.addEventListener('blur', function() {
				if (!this.value) {
					this.parentElement.classList.remove('has-focus');
				}
			});
		});
	});

})();
