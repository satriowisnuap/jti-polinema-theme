/* ========================================
   GALLERY LIGHTBOX (Interactive Zoom, Drag to Pan & Lightbox Toolbar)
   WebJTI Theme
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  let currentZoom = 1;
  let panX = 0;
  let panY = 0;
  let isDragging = false;
  let startX = 0;
  let startY = 0;

  const resetZoomState = () => {
    currentZoom = 1;
    panX = 0;
    panY = 0;
    isDragging = false;
    const img = document.querySelector('#gallery-lightbox #lightbox-img');
    if (img) {
      img.classList.remove('is-zoomed', 'is-dragging');
      img.style.transform = 'none';
    }
  };

  const applyZoomTransform = () => {
    const img = document.querySelector('#gallery-lightbox #lightbox-img');
    if (!img) return;

    if (currentZoom > 1) {
      img.classList.add('is-zoomed');
      img.style.transform = `scale(${currentZoom}) translate(${panX / currentZoom}px, ${panY / currentZoom}px)`;
    } else {
      resetZoomState();
    }
  };

  // Function to dynamically find or create #gallery-lightbox if missing
  const getLightbox = () => {
    let lightbox = document.getElementById('gallery-lightbox');
    if (!lightbox) {
      lightbox = document.createElement('div');
      lightbox.id = 'gallery-lightbox';
      lightbox.className = 'gallery-lightbox';
      lightbox.setAttribute('aria-hidden', 'true');
      lightbox.innerHTML = `
        <div class="lightbox-overlay"></div>
        <div class="lightbox-toolbar">
          <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-in" title="Perbesar (Zoom In)">
            <i class="ph ph-magnifying-glass-plus"></i> <span>Zoom In</span>
          </button>
          <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-out" title="Perkecil (Zoom Out)">
            <i class="ph ph-magnifying-glass-minus"></i> <span>Zoom Out</span>
          </button>
          <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-reset" title="Ukuran Semula">
            <i class="ph ph-arrows-out-cardinal"></i> <span>Reset</span>
          </button>
          <a class="lightbox-tool-btn lightbox-tool-btn--primary" id="lightbox-download-link" href="#" target="_blank" download title="Download">
            <i class="ph ph-download-simple"></i> <span>Download</span>
          </a>
        </div>
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-img" class="lightbox-content" src="" alt="Foto Full">
        <div class="prev"><i class="ph ph-caret-left"></i></div>
        <div class="next"><i class="ph ph-caret-right"></i></div>
      `;
      document.body.appendChild(lightbox);
    }

    // Ensure toolbar exists inside lightbox
    let toolbar = lightbox.querySelector('.lightbox-toolbar');
    if (!toolbar) {
      toolbar = document.createElement('div');
      toolbar.className = 'lightbox-toolbar';
      toolbar.innerHTML = `
        <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-in" title="Perbesar (Zoom In)">
          <i class="ph ph-magnifying-glass-plus"></i> <span>Zoom In</span>
        </button>
        <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-out" title="Perkecil (Zoom Out)">
          <i class="ph ph-magnifying-glass-minus"></i> <span>Zoom Out</span>
        </button>
        <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-reset" title="Ukuran Semula">
          <i class="ph ph-arrows-out-cardinal"></i> <span>Reset</span>
        </button>
        <a class="lightbox-tool-btn lightbox-tool-btn--primary" id="lightbox-download-link" href="#" target="_blank" download title="Download">
          <i class="ph ph-download-simple"></i> <span>Download</span>
        </a>
      `;
      lightbox.appendChild(toolbar);
    }

    return lightbox;
  };

  const setupLightboxControls = (lightbox) => {
    if (!lightbox) return;

    const closeBtn = lightbox.querySelector('.lightbox-close');
    const overlayBtn = lightbox.querySelector('.lightbox-overlay');
    const prevBtn = lightbox.querySelector('.prev');
    const nextBtn = lightbox.querySelector('.next');
    const img = lightbox.querySelector('#lightbox-img');

    if (lightbox.dataset.controlsBound !== 'true') {
      lightbox.dataset.controlsBound = 'true';

      closeBtn?.addEventListener('click', closeLightbox);
      overlayBtn?.addEventListener('click', closeLightbox);
      nextBtn?.addEventListener('click', nextImage);
      prevBtn?.addEventListener('click', previousImage);

      // Toggle zoom on image click
      img?.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentZoom === 1) {
          currentZoom = 2.2;
        } else {
          currentZoom = 1;
        }
        applyZoomTransform();
      });

      // Mouse wheel zoom
      img?.addEventListener('wheel', (e) => {
        e.preventDefault();
        if (e.deltaY < 0) {
          currentZoom = Math.min(currentZoom + 0.25, 4);
        } else {
          currentZoom = Math.max(currentZoom - 0.25, 1);
        }
        applyZoomTransform();
      });

      // Drag to pan when zoomed
      img?.addEventListener('mousedown', (e) => {
        if (currentZoom <= 1) return;
        isDragging = true;
        startX = e.clientX - panX;
        startY = e.clientY - panY;
        img.classList.add('is-dragging');
      });

      window.addEventListener('mousemove', (e) => {
        if (!isDragging || currentZoom <= 1) return;
        panX = e.clientX - startX;
        panY = e.clientY - startY;
        applyZoomTransform();
      });

      window.addEventListener('mouseup', () => {
        if (isDragging) {
          isDragging = false;
          img?.classList.remove('is-dragging');
        }
      });
    }

    // Always bind zoom toolbar buttons if present and not yet bound
    const toolbar = lightbox.querySelector('.lightbox-toolbar');
    if (toolbar && toolbar.dataset.zoomBound !== 'true') {
      toolbar.dataset.zoomBound = 'true';

      const zoomInBtn = toolbar.querySelector('#lightbox-zoom-in');
      const zoomOutBtn = toolbar.querySelector('#lightbox-zoom-out');
      const zoomResetBtn = toolbar.querySelector('#lightbox-zoom-reset');

      zoomInBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        currentZoom = Math.min(currentZoom + 0.5, 4);
        applyZoomTransform();
      });

      zoomOutBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        currentZoom = Math.max(currentZoom - 0.5, 1);
        applyZoomTransform();
      });

      zoomResetBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        resetZoomState();
      });
    }
  };

  let currentGalleryItems = [];
  let currentIndex = 0;

  /* ========================================
     UPDATE LIGHTBOX
  ======================================== */

  const updateLightbox = () => {
    const lightbox = getLightbox();
    setupLightboxControls(lightbox);
    resetZoomState();

    const imageElement = lightbox.querySelector('#lightbox-img');
    const counter = lightbox.querySelector('#current-idx');
    const downloadLink = lightbox.querySelector('#lightbox-download-link');

    if (!currentGalleryItems.length) return;
    const currentItem = currentGalleryItems[currentIndex];
    let fullUrl = currentItem ? (currentItem.dataset.full || currentItem.getAttribute('src')) : '';
    if ((!fullUrl || fullUrl.length < 5) && currentItem) {
      const imgEl = currentItem.querySelector('img');
      if (imgEl) fullUrl = imgEl.src;
    }

    if (fullUrl && imageElement) {
      imageElement.src = fullUrl;
    }

    if (downloadLink) {
      downloadLink.href = fullUrl || '#';
      if (!fullUrl) {
        downloadLink.style.display = 'none';
      } else {
        downloadLink.style.display = 'inline-flex';
      }
    }

    if (counter) {
      counter.textContent = currentIndex + 1;
    }

    // Hide prev/next if only 1 item
    const prevBtn = lightbox.querySelector('.prev');
    const nextBtn = lightbox.querySelector('.next');
    if (prevBtn && nextBtn) {
      if (currentGalleryItems.length <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
      } else {
        prevBtn.style.display = 'flex';
        nextBtn.style.display = 'flex';
      }
    }
  };

  /* ========================================
     OPEN LIGHTBOX
  ======================================== */

  const openLightbox = (items, index) => {
    const lightbox = getLightbox();
    currentGalleryItems = items;
    currentIndex = index;

    updateLightbox();

    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  };

  /* ========================================
     CLOSE LIGHTBOX
  ======================================== */

  const closeLightbox = () => {
    const lightbox = getLightbox();
    if (lightbox) {
      lightbox.setAttribute('aria-hidden', 'true');
    }
    resetZoomState();
    document.body.style.overflow = '';
  };

  /* ========================================
     NEXT / PREVIOUS NAVIGATION
  ======================================== */

  const nextImage = () => {
    if (!currentGalleryItems.length) return;
    currentIndex = (currentIndex + 1) % currentGalleryItems.length;
    updateLightbox();
  };

  const previousImage = () => {
    if (!currentGalleryItems.length) return;
    currentIndex = (currentIndex - 1 + currentGalleryItems.length) % currentGalleryItems.length;
    updateLightbox();
  };

  /* ========================================
     EVENT DELEGATION (Click handling)
  ======================================== */

  document.addEventListener('click', (event) => {
    const item = event.target.closest('.gallery-item');
    if (!item) return;

    // Find container to group related gallery items
    const container = item.closest('.slider-track, .lab-gallery-grid, .ormawa-gallery-section, .lab-gallery-section, .page-content, main') || document;
    
    // Filter items with valid data-full or src
    let allItems = Array.from(container.querySelectorAll('.gallery-item')).filter(el => {
      return (el.dataset.full || el.getAttribute('src')) && !el.closest('[aria-hidden="true"]');
    });

    if (!allItems.length) {
      allItems = Array.from(document.querySelectorAll('.gallery-item')).filter(el => el.dataset.full || el.getAttribute('src'));
    }

    let itemIndex = allItems.indexOf(item);
    
    // Fallback if clicked item is a clone
    if (itemIndex === -1 && allItems.length > 0) {
      const clickedFull = item.dataset.full || item.getAttribute('src');
      itemIndex = allItems.findIndex(el => (el.dataset.full || el.getAttribute('src')) === clickedFull);
      if (itemIndex === -1) itemIndex = 0;
    }

    if (itemIndex !== -1) {
      event.preventDefault();
      openLightbox(allItems, itemIndex);
    }
  });

  // Setup initial controls if DOM already contains #gallery-lightbox
  const existingLightbox = document.getElementById('gallery-lightbox');
  if (existingLightbox) {
    setupLightboxControls(existingLightbox);
  }

  /* ========================================
     KEYBOARD NAVIGATION
  ======================================== */

  document.addEventListener('keydown', (event) => {
    const lightbox = document.getElementById('gallery-lightbox');
    if (!lightbox || lightbox.getAttribute('aria-hidden') !== 'false') return;

    switch (event.key) {
      case 'Escape':
        closeLightbox();
        break;

      case 'ArrowRight':
        nextImage();
        break;

      case 'ArrowLeft':
        previousImage();
        break;

      case '+':
      case '=':
        currentZoom = Math.min(currentZoom + 0.5, 4);
        applyZoomTransform();
        break;

      case '-':
      case '_':
        currentZoom = Math.max(currentZoom - 0.5, 1);
        applyZoomTransform();
        break;

      case '0':
        resetZoomState();
        break;
    }
  });

});