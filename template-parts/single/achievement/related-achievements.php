<?php
/**
 * Single Achievement Related Block Component
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;
$is_default = $args['is_default'] ?? false;
$related = $args['related'] ?? [];

$related_cards = [];

if ($is_default) {
    $related_cards = $related;
} else {
    // Real CPT query for other achievements
    $current_id = get_the_ID();
    $query = new WP_Query([
        'post_type' => 'achievement',
        'posts_per_page' => 3,
        'post__not_in' => [$current_id],
        'post_status' => 'publish'
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $title = get_field('judul_kompetisi') ?: get_the_title();
            $excerpt = wp_trim_words(get_field('deskripsi') ?: get_the_excerpt(), 12);
            $date = get_field('tanggal') ?: get_the_date();
            $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png';
            $juara = get_field('rank') ?: get_field('juara');
            $tingkat = get_field('level') ?: get_field('tingkat');

            $related_cards[] = [
                'id' => get_the_ID(),
                'url' => get_permalink(),
                'title' => $title,
                'excerpt' => $excerpt,
                'date' => $date,
                'image' => $image_url,
                'juara' => $juara,
                'tingkat' => $tingkat
            ];
        }
        wp_reset_postdata();
    }
}
?>

<!-- Section 2: Related Achievements Block (BG Color #F1F1F0) -->
<section class="single-achievement__related-section">
    <div class="container container--wide">
        
        <div class="single-achievement__related-header">
            <div class="single-achievement__related-title-area">
                <h2 class="single-achievement__related-title">Prestasi Luar Biasa Lainnya</h2>
            </div>
        </div>
        
        <!-- Cards Grid: exactly 3 cards of identical tag -->
        <div class="single-achievement__related-grid">
            <?php 
            if (!empty($related_cards)) {
                foreach ($related_cards as $card_item) {
                    get_template_part(
                        'template-parts/cards/achievement-card',
                        null,
                        [
                            'achievement' => $card_item,
                        ]
                    );
                }
            } else {
                ?>
                <div class="single-achievement__related-empty">
                    Tidak ada prestasi terkait lainnya saat ini.
                </div>
                <?php
            }
            ?>
        </div>
        
        <!-- Center Aligned Lihat Selengkapnya Button -->
        <div class="single-achievement__related-cta">
            <a href="<?php echo esc_url(home_url('/student-affairs/achievement')); ?>" class="btn btn--outline">
                <span>Lihat Selengkapnya</span>
                <i class="ph ph-arrow-up-right"></i>
            </a>
        </div>
        
    </div>
</section>