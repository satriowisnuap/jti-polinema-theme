/* ========================================
   MAIN
======================================== */

/* ========================================
   DOM READY
======================================== */

function domReady(callback) {

  if (document.readyState === 'loading') {

    document.addEventListener(
      'DOMContentLoaded',
      callback
    );

  } else {

    callback();

  }

}

/* ========================================
   UTILITIES
======================================== */

const utils = {

  /* ========================================
     DEBOUNCE
  ======================================== */

  debounce(callback, delay = 300) {

    let timeout;

    return (...args) => {

      clearTimeout(timeout);

      timeout = setTimeout(() => {

        callback(...args);

      }, delay);

    };

  },

  /* ========================================
     THROTTLE
  ======================================== */

  throttle(callback, limit = 100) {

    let waiting = false;

    return (...args) => {

      if (waiting) return;

      callback(...args);

      waiting = true;

      setTimeout(() => {

        waiting = false;

      }, limit);

    };

  },

  /* ========================================
     VIEWPORT CHECK
  ======================================== */

  isInViewport(element) {

    if (!element) return false;

    const rect =
      element.getBoundingClientRect();

    return (

      rect.top <
        window.innerHeight &&

      rect.bottom >
        0 &&

      rect.left <
        window.innerWidth &&

      rect.right >
        0

    );

  },

  /* ========================================
     SMOOTH SCROLL
  ======================================== */

  smoothScroll(
    target,
    offset = 0
  ) {

    const targetElement =
      typeof target === 'string'
        ? document.querySelector(target)
        : target;

    if (!targetElement) return;

    const topPosition =
      targetElement.getBoundingClientRect().top
      + window.pageYOffset
      + offset;

    window.scrollTo({

      top: topPosition,

      behavior: 'smooth'

    });

  },

  /* ========================================
     COPY TO CLIPBOARD
  ======================================== */

  async copyToClipboard(
    text,
    triggerElement = null
  ) {

    if (!navigator.clipboard)
      return false;

    try {

      await navigator.clipboard.writeText(text);

      if (triggerElement) {

        triggerElement.classList.add(
          'copied'
        );

        setTimeout(() => {

          triggerElement.classList.remove(
            'copied'
          );

        }, 2000);

      }

      return true;

    } catch (error) {

      console.error(
        'Clipboard error:',
        error
      );

      return false;

    }

  }

};

/* ========================================
   SCROLL PROGRESS
======================================== */

function initScrollIndicator() {

  const progressBar =
    document.getElementById(
      'scroll-progress-bar'
    );

  if (!progressBar) return;

  const updateProgress = () => {

    const scrollTop =
      window.scrollY;

    const documentHeight =
      document.documentElement.scrollHeight
      - window.innerHeight;

    const progress =
      (scrollTop / documentHeight)
      * 100;

    progressBar.style.width =
      `${progress}%`;

  };

  window.addEventListener(
    'scroll',
    utils.throttle(updateProgress, 10)
  );

}

/* ========================================
   APP INIT
======================================== */

domReady(() => {

  console.log(
    'WebJTI initialized'
  );

  initScrollIndicator();

});

/* ========================================
   GLOBAL ACCESS
======================================== */

window.utils = utils;