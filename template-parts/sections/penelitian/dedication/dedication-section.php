<?php
/**
 * Dedication (Pengabdian Kepada Masyarakat) Section Template
 *
 * @package WebJTI_Theme
 */

$dedications_by_year = webjti_get_dedications();

// Calculate summary stats
$total_projects = 0;
$all_lecturers = [];
$years_list = array_keys($dedications_by_year);

foreach ($dedications_by_year as $year => $projects) {
    $total_projects += count($projects);
    foreach ($projects as $proj) {
        if (!empty($proj['leader'])) {
            $all_lecturers[$proj['leader']] = true;
        }
        if (!empty($proj['members']) && is_array($proj['members'])) {
            foreach ($proj['members'] as $member) {
                $all_lecturers[$member] = true;
            }
        }
    }
}
$total_lecturers = count($all_lecturers);
?>

<section class="dedication-section">
    <!-- Header Block -->
    <div class="dedication-header">
        <div class="dedication-header__content">
            <span class="badge badge--hero-sub">
                <i class="ph ph-globe-hemisphere-east"></i>
                <?php esc_html_e('Tridharma Perguruan Tinggi', 'webjti'); ?>
            </span>
            <h2 class="dedication-header__title">
                <?php esc_html_e('Pengabdian Kepada Masyarakat', 'webjti'); ?>
            </h2>
            <p class="dedication-header__desc">
                <?php esc_html_e('Daftar rekapitulasi kegiatan pengabdian masyarakat yang telah dilaksanakan oleh Dosen Jurusan Teknologi Informasi Politeknik Negeri Malang.', 'webjti'); ?>
            </p>
        </div>

        <!-- Summary Stats Cards -->
        <div class="dedication-stats">
            <div class="dedication-stat-card">
                <div class="dedication-stat-card__icon">
                    <i class="ph ph-folders"></i>
                </div>
                <div class="dedication-stat-card__info">
                    <span class="dedication-stat-card__value"><?php echo esc_html($total_projects); ?></span>
                    <span class="dedication-stat-card__label"><?php esc_html_e('Total Kegiatan', 'webjti'); ?></span>
                </div>
            </div>

            <div class="dedication-stat-card">
                <div class="dedication-stat-card__icon">
                    <i class="ph ph-users-three"></i>
                </div>
                <div class="dedication-stat-card__info">
                    <span class="dedication-stat-card__value"><?php echo esc_html($total_lecturers); ?></span>
                    <span class="dedication-stat-card__label"><?php esc_html_e('Dosen Terlibat', 'webjti'); ?></span>
                </div>
            </div>

            <div class="dedication-stat-card">
                <div class="dedication-stat-card__icon">
                    <i class="ph ph-calendar-blank"></i>
                </div>
                <div class="dedication-stat-card__info">
                    <span class="dedication-stat-card__value"><?php echo esc_html(count($years_list)); ?></span>
                    <span class="dedication-stat-card__label"><?php esc_html_e('Tahun Pelaksanaan', 'webjti'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <div class="dedication-toolbar">
        <div class="dedication-toolbar__years-dropdown">
            <div class="dedication-dropdown" id="yearFilterDropdown">
                <button type="button" class="dedication-dropdown__toggle" aria-haspopup="listbox" aria-expanded="false" id="dropdownToggleBtn">
                    <span class="dedication-dropdown__selected-value">
                        <i class="ph ph-squares-four"></i>
                        <span><?php esc_html_e('Semua Tahun', 'webjti'); ?></span>
                    </span>
                    <i class="ph ph-caret-down dedication-dropdown__caret"></i>
                </button>
                <ul class="dedication-dropdown__menu" role="listbox" aria-labelledby="dropdownToggleBtn">
                    <li class="dedication-dropdown__item active" data-value="all" role="option" aria-selected="true">
                        <i class="ph ph-squares-four"></i>
                        <span><?php esc_html_e('Semua Tahun', 'webjti'); ?></span>
                    </li>
                    <?php foreach ($years_list as $yr) : ?>
                        <li class="dedication-dropdown__item" data-value="<?php echo esc_attr($yr); ?>" role="option" aria-selected="false">
                            <i class="ph ph-calendar"></i>
                            <span><?php echo esc_html($yr); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="dedication-toolbar__search">
            <i class="ph ph-magnifying-glass"></i>
            <input type="text" id="dedicationSearchInput" placeholder="<?php esc_attr_e('Cari judul, ketua, anggota, atau skema...', 'webjti'); ?>" />
        </div>
    </div>

    <!-- Year Groups Container -->
    <div class="dedication-years-container">
        <?php foreach ($dedications_by_year as $year => $projects) : ?>
            <div class="dedication-year-group" data-year-group="<?php echo esc_attr($year); ?>">
                <div class="dedication-year-group__header">
                    <div class="dedication-year-group__badge">
                        <i class="ph ph-calendar-check"></i>
                        <span>Tahun <?php echo esc_html($year); ?></span>
                    </div>
                    <span class="dedication-year-group__count">
                        <?php printf(esc_html__('%d Kegiatan Pengabdian', 'webjti'), count($projects)); ?>
                    </span>
                </div>

                <div class="dedication-cards-grid">
                    <?php foreach ($projects as $proj_index => $proj) : ?>
                        <div class="dedication-card"
                             data-year="<?php echo esc_attr($year); ?>"
                             data-card-index="<?php echo esc_attr($proj_index); ?>"
                             data-search-text="<?php echo esc_attr(strtolower($proj['title'] . ' ' . $proj['leader'] . ' ' . implode(' ', $proj['members']) . ' ' . $proj['study_program'] . ' ' . $proj['scheme'])); ?>">

                            <!-- Card Preview / Header (clickable toggle) -->
                            <div class="dedication-card__header" role="button" tabindex="0" aria-expanded="false">
                                <div class="dedication-card__tags">
                                    <span class="dedication-card__scheme-tag">
                                        <i class="ph ph-certificate"></i>
                                        <?php echo esc_html($proj['scheme']); ?>
                                    </span>
                                    <span class="dedication-card__prodi-tag">
                                        <i class="ph ph-graduation-cap"></i>
                                        <?php echo esc_html($proj['study_program']); ?>
                                    </span>
                                </div>
                                <h3 class="dedication-card__title">
                                    <?php echo esc_html($proj['title']); ?>
                                </h3>
                                <div class="dedication-card__summary">
                                    <div class="dedication-card__leader-info">
                                        <i class="ph ph-user-circle-gear"></i>
                                        <span><strong>Ketua:</strong> <?php echo esc_html($proj['leader']); ?></span>
                                    </div>
                                    <div class="dedication-card__members-count">
                                        <i class="ph ph-users"></i>
                                        <span><?php echo esc_html(count($proj['members'])); ?> Anggota Tim</span>
                                    </div>
                                </div>
                                <div class="dedication-card__hover-hint">
                                    <i class="ph ph-caret-down dedication-card__caret"></i>
                                    <span class="dedication-card__hint-text">Lihat Detail</span>
                                </div>
                            </div>

                            <!-- Detail Table (Revealed on Click/Toggle) -->
                            <div class="dedication-card__detail-wrapper" aria-hidden="true">
                                <div class="dedication-detail-table-wrap">
                                    <table class="dedication-detail-table">
                                        <thead>
                                            <tr>
                                                <th><i class="ph ph-user-gear"></i> Nama Ketua</th>
                                                <th><i class="ph ph-users"></i> Nama Anggota</th>
                                                <th><i class="ph ph-graduation-cap"></i> Program Studi</th>
                                                <th><i class="ph ph-seal-check"></i> Skema</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="ddt-leader">
                                                        <div class="leader-avatar"><i class="ph ph-user"></i></div>
                                                        <span><?php echo esc_html($proj['leader']); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="ddt-members">
                                                        <?php foreach ($proj['members'] as $m_name) : ?>
                                                            <li><i class="ph ph-user-check"></i><?php echo esc_html($m_name); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </td>
                                                <td><span class="badge-prodi"><?php echo esc_html($proj['study_program']); ?></span></td>
                                                <td><span class="badge-scheme"><?php echo esc_html($proj['scheme']); ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination per Year Group -->
                <div class="dedication-pagination" data-year-pagination="<?php echo esc_attr($year); ?>">
                    <div class="dedication-pagination__info">
                        <span class="dedication-pagination__text"></span>
                    </div>
                    <div class="dedication-pagination__controls">
                        <button type="button" class="dedication-pagination__btn dedication-pagination__prev" aria-label="Halaman sebelumnya">
                            <i class="ph ph-caret-left"></i>
                        </button>
                        <div class="dedication-pagination__pages"></div>
                        <button type="button" class="dedication-pagination__btn dedication-pagination__next" aria-label="Halaman berikutnya">
                            <i class="ph ph-caret-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty Search State -->
    <div id="dedicationEmptyState" class="dedication-empty-state" style="display: none;">
        <i class="ph ph-magnifying-glass"></i>
        <h3>Tidak ada data pengabdian ditemukan</h3>
        <p>Coba kata kunci pencarian lain atau pilih filter tahun berbeda.</p>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const CARDS_PER_PAGE = 5;
    const dropdown = document.getElementById('yearFilterDropdown');
    const dropdownToggle = document.getElementById('dropdownToggleBtn');
    const dropdownItems = dropdown.querySelectorAll('.dedication-dropdown__item');
    const searchInput = document.getElementById('dedicationSearchInput');
    const yearGroups = document.querySelectorAll('.dedication-year-group');
    const emptyState = document.getElementById('dedicationEmptyState');

    // State per year group
    const groupState = {};

    // ===========================
    // CARD TOGGLE (Click-based)
    // ===========================
    document.querySelectorAll('.dedication-card__header').forEach(function(header) {
        function toggleCard() {
            const card = header.closest('.dedication-card');
            const wrapper = card.querySelector('.dedication-card__detail-wrapper');
            const isOpen = card.classList.contains('is-open');

            // Close all other open cards in the same grid
            const grid = card.closest('.dedication-cards-grid');
            if (grid) {
                grid.querySelectorAll('.dedication-card.is-open').forEach(function(openCard) {
                    if (openCard !== card) {
                        closeCard(openCard);
                    }
                });
            }

            if (isOpen) {
                closeCard(card);
            } else {
                openCard(card);
            }
        }

        header.addEventListener('click', toggleCard);
        header.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleCard();
            }
        });
    });

    function openCard(card) {
        const wrapper = card.querySelector('.dedication-card__detail-wrapper');
        const hintText = card.querySelector('.dedication-card__hint-text');
        const caret = card.querySelector('.dedication-card__caret');
        card.classList.add('is-open');
        card.querySelector('.dedication-card__header').setAttribute('aria-expanded', 'true');
        wrapper.setAttribute('aria-hidden', 'false');
        if (hintText) hintText.textContent = 'Tutup Detail';
    }

    function closeCard(card) {
        const wrapper = card.querySelector('.dedication-card__detail-wrapper');
        const hintText = card.querySelector('.dedication-card__hint-text');
        const caret = card.querySelector('.dedication-card__caret');
        card.classList.remove('is-open');
        card.querySelector('.dedication-card__header').setAttribute('aria-expanded', 'false');
        wrapper.setAttribute('aria-hidden', 'true');
        if (hintText) hintText.textContent = 'Lihat Detail';
    }

    // ===========================
    // PAGINATION
    // ===========================
    function initGroupState(group) {
        const year = group.getAttribute('data-year-group');
        if (!groupState[year]) {
            groupState[year] = { currentPage: 1 };
        }
    }

    function getVisibleCards(group) {
        return Array.from(group.querySelectorAll('.dedication-card')).filter(function(card) {
            return card.getAttribute('data-filtered') !== 'hidden';
        });
    }

    function renderPagination(group) {
        const year = group.getAttribute('data-year-group');
        initGroupState(group);

        const visibleCards = getVisibleCards(group);
        const totalCards = visibleCards.length;
        const totalPages = Math.ceil(totalCards / CARDS_PER_PAGE);
        const currentPage = Math.min(groupState[year].currentPage, totalPages || 1);
        groupState[year].currentPage = currentPage;

        const paginationEl = group.querySelector('.dedication-pagination');
        const infoText = group.querySelector('.dedication-pagination__text');
        const pagesEl = group.querySelector('.dedication-pagination__pages');
        const prevBtn = group.querySelector('.dedication-pagination__prev');
        const nextBtn = group.querySelector('.dedication-pagination__next');

        // Show/hide all cards based on page
        const allCards = group.querySelectorAll('.dedication-card');
        allCards.forEach(function(card) {
            card.style.display = 'none';
        });

        const startIndex = (currentPage - 1) * CARDS_PER_PAGE;
        const endIndex = startIndex + CARDS_PER_PAGE;
        visibleCards.slice(startIndex, endIndex).forEach(function(card) {
            card.style.display = 'block';
            // Close any open cards when page changes
            if (card.classList.contains('is-open')) {
                closeCard(card);
            }
        });

        // Update info text
        const startNum = totalCards === 0 ? 0 : startIndex + 1;
        const endNum = Math.min(endIndex, totalCards);
        if (infoText) {
            infoText.textContent = totalCards > 0
                ? startNum + '–' + endNum + ' dari ' + totalCards + ' kegiatan'
                : '0 kegiatan';
        }

        // Render page buttons
        if (pagesEl) {
            pagesEl.innerHTML = '';
            for (var p = 1; p <= totalPages; p++) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dedication-pagination__page' + (p === currentPage ? ' is-active' : '');
                btn.textContent = p;
                btn.setAttribute('data-page', p);
                (function(page) {
                    btn.addEventListener('click', function() {
                        groupState[year].currentPage = page;
                        renderPagination(group);
                        group.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                })(p);
                pagesEl.appendChild(btn);
            }
        }

        // Prev / Next buttons
        if (prevBtn) {
            prevBtn.disabled = currentPage <= 1;
            prevBtn.onclick = function() {
                if (groupState[year].currentPage > 1) {
                    groupState[year].currentPage--;
                    renderPagination(group);
                    group.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };
        }
        if (nextBtn) {
            nextBtn.disabled = currentPage >= totalPages;
            nextBtn.onclick = function() {
                if (groupState[year].currentPage < totalPages) {
                    groupState[year].currentPage++;
                    renderPagination(group);
                    group.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };
        }

        // Hide pagination bar if only 1 page
        if (paginationEl) {
            paginationEl.style.display = totalPages <= 1 ? 'none' : 'flex';
        }
    }

    // ===========================
    // FILTER & SEARCH
    // ===========================
    function filterDedication() {
        const activeItem = document.querySelector('.dedication-dropdown__item.active');
        const selectedYear = activeItem ? activeItem.getAttribute('data-value') : 'all';
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

        let totalVisible = 0;

        yearGroups.forEach(function(group) {
            const groupYear = group.getAttribute('data-year-group');

            if (selectedYear !== 'all' && selectedYear !== groupYear) {
                group.style.display = 'none';
                return;
            }

            const cards = group.querySelectorAll('.dedication-card');
            let groupVisible = 0;

            cards.forEach(function(card) {
                const cardText = card.getAttribute('data-search-text') || '';
                const matchesSearch = !searchTerm || cardText.includes(searchTerm);

                if (matchesSearch) {
                    card.removeAttribute('data-filtered');
                    groupVisible++;
                    totalVisible++;
                } else {
                    card.setAttribute('data-filtered', 'hidden');
                }
            });

            // Reset to page 1 on filter change
            const year = group.getAttribute('data-year-group');
            if (groupState[year]) groupState[year].currentPage = 1;

            if (groupVisible > 0) {
                group.style.display = 'block';
                renderPagination(group);
            } else {
                group.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = totalVisible === 0 ? 'block' : 'none';
        }
    }

    // ===========================
    // INIT
    // ===========================
    // Initialize all year groups with pagination
    yearGroups.forEach(function(group) {
        initGroupState(group);
        renderPagination(group);
    });

    // Toggle dropdown
    dropdownToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = dropdown.classList.contains('is-open');
        if (isOpen) {
            dropdown.classList.remove('is-open');
            dropdownToggle.setAttribute('aria-expanded', 'false');
        } else {
            dropdown.classList.add('is-open');
            dropdownToggle.setAttribute('aria-expanded', 'true');
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('is-open');
            dropdownToggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Dropdown items selection
    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function() {
            dropdownItems.forEach(function(i) {
                i.classList.remove('active');
                i.setAttribute('aria-selected', 'false');
            });
            item.classList.add('active');
            item.setAttribute('aria-selected', 'true');

            // Update toggle button text and icon
            const selectedText = item.querySelector('span').textContent;
            const selectedIconClass = item.querySelector('i').className;
            dropdownToggle.querySelector('.dedication-dropdown__selected-value').innerHTML = `
                <i class="${selectedIconClass}"></i>
                <span>${selectedText}</span>
            `;

            dropdown.classList.remove('is-open');
            dropdownToggle.setAttribute('aria-expanded', 'false');
            filterDedication();
        });
    });

    // Search input

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', filterDedication);
    }
});
</script>
