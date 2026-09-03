/**
 * Staff Card JS Component
 * WebJTI Theme (Figma High-Fidelity)
 *
 * Handles real-time segmented division filtering, instant client-side search query matching,
 * custom dynamic count badges, and smooth horizontal slider arrow scroll operations.
 */
(function() {

  function getStaffBadgeText(dept, count) {
    if (dept === 'Akademik') {
      return `${count} Admin`;
    } else if (dept === 'PLP') {
      return `${count} Pranata`;
    } else if (dept === 'Administrasi BMN') {
      return `${count} Admin`;
    } else if (dept === 'Administrasi Jurusan') {
      return `${count} Admin`;
    } else if (dept === 'Teknisi Jurusan') {
      return `${count} Teknisi`;
    }
    return `${count} Staff`;
  }

  // ========================================
  // DYNAMIC SEGMENTED FILTER & LIVE SEARCH
  // ========================================
  function initStaffFiltering() {
    const segmentedContainer = document.querySelector('.staff-filter-bar .filter-list.segmented');
    const searchInput = document.querySelector('.staff-search-input');
    const deptGroupAll = document.querySelector('.staff-department-group-wrapper');
    const deptGroupGrid = document.querySelector('.staff-department-group-grid-wrapper');
    const noResultsEl = document.querySelector('.staff-no-results');

    if (!segmentedContainer) return;

    const filterBtns = segmentedContainer.querySelectorAll('.filter-btn');
    
    // Active filters states
    let currentDeptFilter = 'all';
    let searchQuery = '';

    // Click segment buttons
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        currentDeptFilter = btn.getAttribute('data-department');
        applyFilterAndSearch();
      });
    });

    // Real-time search inputs
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase().trim();
        applyFilterAndSearch();
      });
    }

    // Scroll buttons smooth slide operation
    document.querySelectorAll('.staff-department-section').forEach(section => {
      const prevBtn = section.querySelector('.slider-btn-prev');
      const nextBtn = section.querySelector('.slider-btn-next');
      const sliderContainer = section.querySelector('.staff-slider__container');

      if (prevBtn && nextBtn && sliderContainer) {
        prevBtn.addEventListener('click', () => {
          const item = sliderContainer.querySelector('.staff-slider__item');
          if (item) {
            const cardWidth = item.offsetWidth + 24; // width + gap
            sliderContainer.scrollBy({ left: -cardWidth, behavior: 'smooth' });
          }
        });

        nextBtn.addEventListener('click', () => {
          const item = sliderContainer.querySelector('.staff-slider__item');
          if (item) {
            const cardWidth = item.offsetWidth + 24;
            sliderContainer.scrollBy({ left: cardWidth, behavior: 'smooth' });
          }
        });
      }
    });

    function applyFilterAndSearch() {
      let overallVisibleCount = 0;

      // Handle "Semua" filter (Mode 1: Department Sliders)
      if (currentDeptFilter === 'all') {
        deptGroupAll.style.display = 'block';
        deptGroupGrid.style.display = 'none';

        const deptSections = deptGroupAll.querySelectorAll('.staff-department-section');
        deptSections.forEach(section => {
          const sliderItems = section.querySelectorAll('.staff-slider__item');
          const deptKey = section.getAttribute('data-department');
          let deptVisibleCount = 0;

          sliderItems.forEach(item => {
            const name = item.querySelector('.staff-card__name').textContent.toLowerCase();
            const position = item.querySelector('.staff-card__position').textContent.toLowerCase();
            const textToMatch = name + ' ' + position;

            const matchesSearch = textToMatch.includes(searchQuery);

            if (matchesSearch) {
              item.style.display = 'block';
              deptVisibleCount++;
              overallVisibleCount++;
            } else {
              item.style.display = 'none';
            }
          });

          // Toggle visibility of sliders
          if (deptVisibleCount > 0) {
            section.style.display = 'block';
            
            // Adjust badges
            const badgeTextEl = section.querySelector('.staff-section__badge-text');
            const total = badgeTextEl.getAttribute('data-total');
            if (searchQuery !== '') {
              badgeTextEl.textContent = `${deptVisibleCount} dari ${getStaffBadgeText(deptKey, total)}`;
            } else {
              badgeTextEl.textContent = getStaffBadgeText(deptKey, total);
            }
          } else {
            section.style.display = 'none';
          }
        });

      } else {
        // Handle Individual Department filter (Mode 2: Single Department static grid)
        deptGroupAll.style.display = 'none';
        deptGroupGrid.style.display = 'block';

        const deptWrappers = deptGroupGrid.querySelectorAll('.staff-single-department-wrapper');
        deptWrappers.forEach(wrapper => {
          const wrapperDept = wrapper.getAttribute('data-department');

          if (wrapperDept === currentDeptFilter) {
            wrapper.style.display = 'block';

            const gridItems = wrapper.querySelectorAll('.staff-grid__item');
            let gridVisibleCount = 0;

            gridItems.forEach(item => {
              const name = item.querySelector('.staff-card__name').textContent.toLowerCase();
              const position = item.querySelector('.staff-card__position').textContent.toLowerCase();
              const textToMatch = name + ' ' + position;

              const matchesSearch = textToMatch.includes(searchQuery);

              if (matchesSearch) {
                item.style.display = 'block';
                gridVisibleCount++;
                overallVisibleCount++;
              } else {
                item.style.display = 'none';
              }
            });

            // Toggle grid section visibility
            const sectionEl = wrapper.querySelector('.staff-dept-section');
            if (gridVisibleCount > 0) {
              sectionEl.style.display = 'block';
              
              // Adjust badges
              const badgeTextEl = wrapper.querySelector('.staff-section__badge-text');
              const total = badgeTextEl.getAttribute('data-total');
              if (searchQuery !== '') {
                badgeTextEl.textContent = `${gridVisibleCount} dari ${getStaffBadgeText(wrapperDept, total)}`;
              } else {
                badgeTextEl.textContent = getStaffBadgeText(wrapperDept, total);
              }
            } else {
              sectionEl.style.display = 'none';
            }

          } else {
            wrapper.style.display = 'none';
          }
        });
      }

      // No results placeholder toggling
      if (overallVisibleCount === 0) {
        noResultsEl.style.display = 'block';
      } else {
        noResultsEl.style.display = 'none';
      }
    }
  }

  // ========================================
  // RUN LIFE CYCLES
  // ========================================
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      initStaffFiltering();
    });
  } else {
    initStaffFiltering();
  }

})();
