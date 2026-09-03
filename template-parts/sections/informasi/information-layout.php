<?php
/**
 * Shared Layout: Information Page & Archive Layout
 * WebJTI Theme (Figma High-Fidelity Node 949-23475)
 *
 * @package WebJTI_Theme
 */

// Read active filters from URL query parameters (for robust SEO initial load support)
$active_type = isset($_GET['info_type']) ? sanitize_text_field($_GET['info_type']) : 'all';
$search_query = isset($_GET['info_search']) ? sanitize_text_field($_GET['info_search']) : '';
$paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

$posts_per_page = 6;
$filtered_data = webjti_get_filtered_information($active_type, $search_query, $paged, $posts_per_page);
?>

<!-- ========================================
   TOP FILTER & SEARCH BAR (Figma High-Fidelity)
======================================== -->
<div class="information-filter-bar" data-node-id="949:24131">
    
    <!-- Left Category Segmented Control -->
    <div class="filter-list segmented" data-node-id="1727:32096">
        <button class="filter-btn <?php echo $active_type === 'all' ? 'active' : ''; ?>" data-target="all" data-node-id="1727:32097">
            <span class="filter-btn-text">Semua</span>
        </button>
        <button class="filter-btn <?php echo $active_type === 'berita' ? 'active' : ''; ?>" data-target="berita" data-node-id="1727:32099">
            <span class="filter-btn-text">Berita</span>
        </button>
        <button class="filter-btn <?php echo $active_type === 'pengumuman' ? 'active' : ''; ?>" data-target="pengumuman" data-node-id="1727:32101">
            <span class="filter-btn-text">Pengumuman</span>
        </button>
        <button class="filter-btn <?php echo $active_type === 'agenda' ? 'active' : ''; ?>" data-target="agenda" data-node-id="1727:32103">
            <span class="filter-btn-text">Agenda</span>
        </button>
    </div>

    <!-- Right Search Bar -->
    <div class="search-toolbar" data-node-id="949:24133">
        <i class="ph ph-magnifying-glass"></i>
        <input 
            type="text" 
            class="search-input information-search-input" 
            placeholder="Cari berita, pengumuman atau agenda.." 
            value="<?php echo esc_attr($search_query); ?>"
            data-node-id="949:24136"
        >
    </div>

</div>

