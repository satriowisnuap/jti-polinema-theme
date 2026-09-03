<?php
require_once dirname(__FILE__) . '/../../../wp-load.php';

$query = new WP_Query([
    'post_type' => 'information',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

echo "Found " . $query->found_posts . " posts.\n";

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $cat = get_post_meta(get_the_ID(), 'category', true);
        echo "ID: " . get_the_ID() . " | Title: " . get_the_title() . " | Category meta: " . $cat . "\n";
    }
    wp_reset_postdata();
}
