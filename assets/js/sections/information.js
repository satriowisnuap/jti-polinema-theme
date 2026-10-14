/* ========================================
   INFORMATION INTERACTIVE PAGE LOGIC
   WebJTI Theme (Figma High-Fidelity)
======================================== */

document.addEventListener('DOMContentLoaded', () => {
  const filterResults = document.getElementById('filter-results');
  const filterPagination = document.getElementById('filter-pagination');
  const filterBtns = document.querySelectorAll('.information-filter-bar .filter-btn');
  const searchInput = document.querySelector('.information-search-input');
  
  const semuaWrapper = document.querySelector('.information-semua-wrapper');
  const filteredWrapper = document.querySelector('.information-filtered-wrapper');

  if (!semuaWrapper || !filteredWrapper) return;

  // Active state for AJAX queries dynamically read from the DOM active button (set by PHP)
  const activeBtn = document.querySelector('.information-filter-bar .filter-btn.active');
  let activeType = activeBtn ? activeBtn.getAttribute('data-target') : 'all';
  let searchQuery = searchInput ? searchInput.value.trim() : '';
  let debounceTimeout = null;

  // ========================================
  // CATEGORY TAB SWITCHING
  // ========================================
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-target');
      if (activeType === target) return;

      // Update active class
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      activeType = target;
      
      // If user switched tab, reset pagination to page 1
      applyFilters(1);
    });
  });

  // ========================================
  // SEARCH INPUT DEBOUNCED
  // ========================================
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      searchQuery = e.target.value.trim();

      clearTimeout(debounceTimeout);
      debounceTimeout = setTimeout(() => {
        // Search across the currently selected active type (or all if under all)
        applyFilters(1);
      }, 250); // Premium debouncing delay
    });
  }

  // ========================================
  // PROCESS FILTERS & SWITCH VISIBILITY
  // ========================================
  function applyFilters(page = 1) {
    // Mode 1: Tab "Semua" is active and there is NO search input
    if (activeType === 'all' && searchQuery === '') {
      // Fade out filtered view and show standard Spotlight & Sliders
      filteredWrapper.style.opacity = '0';
      setTimeout(() => {
        filteredWrapper.style.display = 'none';
        semuaWrapper.style.display = 'block';
        setTimeout(() => {
          semuaWrapper.style.opacity = '1';
        }, 50);
      }, 300);
      return;
    }

    // Mode 2: Specific category is selected, or a search is running
    semuaWrapper.style.display = 'none';
    filteredWrapper.style.display = 'block';
    setTimeout(() => {
      filteredWrapper.style.opacity = '1';
    }, 50);

    // Show loading spinner
    filterResults.innerHTML = '<div class="loading-spinner"></div>';
    filterPagination.innerHTML = '';

    // AJAX Form Data
    const formData = new FormData();
    formData.append('action', 'jti_filter_informasi');
    formData.append('type', activeType);
    formData.append('paged', page);
    formData.append('search', searchQuery);

    // Fetch data via WordPress AJAX
    const ajaxUrl = typeof jti_ajax !== 'undefined' ? jti_ajax.ajax_url : '/wp-admin/admin-ajax.php';
    
    fetch(ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(result => {
      if (!result.success) {
        filterResults.innerHTML = '<div class="error-msg" style="text-align: center; padding: 40px; color: var(--neutral-06);">Gagal memuat data. Silakan coba lagi.</div>';
        return;
      }

      // Update grid content and pagination with a smooth fade-in
      filterResults.style.opacity = '0';
      setTimeout(() => {
        filterResults.innerHTML = result.data.content;
        filterPagination.innerHTML = result.data.pagination;
        filterResults.style.opacity = '1';

        // Re-attach click events to the new pagination buttons
        attachPaginationEvents();
      }, 200);
    })
    .catch(error => {
      console.error('Fetch error:', error);
      filterResults.innerHTML = '<div class="error-msg" style="text-align: center; padding: 40px; color: var(--neutral-06);">Koneksi bermasalah. Gagal memuat data.</div>';
    });
  }

  // ========================================
  // PAGINATION CLICKS HANDLER
  // ========================================
  function attachPaginationEvents() {
    const pageButtons = filterPagination.querySelectorAll('a.page-numbers');

    pageButtons.forEach(btn => {
      btn.addEventListener('click', (event) => {
        event.preventDefault();

        // Get page number from link URL or inner text
        const url = new URL(btn.href);
        const pageNumber = url.searchParams.get('paged') || btn.innerText;

        // Smooth scroll to the top of results
        const scrollTarget = document.querySelector('.information-filter-bar');
        if (scrollTarget) {
          scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        applyFilters(parseInt(pageNumber));
      });
    });
  }

  // Initial attach of pagination events if loaded initially in grid mode
  attachPaginationEvents();

  // ========================================
  // HORIZONTAL SLIDERS SCROLL NAV
  // ========================================
  document.querySelectorAll('.information-slider-section').forEach(section => {
    const prevBtn = section.querySelector('.slider-btn-prev');
    const nextBtn = section.querySelector('.slider-btn-next');
    const sliderTrack = section.querySelector('.information-slider-track');

    if (prevBtn && nextBtn && sliderTrack) {
      prevBtn.addEventListener('click', () => {
        const firstItem = sliderTrack.querySelector('.information-slider-item');
        if (firstItem) {
          const scrollAmount = firstItem.offsetWidth + 24; // Width + gap
          sliderTrack.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }
      });

      nextBtn.addEventListener('click', () => {
        const firstItem = sliderTrack.querySelector('.information-slider-item');
        if (firstItem) {
          const scrollAmount = firstItem.offsetWidth + 24;
          sliderTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
      });
    }
  });
});