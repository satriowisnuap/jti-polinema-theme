<?php
/**
 * Template part for displaying the Penelitian (Laboratory Preview) section
 *
 * @package WebJTI_Theme
 */

$labs = webjti_get_laboratories();

// Palette accent per lab card (rotates by index)
$lab_palettes = [
    ['icon_bg' => '#EEF7FF', 'icon_color' => '#1672FA', 'badge_bg' => '#EEF7FF', 'badge_color' => '#1349BA', 'border_accent' => '#BADFFF'],
    ['icon_bg' => '#FFF9ED', 'icon_color' => '#EE6D08', 'badge_bg' => '#FFF9ED', 'badge_color' => '#C55209', 'border_accent' => '#FFDFA9'],
    ['icon_bg' => '#ECFDF5', 'icon_color' => '#059669', 'badge_bg' => '#ECFDF5', 'badge_color' => '#065F46', 'border_accent' => '#A7F3D0'],
    ['icon_bg' => '#FDF4FF', 'icon_color' => '#9333EA', 'badge_bg' => '#FDF4FF', 'badge_color' => '#7E22CE', 'border_accent' => '#E9D5FF'],
    ['icon_bg' => '#FFF1F2', 'icon_color' => '#E11D48', 'badge_bg' => '#FFF1F2', 'badge_color' => '#9F1239', 'border_accent' => '#FECDD3'],
    ['icon_bg' => '#FFF7ED', 'icon_color' => '#EA580C', 'badge_bg' => '#FFF7ED', 'badge_color' => '#9A3412', 'border_accent' => '#FED7AA'],
    ['icon_bg' => '#ECFEFF', 'icon_color' => '#0891B2', 'badge_bg' => '#ECFEFF', 'badge_color' => '#164E63', 'border_accent' => '#A5F3FC'],
    ['icon_bg' => '#F0FDF4', 'icon_color' => '#16A34A', 'badge_bg' => '#F0FDF4', 'badge_color' => '#14532D', 'border_accent' => '#BBF7D0'],
];

// Calculate summary stats
$total_researchers = 0;
$all_focus_tags = [];

foreach ($labs as $lab) {
    $total_researchers += (int) $lab['member_count'];
    if (!empty($lab['research_focus'])) {
        foreach ($lab['research_focus'] as $tag) {
            if (!in_array($tag, $all_focus_tags, true)) {
                $all_focus_tags[] = $tag;
            }
        }
    }
}
?>

