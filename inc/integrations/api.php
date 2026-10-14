<?php
/**
 * REST API Helpers
 *
 * @package WebJTI_Theme
 */

/* =========================================================
   REGISTER API ROUTES
========================================================= */

add_action('rest_api_init', function () {

    register_rest_route(
        'webjti/v1',
        '/lecturers',
        [
            'methods'  => 'GET',
            'callback' => 'webjti_api_lecturers',
            'permission_callback' => '__return_true',
        ]
    );

    register_rest_route(
        'webjti/v1',
        '/achievements',
        [
            'methods'  => 'GET',
            'callback' => 'webjti_api_achievements',
            'permission_callback' => '__return_true',
        ]
    );

});

/* =========================================================
   LECTURER API
========================================================= */

function webjti_api_lecturers()
{
    $query = new WP_Query([
        'post_type'      => 'lecturer',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    $data = [];

    while ($query->have_posts()) {

        $query->the_post();

        $data[] = [
            'id'    => get_the_ID(),
            'name'  => get_the_title(),
            'link'  => get_permalink(),
            'image' => get_the_post_thumbnail_url(
                get_the_ID(),
                'medium'
            ),
        ];
    }

    wp_reset_postdata();

    return rest_ensure_response($data);
}

/* =========================================================
   ACHIEVEMENT API
========================================================= */

function webjti_api_achievements()
{
    $query = new WP_Query([
        'post_type'      => 'achievement',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
    ]);

    $data = [];

    while ($query->have_posts()) {

        $query->the_post();

        $data[] = [
            'id'    => get_the_ID(),
            'title' => get_the_title(),
            'link'  => get_permalink(),
        ];
    }

    wp_reset_postdata();

    return rest_ensure_response($data);
}