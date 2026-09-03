<?php
/**
 * One-off data migrations.
 *
 * @package WebJTI_Theme
 */

function webjti_migrate_lecturer_meta_keys() {

  global $wpdb;

  $post_types = [
    'lecturer_education',
    'lecturer_certification',
    'lecturer_course',
    'lecturer_publication',
  ];

  $placeholders = implode(
    ', ',
    array_fill(
      0,
      count($post_types),
      '%s'
    )
  );

  $sql =
    "UPDATE {$wpdb->postmeta} pm\n" .
    "INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id\n" .
    "SET pm.meta_key = %s\n" .
    "WHERE pm.meta_key = %s\n" .
    "AND p.post_type IN ($placeholders)";

  $updated_keys =
    $wpdb->query(
      $wpdb->prepare(
        $sql,
        array_merge(
          [
            'lecturer',
            'dosen',
          ],
          $post_types
        )
      )
    );

  $updated_field_keys =
    $wpdb->query(
      $wpdb->prepare(
        $sql,
        array_merge(
          [
            '_lecturer',
            '_dosen',
          ],
          $post_types
        )
      )
    );

  return [
    'updated_keys' =>
      intval($updated_keys),
    'updated_field_keys' =>
      intval($updated_field_keys),
  ];

}

add_action('admin_init', function () {

  if (!current_user_can('manage_options')) {
    return;
  }

  if (empty($_GET['webjti_migrate_lecturer_meta'])) {
    return;
  }

  check_admin_referer('webjti_migrate_lecturer_meta');

  $result =
    webjti_migrate_lecturer_meta_keys();

  $redirect =
    remove_query_arg([
      'webjti_migrate_lecturer_meta',
      '_wpnonce',
    ]);

  $redirect =
    add_query_arg(
      [
        'webjti_migrate_lecturer_meta_done' => 1,
        'updated_keys' => $result['updated_keys'],
        'updated_field_keys' => $result['updated_field_keys'],
      ],
      $redirect
    );

  wp_safe_redirect($redirect);
  exit;

});

add_action('admin_notices', function () {

  if (!current_user_can('manage_options')) {
    return;
  }

  if (empty($_GET['webjti_migrate_lecturer_meta_done'])) {
    return;
  }

  $updated_keys =
    intval($_GET['updated_keys'] ?? 0);

  $updated_field_keys =
    intval($_GET['updated_field_keys'] ?? 0);

  echo '<div class="notice notice-success is-dismissible">';
  echo '<p>';
  echo 'Lecturer meta migration complete. ';
  echo 'Updated meta keys: ' . esc_html($updated_keys) . '. ';
  echo 'Updated field keys: ' . esc_html($updated_field_keys) . '.';
  echo '</p>';
  echo '</div>';

});