<!-- Interactive Results Wrapping Container -->
<div class="information-interactive-container">

    <!-- ========================================
       MODE 1: SEMUA VIEW (Default View)
    ======================================== -->
    <div class="information-semua-wrapper" style="<?php echo ($active_type === 'all' && empty($search_query)) ? 'display: block;' : 'display: none;'; ?>">
        
        <!-- Top Spotlight Grid (Spotlight + 4 List items) -->
        <?php 
        $landing_data = webjti_get_information_posts();
        $spotlight = $landing_data['spotlight'];
        $list_posts = $landing_data['posts'];
        ?>
        
        <?php if ($spotlight || !empty($list_posts)) : ?>
            <div class="information-spotlight-grid" data-node-id="1727:32158" style="margin-bottom: 60px;">
                
                <!-- Spotlight (Left side) -->
                <div class="information-spotlight-container">
                    <?php
                    get_template_part(
                        'template-parts/cards/information-spotlight-card',
                        null,
                        [
                            'spotlight' => $spotlight,
                        ]
                    );
                    ?>
                </div>

                <!-- List Posts (Right side) -->
                <div class="information-list-container">
                    <div class="information-list-cards">
                        <?php foreach ($list_posts as $index => $item) : ?>
                            <?php
                            get_template_part(
                                'template-parts/cards/information-list-card',
                                null,
                                [
                                    'item' => $item,
                                    'show_divider' => $index < count($list_posts) - 1,
                                ]
                            );
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        <?php endif; ?>

        <!-- Bottom Category Sliders (Berita, Pengumuman, Agenda) -->
        <div class="information-category-sliders-block">
            <?php
            $categories_config = [
                [
                    'id'    => 'berita',
                    'title' => 'Berita JTI',
                    'label' => 'Berita',
                ],
                [
                    'id'    => 'pengumuman',
                    'title' => 'Pengumuman',
                    'label' => 'Pengumuman',
                ],
                [
                    'id'    => 'agenda',
                    'title' => 'Agenda JTI',
                    'label' => 'Agenda',
                ],
            ];

            foreach ($categories_config as $config) :
                $cat_posts = webjti_get_filtered_information($config['id'], '', 1, -1)['posts'];
                if (empty($cat_posts)) {
                    continue;
                }
                ?>
                <div class="information-slider-section" data-category="<?php echo esc_attr($config['id']); ?>" style="margin-bottom: 60px;">
                    
                    <!-- Slider Header -->
                    <div class="information-slider-header">
                        <div class="information-slider-title-block">
                            <h2 class="information-slider-title"><?php echo esc_html($config['title']); ?></h2>
                            <div class="information-slider-badge">
                                <span class="information-slider-badge-text">
                                    <?php echo sprintf(esc_html__('%d %s', 'webjti'), count($cat_posts), $config['label']); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Navigation Panah -->
                        <div class="slider-arrows">
                            <button class="slider-btn-prev" aria-label="Sebelumnya">
                                <i class="ph ph-arrow-left"></i>
                            </button>
                            <button class="slider-btn-next" aria-label="Selanjutnya">
                                <i class="ph ph-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Slider horizontal track container -->
                    <div class="information-slider-container">
                        <div class="information-slider-track">
                            <?php foreach ($cat_posts as $post_item) : ?>
                                <div class="information-slider-item">
                                    <?php
                                    $info = [
                                        'url'          => $post_item['permalink'] ?? $post_item['url'] ?? '',
                                        'image'        => $post_item['image'] ?? '',
                                        'title'        => $post_item['title'] ?? '',
                                        'category'     => $post_item['category'] ?? $post_item['tag'] ?? '',
                                        'date'         => $post_item['date'] ?? '',
                                        'reading_time' => $post_item['reading_time'] ?? '',
                                        'excerpt'      => $post_item['excerpt'] ?? '',
                                    ];
                                    get_template_part(
                                        'template-parts/cards/information-card',
                                        null,
                                        [
                                            'info' => $info,
                                        ]
                                    );
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- ========================================
       MODE 2: FILTERED & SEARCH VIEW (SPA Grid)
    ======================================== -->
    <div class="information-filtered-wrapper" style="<?php echo ($active_type !== 'all' || !empty($search_query)) ? 'display: block;' : 'display: none;'; ?>">
        
        <!-- Grid Cards (up to 6 cards) -->
        <div class="information-filtered-grid" id="filter-results">
            <?php if ($active_type !== 'all' || !empty($search_query)) : ?>
                <?php if (!empty($filtered_data['posts'])) : ?>
                    <?php foreach ($filtered_data['posts'] as $item) : ?>
                        <?php
                        $info = [
                            'url'          => $item['permalink'] ?? $item['url'] ?? '',
                            'image'        => $item['image'] ?? '',
                            'title'        => $item['title'] ?? '',
                            'category'     => $item['category'] ?? $item['tag'] ?? '',
                            'date'         => $item['date'] ?? '',
                            'reading_time' => $item['reading_time'] ?? '',
                            'excerpt'      => $item['excerpt'] ?? '',
                        ];
                        get_template_part(
                            'template-parts/cards/information-card',
                            null,
                            [
                                'info' => $info,
                            ]
                        );
                        ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="information-no-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 24px; width: 100%;">
                        <i class="ph ph-newspaper" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;"></i>
                        <h3 style="color: var(--neutral-09); margin-bottom: 8px; font-weight: 500; font-size: 20px;">Tidak Ada Informasi</h3>
                        <p style="color: var(--neutral-06); font-size: 16px;">Maaf, tidak ada berita, pengumuman, atau agenda yang sesuai dengan kriteria filter atau pencarian Anda.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination Links -->
        <div class="information-pagination-box" id="filter-pagination">
            <?php if (($active_type !== 'all' || !empty($search_query)) && $filtered_data['max_pages'] > 1) : ?>
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

</div>
