/* ========================================
   UNIVERSAL GALLERY — Auto-scroll Marquee + Centering
   Handles Laboratory & Ormawa galleries:
   1. ≤3 items → center track, no animation
   2. >3 items → duplicate items for infinite
      marquee, then start CSS animation
   3. Hover pauses animation
======================================== */

(function () {
  'use strict';

  const CARD_WIDTH_PX  = 320;
  const GAP_PX         = 20;
  const MAX_VISIBLE    = 3;
  const PX_PER_SECOND  = 65;

  function initAllGalleries () {
    const gallerySections = document.querySelectorAll('.lab-gallery-section, .ormawa-gallery-section, .ormawa-gallery');
    gallerySections.forEach(section => {
      const wraps = section.querySelectorAll('.lab-gallery-slider-wrap, .slider-container, .ormawa-gallery__slider-container');
      
      wraps.forEach(container => {
        const track = container.querySelector('.lab-gallery-grid, .ormawa-gallery__track, .slider-track');
        if (!track || track.classList.contains('is-initialized')) return;
        track.classList.add('is-initialized');

        const items = Array.from(track.children);
        const total = items.length;
        if (!total) return;

        if (total <= MAX_VISIBLE) {
          track.classList.add('is-centered');
          return;
        }

        // Duplicate items for continuous marquee
        items.forEach(item => {
          const clone = item.cloneNode(true);
          clone.setAttribute('aria-hidden', 'true');
          track.appendChild(clone);
        });

        const firstWidth = items[0].offsetWidth || CARD_WIDTH_PX;
        const oneSetWidth = total * (firstWidth + GAP_PX);
        const durationSec = Math.round(oneSetWidth / PX_PER_SECOND);

        track.style.setProperty('--gallery-scroll-dist', `-${oneSetWidth}px`);
        track.style.setProperty('--gallery-scroll-dur',  `${durationSec}s`);

        track.classList.add('is-auto-scrolling');

        // Pause on hover
        container.addEventListener('mouseenter', () => {
          track.style.animationPlayState = 'paused';
        });
        container.addEventListener('mouseleave', () => {
          track.style.animationPlayState = 'running';
        });
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllGalleries);
  } else {
    initAllGalleries();
  }

})();