<section class="penelitian-section">

    <!-- Header Block -->
    <div class="penelitian-header">
        <div class="penelitian-header__content">
            <span class="badge badge--research-sub">
                <i class="ph ph-flask"></i>
                <?php echo esc_html(get_theme_mod('jti_penelitian_badge_text', 'Riset & Inovasi')); ?>
            </span>
            <h2 class="penelitian-header__title">
                <?php echo esc_html(get_theme_mod('jti_penelitian_title_text', 'Laboratorium Riset & Penelitian')); ?>
            </h2>
            <p class="penelitian-header__desc">
                <?php echo esc_html(get_theme_mod('jti_penelitian_desc_text', 'Pusat pengembangan teknologi terapan, riset kecerdasan buatan, keamanan siber, dan rekayasa sistem Jurusan Teknologi Informasi Politeknik Negeri Malang.')); ?>
            </p>
        </div>

        <!-- Summary Stats Cards -->
        <div class="penelitian-stats">
            <div class="penelitian-stat-card">
                <div class="penelitian-stat-card__icon">
                    <i class="ph ph-flask"></i>
                </div>
                <div class="penelitian-stat-card__info">
                    <span class="penelitian-stat-card__value"><?php echo esc_html(count($labs)); ?></span>
                    <span class="penelitian-stat-card__label"><?php esc_html_e('Laboratorium Riset', 'webjti'); ?></span>
                </div>
            </div>

            <div class="penelitian-stat-card">
                <div class="penelitian-stat-card__icon">
                    <i class="ph ph-users-three"></i>
                </div>
                <div class="penelitian-stat-card__info">
                    <span class="penelitian-stat-card__value"><?php echo esc_html($total_researchers); ?></span>
                    <span class="penelitian-stat-card__label"><?php esc_html_e('Dosen Peneliti', 'webjti'); ?></span>
                </div>
            </div>

            <div class="penelitian-stat-card">
                <div class="penelitian-stat-card__icon">
                    <i class="ph ph-target"></i>
                </div>
                <div class="penelitian-stat-card__info">
                    <span class="penelitian-stat-card__value"><?php echo esc_html(count($all_focus_tags)); ?>+</span>
                    <span class="penelitian-stat-card__label"><?php esc_html_e('Fokus Riset', 'webjti'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Toolbar -->
    <div class="penelitian-toolbar">
        <div class="penelitian-toolbar__search">
            <i class="ph ph-magnifying-glass"></i>
            <input
                type="text"
                id="labSearchInput"
                placeholder="<?php esc_attr_e('Cari laboratorium, kepala lab, atau kata kunci...', 'webjti'); ?>"
            />
        </div>
    </div>

    <!-- Laboratory Cards List -->
    <div class="penelitian-labs-list" id="laboratoryGrid">
        <?php foreach ($labs as $index => $lab) :
            $search_haystack = strtolower($lab['title'] . ' ' . $lab['code'] . ' ' . $lab['head_name'] . ' ' . implode(' ', $lab['research_focus']));
        ?>
            <div class="lab-card" data-search="<?php echo esc_attr($search_haystack); ?>">

                <!-- Top Hero Header: Badges + Direct Unboxed Logo -->
                <div class="lab-card__hero">
                    <div class="lab-card__hero-badges">
                        <span class="lab-card__code-badge">
                            <?php echo esc_html($lab['code']); ?>
                        </span>
                        <?php if (!empty($lab['room_location'])) : ?>
                            <span class="lab-card__location-badge">
                                <i class="ph ph-map-pin"></i>
                                <span><?php echo esc_html($lab['room_location']); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="lab-card__logo-container">
                        <?php if (!empty($lab['logo'])) : ?>
                            <img
                                src="<?php echo esc_url($lab['logo']); ?>"
                                alt="<?php echo esc_attr($lab['title']); ?>"
                                class="lab-card__logo-img"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <div class="lab-card__logo-fallback" style="display:none;">
                                <i class="ph ph-flask"></i>
                                <span><?php echo esc_html($lab['code']); ?></span>
                            </div>
                        <?php else : ?>
                            <div class="lab-card__logo-fallback">
                                <i class="ph ph-flask"></i>
                                <span><?php echo esc_html($lab['code']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Body: Title, Description & Research Focus -->
                <div class="lab-card__body">
                    <h3 class="lab-card__title">
                        <a href="<?php echo esc_url($lab['permalink']); ?>">
                            <?php echo esc_html($lab['title']); ?>
                        </a>
                    </h3>

                    <p class="lab-card__description">
                        <?php echo esc_html($lab['short_description']); ?>
                    </p>

                    <?php if (!empty($lab['research_focus'])) : ?>
                        <div class="lab-card__focus-tags">
                            <span class="lab-focus-label">
                                <i class="ph ph-target"></i>
                                <?php esc_html_e('Fokus Riset:', 'webjti'); ?>
                            </span>
                            <div class="lab-focus-list">
                                <?php foreach ($lab['research_focus'] as $focus) : ?>
                                    <span class="lab-focus-badge">
                                        <?php echo esc_html($focus); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Meta Row: Head of Lab + Researchers + Actions -->
                <div class="lab-card__footer">
                    <div class="lab-head-info">
                        <div class="lab-head-info__avatar">
                            <img
                                src="<?php echo esc_url($lab['head_photo']); ?>"
                                alt="<?php echo esc_attr($lab['head_name']); ?>"
                                class="lab-head-info__img"
                            />
                        </div>
                        <div class="lab-head-info__details">
                            <span class="lab-head-info__label">
                                <i class="ph ph-user-circle-gear"></i>
                                <?php esc_html_e('Kepala Lab', 'webjti'); ?>
                            </span>
                            <span class="lab-head-info__name"><?php echo esc_html($lab['head_name']); ?></span>
                        </div>
                    </div>

                    <div class="lab-card__footer-right">
                        <div class="lab-researchers-info">
                            <div class="lab-researchers-info__icon-wrap">
                                <i class="ph ph-users-three"></i>
                            </div>
                            <div class="lab-researchers-info__details">
                                <span class="lab-researchers-info__value"><?php echo esc_html($lab['member_count']); ?></span>
                                <span class="lab-researchers-info__label"><?php esc_html_e('Peneliti', 'webjti'); ?></span>
                            </div>
                        </div>

                        <div class="lab-card__actions">
                            <?php if (!empty($lab['head_sinta_url'])) : ?>
                                <a
                                    href="<?php echo esc_url($lab['head_sinta_url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="lab-btn lab-btn--sinta"
                                    title="<?php esc_attr_e('Profil SINTA Kepala Lab', 'webjti'); ?>"
                                >
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/>
                                    </svg>
                                    <span><?php esc_html_e('SINTA', 'webjti'); ?></span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lab['website_url'])) : ?>
                                <a
                                    href="<?php echo esc_url($lab['website_url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="lab-btn lab-btn--website"
                                    title="<?php esc_attr_e('Kunjungi Website Laboratorium', 'webjti'); ?>"
                                >
                                    <i class="ph ph-globe"></i>
                                    <span><?php esc_html_e('Website', 'webjti'); ?></span>
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo esc_url($lab['permalink']); ?>" class="lab-btn lab-btn--detail">
                                <span><?php esc_html_e('Detail Lab', 'webjti'); ?></span>
                                <i class="ph ph-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div><!-- .lab-card -->
        <?php endforeach; ?>
    </div><!-- .penelitian-labs-list -->

    <!-- Pagination -->
    <div class="penelitian-pagination" id="labPagination" style="display: none;"></div>

    <!-- Empty Search State -->
    <div id="labEmptyState" class="penelitian-empty-state" style="display: none;">
        <i class="ph ph-magnifying-glass"></i>
        <h3><?php esc_html_e('Laboratorium tidak ditemukan', 'webjti'); ?></h3>
        <p><?php esc_html_e('Coba gunakan kata kunci pencarian yang berbeda.', 'webjti'); ?></p>
    </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('labSearchInput');
    const labCards = Array.from(document.querySelectorAll('#laboratoryGrid .lab-card'));
    const emptyState = document.getElementById('labEmptyState');
    const paginationContainer = document.getElementById('labPagination');

    const ITEMS_PER_PAGE = 3;
    let currentPage = 1;

    function updateDisplay() {
        const term = searchInput ? searchInput.value.toLowerCase().trim() : '';

        // Filter cards by search query
        const matchingCards = labCards.filter(function (card) {
            const haystack = card.getAttribute('data-search') || '';
            return !term || haystack.includes(term);
        });

        // Hide all cards first
        labCards.forEach(function (card) {
            card.style.display = 'none';
        });

        const totalItems = matchingCards.length;
        const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);

        if (totalItems === 0) {
            if (emptyState) emptyState.style.display = 'block';
            if (paginationContainer) {
                paginationContainer.style.display = 'none';
                paginationContainer.innerHTML = '';
            }
            return;
        }

        if (emptyState) emptyState.style.display = 'none';

        if (currentPage > totalPages) currentPage = 1;
        if (currentPage < 1) currentPage = 1;

        // Show cards for current page (max 3)
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;
        const pageCards = matchingCards.slice(start, end);

        pageCards.forEach(function (card) {
            card.style.display = '';
        });

        // Render Pagination Controls
        if (paginationContainer) {
            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
                paginationContainer.innerHTML = '';
            } else {
                paginationContainer.style.display = 'flex';
                let html = '';

                // Prev Button
                html += `<button class="page-link prev-page ${currentPage === 1 ? 'disabled' : ''}" ${currentPage === 1 ? 'disabled' : ''}>
                            <i class="ph ph-caret-left"></i>
                         </button>`;

                // Page Numbers
                for (let i = 1; i <= totalPages; i++) {
                    html += `<button class="page-link page-number ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
                }

                // Next Button
                html += `<button class="page-link next-page ${currentPage === totalPages ? 'disabled' : ''}" ${currentPage === totalPages ? 'disabled' : ''}>
                            <i class="ph ph-caret-right"></i>
                         </button>`;

                paginationContainer.innerHTML = html;

                // Event listeners for page number buttons
                paginationContainer.querySelectorAll('.page-number').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        currentPage = parseInt(this.getAttribute('data-page'), 10);
                        updateDisplay();
                        scrollToGrid();
                    });
                });

                // Prev event listener
                const prevBtn = paginationContainer.querySelector('.prev-page');
                if (prevBtn && currentPage > 1) {
                    prevBtn.addEventListener('click', function () {
                        currentPage--;
                        updateDisplay();
                        scrollToGrid();
                    });
                }

                // Next event listener
                const nextBtn = paginationContainer.querySelector('.next-page');
                if (nextBtn && currentPage < totalPages) {
                    nextBtn.addEventListener('click', function () {
                        currentPage++;
                        updateDisplay();
                        scrollToGrid();
                    });
                }
            }
        }
    }

    function scrollToGrid() {
        const grid = document.getElementById('laboratoryGrid');
        if (grid) {
            grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            currentPage = 1;
            updateDisplay();
        });
    }

    // Initial run
    updateDisplay();
});
</script>
