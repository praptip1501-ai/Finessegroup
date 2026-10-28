/**
 * Finesse Header & Scroll Progress
 */
(function() {
  'use strict';

  function initHeader() {
    const prog = document.querySelector('.prog');
    const toggle = document.querySelector('.fin-menu-toggle');
    const mobileMenu = document.querySelector('.fin-mobile-menu');

    // Scroll progress bar fallback
    function updateProgress() {
      if (!prog) return;
      const scrollTotal = document.documentElement.scrollHeight - window.innerHeight;
      if (scrollTotal <= 0) {
        prog.style.transform = 'scaleX(0)';
        return;
      }
      const progress = Math.min(Math.max(window.scrollY / scrollTotal, 0), 1);
      prog.style.transform = 'scaleX(' + progress + ')';
    }

    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();

    // Mobile menu toggle
    if (toggle && mobileMenu) {
      toggle.addEventListener('click', function() {
        const expanded = toggle.getAttribute('aria-expanded') === 'true' || false;
        toggle.setAttribute('aria-expanded', !expanded);
        mobileMenu.classList.toggle('is-active');
        document.body.style.overflow = !expanded ? 'hidden' : '';
      });

      // Close when clicking mobile links
      mobileMenu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
          toggle.setAttribute('aria-expanded', 'false');
          mobileMenu.classList.remove('is-active');
          document.body.style.overflow = '';
        });
      });
    }

    // Smooth scroll for internal hash links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
      anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#' || targetId === '#top') {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
          return;
        }
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          e.preventDefault();
          const barHeight = 72;
          const targetPosition = targetEl.getBoundingClientRect().top + window.pageYOffset - barHeight;
          window.scrollTo({ top: targetPosition, behavior: 'smooth' });
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeader);
  } else {
    initHeader();
  }
})();
