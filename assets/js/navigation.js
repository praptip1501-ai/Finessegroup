/**
 * Navigation Toggle for Mobile Menu
 *
 * @package Workstation
 * @since 1.0.0
 */

(function() {
	'use strict';

	const menuToggle = document.querySelector('.menu-toggle');
	const primaryMenu = document.getElementById('primary-menu');
	const navigation = document.getElementById('site-navigation');

	if (!menuToggle || !primaryMenu || !navigation) {
		return;
	}

	const closeMenu = function() {
		menuToggle.setAttribute('aria-expanded', 'false');
		navigation.classList.remove('is-open');
		primaryMenu.classList.remove('active');
	};

	// Toggle menu visibility
	menuToggle.addEventListener('click', function(e) {
		e.preventDefault();
		const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
		menuToggle.setAttribute('aria-expanded', String(!isExpanded));
		navigation.classList.toggle('is-open', !isExpanded);
		primaryMenu.classList.toggle('active');
	});

	// Close menu when clicking on a link
	const menuLinks = primaryMenu.querySelectorAll('a');
	menuLinks.forEach(function(link) {
		link.addEventListener('click', function() {
			closeMenu();
		});
	});

	// Close menu when clicking outside
	document.addEventListener('click', function(e) {
		if (!e.target.closest('nav') && !e.target.closest('.menu-toggle')) {
			closeMenu();
		}
	});

	// Close menu on Escape key
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape') {
			closeMenu();
		}
	});

	// Trap focus inside the menu when it's open
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Tab' && navigation.classList.contains('is-open')) {
			const focusableElements = navigation.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
			if (focusableElements.length === 0) return;
			const firstElement = focusableElements[0];
			const lastElement = focusableElements[focusableElements.length - 1];

			if (e.shiftKey) {
				if (document.activeElement === firstElement) {
					e.preventDefault();
					lastElement.focus();
				}
			} else {
				if (document.activeElement === lastElement) {
					e.preventDefault();
					firstElement.focus();
				}
			}
		}
	});
})();
