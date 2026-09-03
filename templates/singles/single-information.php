<?php
/**
 * Single Template: Information
 * Post Type: information
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

// Check if this is a default fallback
$is_default = isset($_GET['default_info']) || !have_posts();
$default_id = isset($_GET['default_info']) ? sanitize_text_field($_GET['default_info']) : '';

// Retrieve default post data if fallback or database is empty
$default_data = [];
if ($is_default) {
    if (empty($default_id)) {
        $default_id = 'default-1';
    }
    $default_data = webjti_get_fallback_information_data($default_id);
}

// Ensure normal loop still works if not default
if (!$is_default) {
    the_post();
    $content = get_the_content();
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    if ($reading_time < 1) $reading_time = 1;

    $category_value = function_exists('get_field') ? get_field('category') : '';
    $category_map = [
        'news'         => 'Berita',
        'announcement' => 'Pengumuman',
        'event'        => 'Agenda',
    ];
    $category_label = $category_map[$category_value] ?? 'Berita';
    
    $title = get_the_title();
    $date = get_the_date('d M Y');
    $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png';
    $post_url = get_permalink();
} else {
    $title = $default_data['title'];
    $category_label = $default_data['category'];
    $image_url = $default_data['image'];
    $date = $default_data['date'];
    $reading_time = $default_data['reading_time'];
    $content = $default_data['content'];
    $post_url = home_url('/?default_info=' . $default_id);
}

// ==================================================
// QUERY RELATED POSTS (FILTERED BY TAG/CATEGORY)
// ==================================================
$query_category = '';
if ($category_label === 'Berita') {
    $query_category = 'berita';
} elseif ($category_label === 'Pengumuman') {
    $query_category = 'pengumuman';
} elseif ($category_label === 'Agenda') {
    $query_category = 'agenda';
} else {
    $query_category = 'berita';
}

$related_data = webjti_get_filtered_information($query_category, '', 1, 10);
$related_posts = [];
$current_id = $is_default ? $default_id : get_the_ID();

if (!empty($related_data['posts'])) {
    foreach ($related_data['posts'] as $post_item) {
        $post_item_id = $post_item['id'] ?? '';
        if ($post_item_id != $current_id) {
            $related_posts[] = $post_item;
        }
        if (count($related_posts) >= 3) {
            break;
        }
    }
}
?>

<main id="primary" class="site-main single-information-page-main">
    
    <!-- Section 1: Content Area & Floating Social Panel -->
    <div class="container container--wide single-info__container">
        
        <?php
        // 1. Breadcrumb & Featured Image Header
        get_template_part(
            'template-parts/single/information/information-header',
            null,
            [
                'title'          => $title,
                'image_url'      => $image_url,
                'category_label' => $category_label,
            ]
        );

        // 2. Main Article Body & Social Sharing Button Panel
        get_template_part(
            'template-parts/single/information/information-body',
            null,
            [
                'title'        => $title,
                'date'         => $date,
                'reading_time' => $reading_time,
                'is_default'   => $is_default,
                'content'      => $content,
                'post_url'     => $post_url,
            ]
        );
        ?>
        
    </div><!-- .container -->

    <!-- Section 2: Related Posts Block (BG Color #F1F1F0) -->
    <?php
    get_template_part(
        'template-parts/single/information/related-posts',
        null,
        [
            'category_label' => $category_label,
            'related_posts'  => $related_posts,
            'query_category' => $query_category,
        ]
    );
    ?>

</main><!-- #primary -->

<?php
get_footer();
