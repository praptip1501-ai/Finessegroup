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
      const totalWords = words.length;
      if (totalWords > 0) {
        let ticking = false;
        function updateWordReveal() {
          const vh = window.innerHeight || document.documentElement.clientHeight;
          const headingRect = introHeading.getBoundingClientRect();
          // Start revealing when heading enters at 88% of viewport, fully bright by 40%
          const startY = vh * 0.88;
          const endY   = vh * 0.40;
          const totalProgress = Math.min(Math.max((startY - headingRect.top) / (startY - endY), 0), 1);

          words.forEach(function(w, idx) {
            // Stagger each word across the scroll range for a genuine word-by-word reveal
            const wordStart = (idx / totalWords) * 0.72;
            const wordEnd   = wordStart + 0.28;
            let p = (totalProgress - wordStart) / (wordEnd - wordStart);
            p = Math.min(Math.max(p, 0), 1);

            const op = (0.18 + (p * 0.82)).toFixed(3);
            const ty = ((1 - p) * 3).toFixed(1);

            w.style.opacity = op;
            w.style.transform = 'translateY(' + ty + 'px)';
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
