/* ========================================
   NAVIGATION
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  initMobileDropdowns();
  initSearchBar();
  initMobileMenu();
  initScrollEffects();
  initBackToTop();
  markCurrentPage();

});

/* ========================================
   HELPERS
======================================== */

const isMobile = () =>
  window.matchMedia('(max-width: 900px)').matches;

/* ========================================
   MOBILE DROPDOWNS
======================================== */

function initMobileDropdowns() {

  const items =
    document.querySelectorAll(
      '.menu-item-has-dropdown'
    );

  items.forEach((item) => {

    const trigger =
      item.querySelector(
        '.menu-link--dropdown'
      );

    const dropdown =
      item.querySelector(
        '.mega-dropdown'
      );

    if (!trigger || !dropdown) return;

    trigger.addEventListener(
      'click',
      (event) => {

        if (!isMobile()) {

          if (
            trigger.tagName === 'BUTTON'
          ) {
            event.preventDefault();
          }

          return;

        }

        event.preventDefault();

        const isOpen =
          item.classList.contains(
            'is-open'
          );

        closeAllDropdowns();

        if (!isOpen) {

          item.classList.add(
            'is-open'
          );

          trigger.setAttribute(
            'aria-expanded',
            'true'
          );

        }

      }
    );

  });

  document.addEventListener(
    'click',
    (event) => {

      if (
        !event.target.closest(
          '.menu-item-has-dropdown'
        )
      ) {
        closeAllDropdowns();
      }

    }
  );

}

function closeAllDropdowns() {

  document
    .querySelectorAll(
      '.menu-item-has-dropdown.is-open'
    )
    .forEach((item) => {

      item.classList.remove(
        'is-open'
      );

      const trigger =
        item.querySelector(
          '.menu-link--dropdown'
        );

      if (trigger) {

        trigger.setAttribute(
          'aria-expanded',
          'false'
        );

      }

    });

}

/* ========================================
   SEARCH BAR
======================================== */

function initSearchBar() {

  const searchToggle =
    document.getElementById(
      'nav-search-toggle'
    );

  const searchBar =
    document.getElementById(
      'nav-search-bar'
    );

  const searchClose =
    document.getElementById(
      'nav-search-close'
    );

  const searchInput =
    document.getElementById(
      'nav-search-input'
    );

  if (!searchToggle || !searchBar)
    return;

  const openSearch = () => {

    searchBar.classList.add(
      'is-visible'
    );

    searchBar.setAttribute(
      'aria-hidden',
      'false'
    );

    searchToggle.setAttribute(
      'aria-expanded',
      'true'
    );

    if (searchInput) {

      setTimeout(() => {
        searchInput.focus();
      }, 50);

    }

  };

  const closeSearch = () => {

    searchBar.classList.remove(
      'is-visible'
    );

    searchBar.setAttribute(
      'aria-hidden',
      'true'
    );

    searchToggle.setAttribute(
      'aria-expanded',
      'false'
    );

  };

  searchToggle.addEventListener(
    'click',
    () => {

      const isVisible =
        searchBar.classList.contains(
          'is-visible'
        );

      isVisible
        ? closeSearch()
        : openSearch();

    }
  );

  if (searchClose) {

    searchClose.addEventListener(
      'click',
      closeSearch
    );

  }

}

/* ========================================
   MOBILE MENU
======================================== */

function initMobileMenu() {

  const toggle =
    document.getElementById(
      'mobile-menu-toggle'
    );

  const menu =
    document.getElementById(
      'primary-menu'
    );

  if (!toggle || !menu) return;

  const openMenu = () => {

    menu.classList.add('is-open');

    toggle.classList.add(
      'is-active'
    );

    document.body.style.overflow =
      'hidden';

  };

  const closeMenu = () => {

    menu.classList.remove(
      'is-open'
    );

    toggle.classList.remove(
      'is-active'
    );

    document.body.style.overflow =
      '';

    closeAllDropdowns();

  };

  toggle.addEventListener(
    'click',
    () => {

      const isOpen =
        menu.classList.contains(
          'is-open'
        );

      isOpen
        ? closeMenu()
        : openMenu();

    }
  );

  const closeBtn = document.querySelector('.mobile-menu-close');
  if (closeBtn) {
    closeBtn.addEventListener('click', closeMenu);
  }

}

