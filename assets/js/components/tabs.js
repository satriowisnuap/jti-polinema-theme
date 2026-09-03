/* ========================================
   TABS
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const tabContainers =
    document.querySelectorAll('.tabs-container');

  if (!tabContainers.length) return;

  tabContainers.forEach((container) => {

    const tabButtons =
      container.querySelectorAll('.tab-btn');

    const tabPanels =
      container.querySelectorAll('.tab-panel');

    if (
      !tabButtons.length ||
      !tabPanels.length
    ) return;

    /* ========================================
       INIT
    ======================================== */

    showTab(container, 0);

    /* ========================================
       CLICK EVENTS
    ======================================== */

    tabButtons.forEach((button, index) => {

      button.addEventListener('click', () => {
        showTab(container, index);
      });

    });

    /* ========================================
       KEYBOARD NAVIGATION
    ======================================== */

    container.addEventListener('keydown', (event) => {

      const currentIndex =
        getActiveTabIndex(container);

      let nextIndex = currentIndex;

      switch (event.key) {

        case 'ArrowLeft':
          nextIndex =
            currentIndex > 0
              ? currentIndex - 1
              : tabButtons.length - 1;
          break;

        case 'ArrowRight':
          nextIndex =
            currentIndex < tabButtons.length - 1
              ? currentIndex + 1
              : 0;
          break;

        case 'Home':
          nextIndex = 0;
          break;

        case 'End':
          nextIndex = tabButtons.length - 1;
          break;

        default:
          return;

      }

      event.preventDefault();

      showTab(container, nextIndex);

    });

  });

  bindTabPagination();

});

function bindTabPagination() {
  const paginatedTabs = document.querySelectorAll('[data-mata-kuliah-pagination]');
  if (!paginatedTabs.length) return;

  paginatedTabs.forEach((paginationRoot) => {
    const container = paginationRoot.closest('.tabs-container');
    if (!container) return;

    const pageButtons = paginationRoot.querySelectorAll('[data-pagination-page]');
    const pagePanels = container.querySelectorAll('[data-page]');

    if (!pageButtons.length || !pagePanels.length) return;

    pageButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const pageIndex = button.getAttribute('data-pagination-page');
        if (pageIndex === null) return;

        const activeClass = 'active';

        pageButtons.forEach((btn) => btn.classList.toggle(activeClass, btn === button));

        pagePanels.forEach((panel) => {
          if (panel.getAttribute('data-page') === pageIndex) {
            panel.style.display = 'block';
          } else {
            panel.style.display = 'none';
          }
        });
      });
    });
  });
}

/* ========================================
   SHOW TAB
======================================== */

function showTab(container, index) {

  const tabButtons =
    container.querySelectorAll('.tab-btn');

  const tabPanels =
    container.querySelectorAll('.tab-panel');

  tabButtons.forEach((button, i) => {

    const isActive = i === index;

    button.classList.toggle(
      'active',
      isActive
    );

    button.setAttribute(
      'aria-selected',
      isActive
    );

    button.setAttribute(
      'tabindex',
      isActive ? '0' : '-1'
    );

  });

  tabPanels.forEach((panel, i) => {

    const isActive = i === index;

    panel.classList.toggle(
      'active',
      isActive
    );

    panel.setAttribute(
      'aria-hidden',
      !isActive
    );

  });

  /* ========================================
     CUSTOM EVENT
  ======================================== */

  const tabChangedEvent =
    new CustomEvent('tabChanged', {

      detail: {
        container,
        activeIndex: index,
        activeButton: tabButtons[index],
        activePanel: tabPanels[index]
      }

    });

  container.dispatchEvent(
    tabChangedEvent
  );

}

/* ========================================
   GET ACTIVE INDEX
======================================== */

function getActiveTabIndex(container) {

  const activeButton =
    container.querySelector('.tab-btn.active');

  const tabButtons =
    [...container.querySelectorAll('.tab-btn')];

  return tabButtons.indexOf(activeButton);

}