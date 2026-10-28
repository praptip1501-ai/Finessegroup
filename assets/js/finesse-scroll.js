/**
 * Finesse Scroll Animations & Observer Fallback
 * Provides smooth reveals for .rv, .w, .draw, .clip, and parallax effects
 */
(function() {
  'use strict';

  function initScrollFx() {
    // Word-by-word scroll reveal for .intro-heading
    const introHeading = document.querySelector('.intro-heading');
    if (introHeading) {
      const words = introHeading.querySelectorAll('.w');
      if (words.length > 0) {
        let ticking = false;
        function updateWordReveal() {
          const vh = window.innerHeight || document.documentElement.clientHeight;
          words.forEach(function(w) {
            const rect = w.getBoundingClientRect();
            // Start revealing when word reaches 85% of viewport; fully bright at 52%
            const startY = vh * 0.85;
            const endY   = vh * 0.52;
            if (rect.top >= startY) {
              w.style.opacity = '0.18';
              w.style.transform = 'translateY(2px)';
            } else if (rect.top <= endY) {
              w.style.opacity = '1';
              w.style.transform = 'translateY(0)';
            } else {
              const p = (startY - rect.top) / (startY - endY);
              const op = 0.18 + (p * 0.82);
              w.style.opacity = op.toFixed(3);
              w.style.transform = 'translateY(' + ((1 - p) * 2).toFixed(1) + 'px)';
            }
          });
          ticking = false;
        }

        function requestWordUpdate() {
          if (!ticking) {
            window.requestAnimationFrame(updateWordReveal);
            ticking = true;
          }
        }

        window.addEventListener('scroll', requestWordUpdate, { passive: true });
        window.addEventListener('resize', requestWordUpdate, { passive: true });
        // Initial run
        requestWordUpdate();
      }
    }

    // IntersectionObserver for .rv, .draw, .clip elements
    if ('IntersectionObserver' in window) {
      const revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'none';
            if (entry.target.classList.contains('draw')) {
              entry.target.style.transform = 'scaleX(1)';
            }
            if (entry.target.classList.contains('clip')) {
              entry.target.style.clipPath = 'inset(0 0 0 0)';
            }
          }
        });
      }, {
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
      });

      document.querySelectorAll('.rv, .draw, .clip').forEach(function(el) {
        revealObserver.observe(el);
      });
    }

    // Parallax effect on hover or subtle scroll for .par
    const parElements = document.querySelectorAll('.par');
    if (parElements.length > 0 && window.innerWidth > 960) {
      window.addEventListener('scroll', function() {
        const scrollY = window.pageYOffset;
        parElements.forEach(function(el) {
          const rect = el.getBoundingClientRect();
          if (rect.top < window.innerHeight && rect.bottom > 0) {
            const offset = (rect.top - window.innerHeight / 2) * 0.06;
            el.style.transform = `scale(1.15) translateY(${offset.toFixed(1)}px)`;
          }
        });
      }, { passive: true });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollFx);
  } else {
    initScrollFx();
  }
})();
