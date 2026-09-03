<?php
/**
 * AJAX Handlers
 *
 * @package WebJTI_Theme
 */

/* =========================================================
   INFORMATION FILTER AJAX
========================================================= */

add_action(
    'wp_ajax_webjti_filter_information',
    'webjti_filter_information'
);

add_action(
    'wp_ajax_nopriv_webjti_filter_information',
    'webjti_filter_information'
);

function webjti_filter_information()
{
    $type = sanitize_text_field(
        $_POST['type'] ?? 'berita'
    );

    $search = sanitize_text_field(
        $_POST['search'] ?? ''
    );

    $paged = intval(
        $_POST['paged'] ?? 1
    );

    $query = new WP_Query([
        'post_type'      => $type === 'semua'
            ? ['berita', 'pengumuman', 'agenda']
            : $type,
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'paged'          => $paged,
        's'              => $search,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    ob_start();

    if ($query->have_posts()) :

        while ($query->have_posts()) :
            $query->the_post();

            get_template_part(
                'template-parts/components/cards/information-card'
            );

        endwhile;

    else :

        echo '
        <div class="empty-state">
            Tidak ada informasi ditemukan.
        </div>';

    endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
        'max_pages' => $query->max_num_pages,
    ]);
}

/* =========================================================
   GALLERY FILTER AJAX
========================================================= */

add_action('wp_ajax_webjti_filter_gallery', 'webjti_filter_gallery');
add_action('wp_ajax_nopriv_webjti_filter_gallery', 'webjti_filter_gallery');

function webjti_filter_gallery() {
    $search = sanitize_text_field($_POST['search'] ?? '');
    $paged = intval($_POST['paged'] ?? 1);
    $items_per_page = 9;

    $args = [
        'post_type'      => 'ormawa_gallery',
        'posts_per_page' => $items_per_page,
        'paged'          => $paged,
    ];

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $gallery_query = new WP_Query($args);
    $total_pages = $gallery_query->max_num_pages;

    ob_start();

    echo '<div class="gallery-grid-wrapper">';
    if (!$gallery_query->have_posts()) {
        echo '<p class="gallery-empty-state">Tidak ada hasil yang ditemukan untuk pencarian "' . esc_html($search) . '"</p>';
    } else {
        while ($gallery_query->have_posts()) {
            $gallery_query->the_post();
            $title = get_the_title();
            $desc = get_field('description');
            $photo = get_field('gallery_photo');
            $image_url = $photo ? esc_url($photo['url']) : 'https://via.placeholder.com/600x400/1a1a1a/ffffff?text=No+Image';
            
            $associated_ormawa_id = get_field('associated_ormawa');
            $subtitle = $associated_ormawa_id ? get_the_title($associated_ormawa_id) . ' / ' . get_the_date('Y') : 'Kegiatan / ' . get_the_date('Y');
            
            $related = [];
            for ($i = 1; $i <= 4; $i++) {
                $rel_url = get_field('related_photo_' . $i);
                if ($rel_url) {
                    $related[] = esc_url($rel_url);
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
                
                <div class="gallery-card__image-wrapper">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="gallery-card__image" loading="lazy">
                    <div class="gallery-card__overlay"></div>
                </div>

                <div class="gallery-card__content">
                    <h3 class="gallery-card__title"><?php echo esc_html($title); ?></h3>
                    <p class="gallery-card__subtitle"><?php echo esc_html($subtitle); ?></p>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    }
    echo '</div>';

    if ($total_pages > 1) {
        echo '<div class="gallery-pagination">';
        if ($paged > 1) {
            echo '<a href="#" data-page="' . ($paged - 1) . '" class="gallery-page-link prev">&laquo; Prev</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = $i === $paged ? 'active' : '';
            echo '<a href="#" data-page="' . $i . '" class="gallery-page-link ' . $active . '">' . $i . '</a>';
        }
        if ($paged < $total_pages) {
            echo '<a href="#" data-page="' . ($paged + 1) . '" class="gallery-page-link next">Next &raquo;</a>';
        }
        echo '</div>';
    }

    wp_send_json_success([
        'html' => ob_get_clean()
    ]);
}