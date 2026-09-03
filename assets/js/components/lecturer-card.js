/**
 * Lecturer Card JS Component
 * WebJTI Theme
 *
 * Handles dynamic single-row tag calculation with popups, real-time segmented filter clicks,
 * instant search query matchers, and smooth horizontal slide arrow operations.
 */
(function() {
  
  // ========================================
  // DYNAMIC SINGLE-ROW TAG CALCULATION
  // ========================================
  function adjustLecturerTags() {
    const containers = document.querySelectorAll('.lecturer-card__tags-row');
    if (!containers.length) return;

    containers.forEach(container => {
      // Skip calculation if the card is hidden to prevent zero-width calculation bugs
      const card = container.closest('.lecturer-card');
      if (card && getComputedStyle(card).display === 'none') return;

      // Use parent (.lecturer-card__skills) offsetWidth — it's a pure block-level element
      // whose width always equals card inner width minus left/right padding (Card Width - 48px)
      const parentWidth = container.parentElement.offsetWidth;
      const tags = Array.from(container.querySelectorAll('.staff-tag'));
      const moreBadge = container.querySelector('.tag-more');
      const moreTextEl = container.querySelector('.tag-more-text');
      const tooltipList = container.querySelector('.expertise-tooltip__list');

      if (!moreBadge || !moreTextEl || !tooltipList) return;

      // Reset styles for layout measurement
      moreBadge.style.display = 'none';
      tooltipList.innerHTML = '';
      tags.forEach(tag => {
        tag.style.display = 'inline-flex';
      });

      // If no tags, we do nothing
      if (tags.length === 0) return;

      // Measure sizes
      const gap = 8; // standard gap of 8px from Figma
      let accumulatedWidth = 0;
      let visibleTagsCount = 0;
      let isOverflowed = false;

      const moreBadgeEstimate = 45; // pixels for "+N" badge

      for (let i = 0; i < tags.length; i++) {
        const tag = tags[i];
        const tagWidth = tag.offsetWidth;

        // Calculate potential width if we add this tag
        const isLast = (i === tags.length - 1);
        let potentialWidth = accumulatedWidth + tagWidth;
        if (visibleTagsCount > 0) {
          potentialWidth += gap;
        }

        // If we overflow, or if we have overflowed in previous iterations
        if (isOverflowed || potentialWidth > parentWidth) {
          isOverflowed = true;
          tag.style.display = 'none';
          
          // Add to tooltip list
          const skillText = tag.textContent.trim();
          const li = document.createElement('li');
          li.className = 'expertise-tooltip__item';
          li.textContent = skillText;
          tooltipList.appendChild(li);
        } else {
          // Check if we need to account for moreBadge width in case the NEXT tags overflow.
          if (!isLast) {
            const nextPotentialWidthWithMore = potentialWidth + gap + moreBadgeEstimate;
            if (nextPotentialWidthWithMore > parentWidth) {
              isOverflowed = true;
              tag.style.display = 'none';
              
              // Add to tooltip list
              const skillText = tag.textContent.trim();
              const li = document.createElement('li');
              li.className = 'expertise-tooltip__item';
              li.textContent = skillText;
              tooltipList.appendChild(li);
              continue;
            }
          }

          accumulatedWidth = potentialWidth;
          visibleTagsCount++;
        }
      }

      // If we did overflow, show the more badge and populate the count
      if (isOverflowed) {
        const remainingCount = tags.length - visibleTagsCount;
        if (remainingCount > 0) {
          moreTextEl.textContent = `+${remainingCount}`;
          moreBadge.style.display = 'inline-flex';
        }
      }
    });
  }

  // ========================================
  // DYNAMIC SEGMENTED FILTER & LIVE SEARCH
  // ========================================
  function initLecturerFiltering() {
    const segmentedContainer = document.querySelector('.filter-list.segmented');
    const searchInput = document.querySelector('.lecturer-search-input');
    const campusGroupAll = document.querySelector('.lecturer-campus-group-wrapper');
    const campusGroupProdi = document.querySelector('.lecturer-campus-group-prodi-wrapper');
    const noResultsEl = document.querySelector('.lecturer-no-results');

    if (!segmentedContainer) return;

    const filterBtns = segmentedContainer.querySelectorAll('.filter-btn');
    
    // Active filters states
    let currentCampusFilter = 'all';
    let searchQuery = '';

    // Click segment buttons
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        currentCampusFilter = btn.getAttribute('data-campus');
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
    document.querySelectorAll('.lecturer-campus-section').forEach(section => {
      const prevBtn = section.querySelector('.slider-btn-prev');
      const nextBtn = section.querySelector('.slider-btn-next');
      const sliderContainer = section.querySelector('.lecturer-slider__container');

      if (prevBtn && nextBtn && sliderContainer) {
        prevBtn.addEventListener('click', () => {
          const item = sliderContainer.querySelector('.lecturer-slider__item');
          if (item) {
            const cardWidth = item.offsetWidth + 24; // width + gap
            sliderContainer.scrollBy({ left: -cardWidth, behavior: 'smooth' });
          }
        });

        nextBtn.addEventListener('click', () => {
          const item = sliderContainer.querySelector('.lecturer-slider__item');
          if (item) {
            const cardWidth = item.offsetWidth + 24;
            sliderContainer.scrollBy({ left: cardWidth, behavior: 'smooth' });
          }
        });
      }
    });

    function applyFilterAndSearch() {
      let overallVisibleCount = 0;

      // Handle "Semua" filter (Mode 1: Campus Sliders)
      if (currentCampusFilter === 'all') {
        campusGroupAll.style.display = 'block';
        campusGroupProdi.style.display = 'none';

        const campusSections = campusGroupAll.querySelectorAll('.lecturer-campus-section');
        campusSections.forEach(section => {
          const sliderItems = section.querySelectorAll('.lecturer-slider__item');
          let campusVisibleCount = 0;

          sliderItems.forEach(item => {
            const name = item.querySelector('.lecturer-card__name').textContent.toLowerCase();
            const skills = Array.from(item.querySelectorAll('.staff-tag')).map(tag => tag.textContent.toLowerCase());
            const textToMatch = name + ' ' + skills.join(' ');

            const matchesSearch = textToMatch.includes(searchQuery);

            if (matchesSearch) {
              item.style.display = 'block';
              campusVisibleCount++;
              overallVisibleCount++;
            } else {
              item.style.display = 'none';
            }
          });

          // Toggle visibility of sliders
          if (campusVisibleCount > 0) {
            section.style.display = 'block';
            
            // Adjust badges
            const badgeTextEl = section.querySelector('.lecturer-section__badge-text');
            const total = badgeTextEl.getAttribute('data-total');
            if (searchQuery !== '') {
              badgeTextEl.textContent = `${campusVisibleCount} dari ${total} Tenaga Pengajar`;
            } else {
              badgeTextEl.textContent = `${total} Tenaga Pengajar`;
            }
          } else {
            section.style.display = 'none';
          }
        });

      } else {
        // Handle Individual Campus filter (Mode 2: Study Program static grids)
        campusGroupAll.style.display = 'none';
        campusGroupProdi.style.display = 'block';

        const campusWrappers = campusGroupProdi.querySelectorAll('.lecturer-single-campus-wrapper');
        campusWrappers.forEach(wrapper => {
          const wrapperCampus = wrapper.getAttribute('data-campus');

          if (wrapperCampus === currentCampusFilter) {
            wrapper.style.display = 'block';

            const prodiSections = wrapper.querySelectorAll('.lecturer-prodi-section');
            prodiSections.forEach(section => {
              const gridItems = section.querySelectorAll('.lecturer-grid__item');
              let prodiVisibleCount = 0;

              gridItems.forEach(item => {
                const name = item.querySelector('.lecturer-card__name').textContent.toLowerCase();
                const skills = Array.from(item.querySelectorAll('.staff-tag')).map(tag => tag.textContent.toLowerCase());
                const textToMatch = name + ' ' + skills.join(' ');

                const matchesSearch = textToMatch.includes(searchQuery);

                if (matchesSearch) {
                  item.style.display = 'block';
                  prodiVisibleCount++;
                  overallVisibleCount++;
                } else {
                  item.style.display = 'none';
                }
              });

              // Toggle visibility of prodi sections
              if (prodiVisibleCount > 0) {
                section.style.display = 'block';
                
                // Adjust badges
                const badgeTextEl = section.querySelector('.lecturer-section__badge-text');
                const total = badgeTextEl.getAttribute('data-total');
                if (searchQuery !== '') {
                  badgeTextEl.textContent = `${prodiVisibleCount} dari ${total} Tenaga Pengajar`;
                } else {
                  badgeTextEl.textContent = `${total} Tenaga Pengajar`;
                }
              } else {
                section.style.display = 'none';
              }
            });

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

      // Run dynamic tags width recalculation on newly visible elements
      setTimeout(adjustLecturerTags, 100);
    }
  }

  // ========================================
  // RUN LIFE CYCLES
  // ========================================
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      adjustLecturerTags();
      initLecturerFiltering();
      setTimeout(adjustLecturerTags, 200);
      window.addEventListener('load', () => {
        adjustLecturerTags();
      });
    });
  } else {
    adjustLecturerTags();
    initLecturerFiltering();
    setTimeout(adjustLecturerTags, 200);
    window.addEventListener('load', () => {
      adjustLecturerTags();
    });
  }

  // Debounced window resize calculation
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(adjustLecturerTags, 100);
  });

})();
