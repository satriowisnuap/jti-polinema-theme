/* ========================================
   SLIDER — Reusable horizontal drag-scroll slider
   Supports:
     • Prev/Next buttons   (.slider-btn-prev / .slider-btn-next)
     • Mouse drag-to-scroll (click + drag left/right)
     • Touch swipe         (touchstart / touchmove)
     • Mouse-wheel horizontal scroll
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const sliders =
    document.querySelectorAll(
      '.slider-container'
    );

  if (!sliders.length) return;

  sliders.forEach((slider) => {

    const track =
      slider.querySelector(
        '.slider-track'
      );

    const wrapper =
      slider.closest(
        '.slider-wrapper'
      );

    if (!track || !wrapper)
      return;

    const prevButton =
      wrapper.querySelector(
        '.slider-btn-prev'
      );

    const nextButton =
      wrapper.querySelector(
        '.slider-btn-next'
      );

    /* ========================================
       GET SCROLL AMOUNT
       Use the width of one slider-item + gap
    ======================================== */

    const getScrollAmount = () => {

      const item =
        track.querySelector(
          '.slider-item'
        );

      if (!item) return 300;

      const gap = parseFloat(getComputedStyle(track).gap) || 24;

      return (
        item.offsetWidth + gap
      );

    };

    /* ========================================
       BUTTON: NEXT
    ======================================== */

    if (nextButton) {
      nextButton.addEventListener(
        'click',
        () => {
          slider.scrollBy({
            left: getScrollAmount(),
            behavior: 'smooth'
          });
        }
      );
    }

    /* ========================================
       BUTTON: PREV
    ======================================== */

    if (prevButton) {
      prevButton.addEventListener(
        'click',
        () => {
          slider.scrollBy({
            left: -getScrollAmount(),
            behavior: 'smooth'
          });
        }
      );
    }

    /* ========================================
       BUTTON STATE UPDATE (disabled when at ends)
    ======================================== */

    const updateButtonStates = () => {
      if (prevButton) {
        prevButton.disabled = slider.scrollLeft <= 0;
      }
      if (nextButton) {
        nextButton.disabled =
          Math.ceil(slider.scrollLeft + slider.clientWidth) >= slider.scrollWidth - 1;
      }
    };

    slider.addEventListener('scroll', updateButtonStates, { passive: true });
    setTimeout(updateButtonStates, 150);

    /* ========================================
       MOUSE DRAG-TO-SCROLL
       Always enabled regardless of button presence
    ======================================== */

    let isDragging = false;
    let dragStartX;
    let dragScrollLeft;
    let hasMoved = false;

    slider.style.cursor = 'grab';

    slider.addEventListener('mousedown', (e) => {
      // Don't hijack right-click or middle-click
      if (e.button !== 0) return;
      isDragging = true;
      hasMoved   = false;
      dragStartX  = e.pageX - slider.offsetLeft;
      dragScrollLeft = slider.scrollLeft;
      slider.style.cursor       = 'grabbing';
      slider.style.scrollSnapType = 'none';
      slider.style.scrollBehavior = 'auto';
    });

    window.addEventListener('mouseup', () => {
      if (!isDragging) return;
      isDragging = false;
      slider.style.cursor       = 'grab';
      slider.style.scrollSnapType = '';
      slider.style.scrollBehavior = '';
    });

    slider.addEventListener('mouseleave', () => {
      if (!isDragging) return;
      isDragging = false;
      slider.style.cursor       = 'grab';
      slider.style.scrollSnapType = '';
      slider.style.scrollBehavior = '';
    });

    slider.addEventListener('mousemove', (e) => {
      if (!isDragging) return;
      const x    = e.pageX - slider.offsetLeft;
      const walk = x - dragStartX;
      // Only start moving if we've dragged more than 5px (threshold)
      if (!hasMoved && Math.abs(walk) < 5) return;
      hasMoved = true;
      e.preventDefault();
      slider.scrollLeft = dragScrollLeft - walk * 1.5;
    });

    // Prevent click on items if we actually dragged
    slider.addEventListener('click', (e) => {
      if (hasMoved) {
        e.preventDefault();
        e.stopImmediatePropagation();
      }
    }, true);

    /* ========================================
       TOUCH SWIPE (mobile)
    ======================================== */

    let touchStartX    = 0;
    let touchScrollLeft = 0;

    slider.addEventListener('touchstart', (e) => {
      touchStartX    = e.touches[0].pageX;
      touchScrollLeft = slider.scrollLeft;
    }, { passive: true });

    slider.addEventListener('touchmove', (e) => {
      const dx = touchStartX - e.touches[0].pageX;
      slider.scrollLeft = touchScrollLeft + dx;
    }, { passive: true });

    /* ========================================
       MOUSE WHEEL → horizontal scroll
    ======================================== */

    slider.addEventListener('wheel', (e) => {
      if (e.deltaX !== 0) return; // let native horizontal wheel pass
      e.preventDefault();
      slider.scrollBy({
        left: e.deltaY > 0 ? getScrollAmount() : -getScrollAmount(),
        behavior: 'smooth'
      });
    }, { passive: false });

  });

});