/* ========================================
   SCROLL EFFECT
======================================== */

function initScrollEffects() {

  const header =
    document.querySelector(
      '.site-header'
    );

  if (!header) return;

  window.addEventListener(
    'scroll',
    throttle(() => {

      header.classList.toggle(
        'scrolled',
        window.scrollY > 10
      );

    }, 80)
  );

}

/* ========================================
   BACK TO TOP
======================================== */

function initBackToTop() {

  const button =
    document.querySelector(
      '.back-to-top'
    );

  if (!button) return;

  window.addEventListener(
    'scroll',
    throttle(() => {

      button.classList.toggle(
        'show',
        window.scrollY > 300
      );

    }, 100)
  );

  button.addEventListener(
    'click',
    () => {

      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });

    }
  );

}

/* ========================================
   CURRENT PAGE
======================================== */

function markCurrentPage() {

  const currentPath =
    window.location.pathname;

  const hasDefaultInfo = window.location.search.includes('default_info');
  const hasDefaultLecturer = window.location.search.includes('default_lecturer');
  const hasDefaultAchievement = window.location.search.includes('default_achievement');
  const isLecturerSingle = currentPath.includes('/lecturer/') || currentPath.includes('/tenaga-pengajar/') || currentPath.includes('/lecturer') || currentPath.includes('/tenaga-pengajar');
  const isAchievementSingle = currentPath.includes('/prestasi/') || currentPath.includes('/achievement/') || currentPath.includes('/prestasi') || currentPath.includes('/achievement');

  document
    .querySelectorAll(
      '.primary-menu .menu-item > a'
    )
    .forEach((link) => {
      try {
        const rawHref = link.getAttribute('href');
        if (!rawHref || rawHref === '#' || rawHref.startsWith('#')) {
          return;
        }

        const linkPath =
          new URL(link.href).pathname;

        const isHome =
          currentPath === '/' &&
          linkPath === '/' &&
          !hasDefaultInfo &&
          !hasDefaultLecturer &&
          !hasDefaultAchievement;

        const isMatch =
          (!isLecturerSingle && !hasDefaultLecturer && !isAchievementSingle && !hasDefaultAchievement && linkPath !== '/' && currentPath.startsWith(linkPath)) ||
          (hasDefaultInfo && (linkPath.includes('/information') || linkPath.includes('/informasi'))) ||
          ((hasDefaultLecturer || isLecturerSingle) && (linkPath.includes('/about-us') || linkPath.includes('/tentang-kami'))) ||
          ((hasDefaultAchievement || isAchievementSingle) && (linkPath.includes('/student-affairs') || linkPath.includes('/kemahasiswaan')));

        const menuItem = link.closest('.menu-item');
        if (!menuItem) return;

        if (isHome || isMatch) {
          menuItem.classList.add(
            'current-menu-item',
            'active'
          );
        } else {
          // If we are on a lecturer, information, or achievement detail page,
          // proactively clean up home item to prevent double active menus
          if ((hasDefaultInfo || hasDefaultLecturer || isLecturerSingle || hasDefaultAchievement || isAchievementSingle) && linkPath === '/') {
            menuItem.classList.remove('current-menu-item', 'active');
          }
        }

      } catch (_) {}

    });

}

/* ========================================
   THROTTLE
======================================== */

function throttle(callback, delay) {

  let waiting = false;

  return (...args) => {

    if (waiting) return;

    callback(...args);

    waiting = true;

    setTimeout(() => {
      waiting = false;
    }, delay);

  };

}