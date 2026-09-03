/* ========================================
   HERO SLIDER
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const heroSection =
    document.getElementById('hero-section');

  if (!heroSection) return;

  const slides =
    [...heroSection.querySelectorAll('.hero-slide')];

  const thumbs =
    [...heroSection.querySelectorAll('.hero-thumb')];

  if (!slides.length) return;

  const duration = 10000;

  let current = 0;
  let timer = null;

  /* ========================================
     APPLY STATE
  ======================================== */

  const applyState = (
    activeIndex,
    exitIndex = null
  ) => {

    slides.forEach((slide, index) => {

      slide.classList.remove(
        'is-active',
        'is-exiting'
      );

      slide.setAttribute(
        'aria-hidden',
        'true'
      );

      if (index === activeIndex) {

        slide.classList.add('is-active');

        slide.setAttribute(
          'aria-hidden',
          'false'
        );

      } else if (index === exitIndex) {

        slide.classList.add('is-exiting');

        slide.addEventListener(
          'transitionend',
          () => {
            slide.classList.remove(
              'is-exiting'
            );
          },
          { once: true }
        );

      }

    });

    thumbs.forEach((thumb, index) => {

      thumb.classList.remove('is-active');

      thumb.setAttribute(
        'aria-pressed',
        'false'
      );

      const progress =
        thumb.querySelector(
          '.hero-thumb__progress-track'
        );

      if (progress) {
        progress.style.animation = 'none';
        void progress.offsetWidth;
      }

      if (index === activeIndex) {

        thumb.classList.add('is-active');

        thumb.setAttribute(
          'aria-pressed',
          'true'
        );

        if (progress) {

          progress.style.animation =
            `hero-progress ${duration}ms linear forwards`;

        }

      }

    });

  };

  /* ========================================
     GO TO
  ======================================== */

  const goTo = (nextIndex) => {

    if (nextIndex === current) return;

    const previous = current;

    current = nextIndex;

    applyState(current, previous);

    resetTimer();

  };

  /* ========================================
     NEXT
  ======================================== */

  const nextSlide = () => {

    const next =
      (current + 1) % slides.length;

    goTo(next);

  };

  /* ========================================
     PREV
  ======================================== */

  const prevSlide = () => {

    const prev =
      (current - 1 + slides.length)
      % slides.length;

    goTo(prev);

  };

  /* ========================================
     TIMER
  ======================================== */

  const startTimer = () => {

    stopTimer();

    timer = setInterval(() => {
      nextSlide();
    }, duration);

  };

  const stopTimer = () => {

    if (!timer) return;

    clearInterval(timer);

    timer = null;

  };

  const resetTimer = () => {

    stopTimer();

    startTimer();

  };

  /* ========================================
     EVENTS
  ======================================== */

  thumbs.forEach((thumb, index) => {

    thumb.addEventListener('click', () => {
      goTo(index);
    });

  });

  document.addEventListener('keydown', (event) => {

    if (event.key === 'ArrowRight') {
      nextSlide();
    }

    if (event.key === 'ArrowLeft') {
      prevSlide();
    }

  });

  /* ========================================
     INIT
  ======================================== */

  applyState(0);

  startTimer();

});