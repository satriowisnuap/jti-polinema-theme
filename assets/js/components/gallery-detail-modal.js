/* ========================================
   GALLERY DETAIL MODAL
======================================== */

document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('galleryDetailModal');
    if (!modal) return;

    const closeBtn = document.getElementById('galleryModalClose');
    const viewBtn = document.getElementById('galleryModalViewBtn');
    const prevTopicBtn = document.getElementById('galleryModalPrevBtn');
    const nextTopicBtn = document.getElementById('galleryModalNextBtn');
    const backdrop = document.getElementById('galleryModalBackdrop');

    let currentCardIndex = -1;
    let allCurrentCards = [];

    const heroImg = document.getElementById('galleryModalHeroImg');
    const titleEl = document.getElementById('galleryModalTitle');
    const subtitleEl = document.getElementById('galleryModalSubtitle');
    const tagsEl = document.getElementById('galleryModalTags');
    const descEl = document.getElementById('galleryModalDesc');
    const relatedGrid = document.getElementById('galleryModalRelatedGrid');

    // Open Modal Function
    const openModal = (card, index) => {
        currentCardIndex = index;
        
        // Update Nav Button States
        if (prevTopicBtn) {
            prevTopicBtn.disabled = currentCardIndex <= 0;
        }
        if (nextTopicBtn) {
            nextTopicBtn.disabled = currentCardIndex >= allCurrentCards.length - 1;
        }

        const title = card.dataset.title || '';
        const subtitle = card.dataset.subtitle || '';
        const desc = card.dataset.desc || '';
        const image = card.dataset.image || '';
        const tags = card.dataset.tags || '';
        let related = [];
        try {
            related = JSON.parse(card.dataset.related || '[]');
        } catch (e) {
            console.error("Failed to parse related photos", e);
        }

        // Populate Data
        titleEl.textContent = title;
        subtitleEl.textContent = subtitle;
        tagsEl.textContent = tags;
        descEl.textContent = desc;
        
        // Setup Initial Image
        heroImg.src = image;

        // Populate Related Photos
        relatedGrid.innerHTML = '';
        if (related.length > 0) {
            related.forEach((url, idx) => {
                const item = document.createElement('div');
                item.className = 'gallery-modal__related-item';
                item.style.cursor = 'pointer';
                
                const img = document.createElement('img');
                img.src = url;
                img.loading = 'lazy';
                img.alt = 'Related Photo';
                
                // Add click event to swap images
                item.addEventListener('click', () => {
                    const tempSrc = heroImg.src;
                    
                    // Add fade effect for hero image
                    heroImg.style.opacity = 0;
                    img.style.opacity = 0;
                    
                    setTimeout(() => {
                        heroImg.src = img.src;
                        img.src = tempSrc;
                        
                        heroImg.style.opacity = 1;
                        img.style.opacity = 1;
                    }, 200);
                });
                
                // Add CSS transition for smooth fade
                img.style.transition = 'opacity 0.2s ease-in-out';
                
                item.appendChild(img);
                relatedGrid.appendChild(item);
            });
        } else {
            relatedGrid.innerHTML = '<p style="color:var(--neutral-05)">Tidak ada foto terkait.</p>';
        }

        // Show Modal
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
    };

    // Close Modal Function
    let closeModal = () => {
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        
        // Reset clear view and zoom on close
        modal.classList.remove('is-clear-view', 'is-zoomed');
        heroImg.style.transform = '';
        heroImg.style.transformOrigin = '';
        if (viewBtn) viewBtn.innerHTML = iconEye;
        
        // Clear src after animation to avoid seeing old image on next open
        setTimeout(() => {
            heroImg.src = '';
            relatedGrid.innerHTML = '';
        }, 300);
    };

    // Navigation logic
    const navigateTopic = (direction) => {
        if (allCurrentCards.length === 0) return;
        
        let newIndex = currentCardIndex + direction;
        if (newIndex >= 0 && newIndex < allCurrentCards.length) {
            openModal(allCurrentCards[newIndex], newIndex);
        }
    };

    if (prevTopicBtn) {
        prevTopicBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // prevent clear view toggle
            navigateTopic(-1);
        });
    }

    if (nextTopicBtn) {
        nextTopicBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // prevent clear view toggle
            navigateTopic(1);
        });
    }

    // Event Delegation for Cards (works with AJAX)
    document.addEventListener('click', (e) => {
        const card = e.target.closest('.gallery-card');
        if (card) {
            // Update the live list of cards
            allCurrentCards = Array.from(document.querySelectorAll('.gallery-card'));
            const idx = allCurrentCards.indexOf(card);
            if (idx !== -1) {
                openModal(card, idx);
            }
        }
    });

    // Close Event Listeners
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);

    // ========================================
    // CLEAR VIEW & ZOOM LOGIC
    // ========================================
    const iconEye = `<svg class="icon-eye" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>`;
                    
    const iconEyeSlash = `<svg class="icon-eye-slash" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>`;

    const toggleClearView = () => {
        const isClear = modal.classList.toggle('is-clear-view');
        
        // Change icon based on state
        if (viewBtn) {
            viewBtn.innerHTML = isClear ? iconEyeSlash : iconEye;
        }

        // Reset zoom when exiting clear view
        if (!isClear) {
            modal.classList.remove('is-zoomed');
            heroImg.style.transform = '';
            heroImg.style.transformOrigin = '';
        }
    };

    if (viewBtn) {
        viewBtn.addEventListener('click', toggleClearView);
    }
    
    // Allow clicking the hero image background directly (if not clicking on content)
    const modalContent = document.querySelector('.gallery-modal__content-overlay');
    if (modalContent) {
        modalContent.addEventListener('click', (e) => {
            // If user clicked exactly on the overlay (not on any text/box inside it)
            if (e.target === modalContent) {
                toggleClearView();
            }
        });
    }

    // Zooming logic (only when in clear view)
    const modalBg = document.querySelector('.gallery-modal__bg');
    if (modalBg) {
        modalBg.addEventListener('click', (e) => {
            if (!modal.classList.contains('is-clear-view')) return;
            
            if (modal.classList.contains('is-zoomed')) {
                // Zoom out
                modal.classList.remove('is-zoomed');
                heroImg.style.transform = '';
                heroImg.style.transformOrigin = '';
            } else {
                // Zoom in
                modal.classList.add('is-zoomed');
                // Calculate click position for transform origin
                const rect = heroImg.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                
                heroImg.style.transformOrigin = `${x}% ${y}%`;
                heroImg.style.transform = 'scale(2.5)';
            }
        });
    }

    // Keyboard Accessibility
    document.addEventListener('keydown', (e) => {
        if (modal.getAttribute('aria-hidden') === 'false') {
            if (e.key === 'Escape') {
                if (modal.classList.contains('is-clear-view')) {
                    toggleClearView();
                } else {
                    closeModal();
                }
            } else if (e.key === 'ArrowLeft' && !modal.classList.contains('is-clear-view')) {
                navigateTopic(-1);
            } else if (e.key === 'ArrowRight' && !modal.classList.contains('is-clear-view')) {
                navigateTopic(1);
            }
        }
    });

    // Add CSS transition for fade effect dynamically
    heroImg.style.transition = 'opacity 0.2s ease-in-out';
});
