<?php
/**
 * Single Information Related Posts Block Component
 *
 * @package WebJTI_Theme
 */

$category_label = $args['category_label'] ?? 'Berita';
$related_posts = $args['related_posts'] ?? [];
$query_category = $args['query_category'] ?? 'berita';
?>

<!-- Section 2: Related Posts Block (BG Color #F1F1F0) -->
<section class="single-info__related-section">
    <div class="container container--wide">
        
        <div class="single-info__related-header">
            <div class="single-info__related-title-area">
                <h2 class="single-info__related-title">Informasi Terkait</h2>
                <div class="single-info__related-badge">
                    <span class="single-info__related-badge-text">
                        <?php echo esc_html($category_label); ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Cards Grid: exactly 3 cards of identical tag -->
        <div class="single-info__related-grid">
            <?php 
            if (!empty($related_posts)) {
                foreach ($related_posts as $related_item) {
                    get_template_part(
                        'template-parts/cards/information-card',
                        null,
                        [
                            'info' => $related_item,
                        ]
                    );
                }
            } else {
                ?>
                <div class="single-info__related-empty" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--neutral-06);">
                    Tidak ada informasi terkait lainnya saat ini.
                </div>
                <?php
            }
            ?>
        </div>
        
        <!-- Center Aligned Lihat Selengkapnya Button -->
        <div class="single-info__related-cta">
            <a href="<?php echo esc_url(home_url('/information?info_type=' . $query_category)); ?>" class="btn btn--outline">
                <span>Lihat Selengkapnya</span>
                <i class="ph ph-arrow-up-right"></i>
            </a>
        </div>
        
    </div>
</section>