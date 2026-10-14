<?php
/**
 * Shared Layout: Pengembangan Karir
 * WebJTI Theme
 *
 * @package WebJTI_Theme
 */

// Read active filters from URL query parameters (for robust SEO initial load support)
$active_type = isset($_GET['career_type']) ? sanitize_text_field($_GET['career_type']) : 'all';
$search_query = isset($_GET['career_search']) ? sanitize_text_field($_GET['career_search']) : '';
$paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

$posts_per_page = 9;
$filtered_data = webjti_get_filtered_career($active_type, $search_query, $paged, $posts_per_page);

// Mendapatkan semua kategori karir untuk filter
$categories = get_terms([
    'taxonomy' => 'career_category',
    'hide_empty' => false,
]);
?>

<!-- ========================================
   TOP FILTER & SEARCH BAR
======================================== -->
<div class="information-filter-bar career-filter-bar">
    
    <!-- Left Category Segmented Control -->
    <div class="filter-list segmented career-filter-list">
        <button class="filter-btn <?php echo $active_type === 'all' ? 'active' : ''; ?>" data-target="all" onclick="window.location.href='?career_type=all'">
            <span class="filter-btn-text">Semua</span>
        </button>
        <?php if (!is_wp_error($categories) && !empty($categories)) : ?>
            <?php foreach ($categories as $cat) : ?>
                <button class="filter-btn <?php echo $active_type === $cat->slug ? 'active' : ''; ?>" data-target="<?php echo esc_attr($cat->slug); ?>" onclick="window.location.href='?career_type=<?php echo esc_attr($cat->slug); ?>'">
                    <span class="filter-btn-text"><?php echo esc_html($cat->name); ?></span>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Right Search Bar -->
    <form method="GET" action="" class="search-toolbar career-search-toolbar">
        <?php if ($active_type !== 'all') : ?>
            <input type="hidden" name="career_type" value="<?php echo esc_attr($active_type); ?>">
        <?php endif; ?>
        <i class="ph ph-magnifying-glass"></i>
        <input 
            type="text" 
            name="career_search"
            class="search-input career-search-input" 
            placeholder="Cari program, lowongan, dll.." 
            value="<?php echo esc_attr($search_query); ?>"
        >
        <button type="submit" style="display: none;"></button>
    </form>

</div>

<!-- Interactive Results Wrapping Container -->
<div class="career-interactive-container" style="margin-top: 40px;">

    <!-- Grid Cards -->
    <div class="information-filtered-grid career-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 32px;">
        <?php if (!empty($filtered_data['posts'])) : ?>
            <?php foreach ($filtered_data['posts'] as $item) : ?>
                <?php
                get_template_part(
                    'template-parts/cards/career-card',
                    null,
                    [
                        'info' => $item,
                    ]
                );
                ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="information-no-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 24px; width: 100%;">
                <i class="ph ph-suitcase" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;"></i>
                <h3 style="color: var(--neutral-09); margin-bottom: 8px; font-weight: 500; font-size: 20px;">Tidak Ada Program</h3>
                <p style="color: var(--neutral-06); font-size: 16px;">Maaf, belum ada informasi program pengembangan karir yang sesuai dengan kriteria filter atau pencarian Anda.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="information-pagination-box career-pagination" style="margin-top: 40px;">
        <?php if ($filtered_data['max_pages'] > 1) : ?>
            <div class="pagination-container">
                <?php
                echo paginate_links([
                    'total'     => $filtered_data['max_pages'],
                    'current'   => $paged,
                    'prev_next' => true,
                    'prev_text' => '<i class="ph ph-arrow-left"></i> Sebelumnya',
                    'next_text' => 'Selanjutnya <i class="ph ph-arrow-right"></i>',
                    'type'      => 'plain',
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>

</div>
