<?php
/**
 * Gallery Grid Section for Kemahasiswaan
 *
 * @package WebJTI_Theme
 */

// Search Logic
$search_query = isset($_GET['gsearch']) ? sanitize_text_field($_GET['gsearch']) : '';

// Pagination Logic
$items_per_page = 9;
$current_page = isset($_GET['gpage']) ? max(1, intval($_GET['gpage'])) : 1;

// WP Query arguments
$args = [
    'post_type'      => 'ormawa_gallery',
    'posts_per_page' => $items_per_page,
    'paged'          => $current_page,
];

if (!empty($search_query)) {
    $args['s'] = $search_query;
}

$gallery_query = new WP_Query($args);
$total_pages = $gallery_query->max_num_pages;
?>

<section class="gallery-kemahasiswaan-section">

    <!-- Search Form -->
    <div class="gallery-search-container">
        <form action="" method="GET" class="gallery-search-form">
            <input type="text" name="gsearch" class="gallery-search-input" placeholder="Cari kegiatan, event, dll..." value="<?php echo esc_attr($search_query); ?>">
            <button type="submit" class="gallery-search-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </form>
    </div>

    <div id="gallery-results-container">
        <div class="gallery-grid-wrapper">
        <?php if (!$gallery_query->have_posts()) : ?>
            <p class="gallery-empty-state">Tidak ada hasil yang ditemukan untuk pencarian "<?php echo esc_html($search_query); ?>"</p>
        <?php endif; ?>
        
        <?php while ($gallery_query->have_posts()) : $gallery_query->the_post(); 
            // Fetch ACF fields
            $title = get_the_title();
            $desc = get_field('description');
            $photo = get_field('gallery_photo');
            if (is_numeric($photo)) {
                $image_url = wp_get_attachment_url((int) $photo);
            } elseif (is_array($photo)) {
                $image_url = $photo['url'] ?? '';
            } else {
                $image_url = (string) $photo;
            }
            if (empty($image_url)) {
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://via.placeholder.com/600x400/1a1a1a/ffffff?text=No+Image';
            }

            $associated_ormawa_id = get_field('associated_ormawa');
            $subtitle = $associated_ormawa_id ? get_the_title($associated_ormawa_id) . ' / ' . get_the_date('Y') : 'Kegiatan / ' . get_the_date('Y');

            $related = [];
            for ($i = 1; $i <= 4; $i++) {
                $rel_val = get_field('related_photo_' . $i);
                if (!empty($rel_val)) {
                    if (is_numeric($rel_val)) {
                        $rel_url = wp_get_attachment_url((int) $rel_val);
                    } elseif (is_array($rel_val)) {
                        $rel_url = $rel_val['url'] ?? '';
                    } else {
                        $rel_url = (string) $rel_val;
                    }
                    if (!empty($rel_url)) {
                        $related[] = esc_url($rel_url);
                    }
                }
            }
        ?>
            <div class="gallery-card" 
                 data-title="<?php echo esc_attr($title); ?>"
                 data-subtitle="<?php echo esc_attr($subtitle); ?>"
                 data-desc="<?php echo esc_attr($desc); ?>"
                 data-image="<?php echo esc_url($image_url); ?>"
                 data-tags=""
                 data-related="<?php echo esc_attr(json_encode($related)); ?>">
                
                <!-- Image -->
                <div class="gallery-card__image-wrapper">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="gallery-card__image" loading="lazy">
                    
                    <!-- Hover Overlay -->
                    <div class="gallery-card__overlay">
                    </div>
                </div>

                <!-- Content -->
                <div class="gallery-card__content">
                    <h3 class="gallery-card__title"><?php echo esc_html($title); ?></h3>
                    <p class="gallery-card__subtitle"><?php echo esc_html($subtitle); ?></p>
                </div>

            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <!-- Pagination Controls -->
    <?php if ($total_pages > 1) : ?>
        <?php 
            $search_param = !empty($search_query) ? '&gsearch=' . urlencode($search_query) : '';
        ?>
        <div class="gallery-pagination">
            <?php if ($current_page > 1) : ?>
                <a href="?gpage=<?php echo $current_page - 1 . $search_param; ?>" data-page="<?php echo $current_page - 1; ?>" class="gallery-page-link prev">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="?gpage=<?php echo $i . $search_param; ?>" data-page="<?php echo $i; ?>" class="gallery-page-link <?php echo $i === $current_page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
                <a href="?gpage=<?php echo $current_page + 1 . $search_param; ?>" data-page="<?php echo $current_page + 1; ?>" class="gallery-page-link next">Next &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </div> <!-- /#gallery-results-container -->

    <!-- The Modal -->
    <div id="galleryDetailModal" class="gallery-modal" aria-hidden="true">
        <div class="gallery-modal__backdrop" id="galleryModalBackdrop"></div>
        <div class="gallery-modal__content-scroll">
            <div class="gallery-modal__dialog">
                
                <!-- Action Buttons -->
                <button class="gallery-modal__action-btn gallery-modal__view-btn" id="galleryModalViewBtn" aria-label="Toggle clear view">
                    <svg class="icon-eye" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
                <button class="gallery-modal__action-btn gallery-modal__close" id="galleryModalClose" aria-label="Close modal">
                    &times;
                </button>

                <!-- Navigation Buttons -->
                <button class="gallery-modal__nav-btn prev" id="galleryModalPrevBtn" aria-label="Previous Topic">
                    &lsaquo;
                </button>
                <button class="gallery-modal__nav-btn next" id="galleryModalNextBtn" aria-label="Next Topic">
                    &rsaquo;
                </button>

                <!-- Background Image -->
                <div class="gallery-modal__bg">
                    <img src="" id="galleryModalHeroImg" alt="Hero Image">
                    <div class="gallery-modal__bg-overlay"></div>
                </div>

                <!-- Content Overlay -->
                <div class="gallery-modal__content-overlay">
                    <div class="gallery-modal__header">
                        <h2 class="gallery-modal__title" id="galleryModalTitle">Title</h2>
                        <div class="gallery-modal__meta">
                            <span id="galleryModalSubtitle" class="gallery-modal__subtitle">Subtitle</span>
                            <span class="gallery-modal__dot">&bull;</span>
                            <span id="galleryModalTags" class="gallery-modal__tags">Tags</span>
                        </div>
                    </div>

                    <div class="gallery-modal__body-layout">
                        <div class="gallery-modal__desc-wrapper">
                            <h3>Deskripsi Kegiatan</h3>
                            <p id="galleryModalDesc" class="gallery-modal__desc">Deskripsi</p>
                        </div>
                        
                        <div class="gallery-modal__related-wrapper">
                            <h3>Foto Terkait</h3>
                            <div id="galleryModalRelatedGrid" class="gallery-modal__related-grid">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.gallery-search-input');
    const searchForm = document.querySelector('.gallery-search-form');
    const resultsContainer = document.getElementById('gallery-results-container');
    let timeout = null;
    let currentAjaxReq = null;

    if (searchInput && searchForm && resultsContainer) {
        // Restore focus and put cursor at the end of the text
        if (searchInput.value) {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }

        // Prevent form submission (we handle it via AJAX)
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });

        // AJAX search function
        const fetchGallery = (search, paged = 1) => {
            if (currentAjaxReq) {
                currentAjaxReq.abort();
            }

            const formData = new FormData();
            formData.append('action', 'webjti_filter_gallery');
            formData.append('search', search);
            formData.append('paged', paged);

            const controller = new AbortController();
            currentAjaxReq = controller;

            resultsContainer.style.opacity = '0.5';

            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
                body: formData,
                signal: controller.signal
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data && data.data.html) {
                    resultsContainer.innerHTML = data.data.html;
                }
                resultsContainer.style.opacity = '1';
                
                // Re-bind modal click events for the new content (since we replaced the DOM)
                // Note: The original gallery modal logic might need to be re-initialized here if it relies on static elements.
                // Assuming it uses event delegation or we dispatch an event.
                document.dispatchEvent(new Event('galleryContentUpdated'));
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    console.error(err);
                    resultsContainer.style.opacity = '1';
                }
            });
        };

        // Auto submit on typing with faster debounce (300ms) for responsive feel
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                fetchGallery(searchInput.value, 1);
            }, 300); 
        });

        // Handle pagination via AJAX
        resultsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('gallery-page-link')) {
                e.preventDefault();
                const page = e.target.getAttribute('data-page');
                if (page) {
                    fetchGallery(searchInput.value, page);
                    resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }
});
</script>
