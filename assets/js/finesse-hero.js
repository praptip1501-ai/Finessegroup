/**
 * Finesse Hero Interactive Logic & Wordmark Animation Trigger
 */
(function() {
  'use strict';

  function initHero() {
    const hero = document.querySelector('.hero');
    if (!hero) return;

    // Trigger animations via .go class
    function startAnimation() {
      hero.classList.remove('go');
      // Force reflow
      void hero.offsetWidth;
      hero.classList.add('go');
    }

    // IntersectionObserver to start animation on first view
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            startAnimation();
            observer.unobserve(hero);
          }
        });
      }, { threshold: 0.15 });
      observer.observe(hero);
    } else {
      startAnimation();
    }

    // Replay on clicking wordmark
    const wordmark = hero.querySelector('[data-act="replay"]');
    if (wordmark) {
      wordmark.addEventListener('click', function(e) {
        e.preventDefault();
        startAnimation();
      });
    }

    // Ensure hero video autoplays safely
    const video = document.getElementById('heroVideo');
    if (video) {
      video.muted = true;
      video.playsInline = true;
      const playPromise = video.play();
      if (playPromise !== undefined) {
        playPromise.catch(function() {
          // Auto-play was prevented; video will show poster
        });
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHero);
  } else {
    initHero();
  }
})();
