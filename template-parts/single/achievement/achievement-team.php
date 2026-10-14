<?php
/**
 * Achievement Team Section
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;
$is_default = $args['is_default'] ?? false;
$members = $args['members'] ?? [];

if (!$achievement) {
    return;
}

$team_members = [];

if ($is_default) {
    $team_members = $members;
} else {
    // Real CPT team members query
    $post_id = get_the_ID();
    $query = new WP_Query([
        'post_type' => 'achievement_member',
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'OR',
            [
                'key' => 'prestasi',
                'value' => $post_id,
            ],
            [
                'key' => 'achievement',
                'value' => $post_id,
            ]
        ],
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $role = get_field('role');
            $role_label = '';
            if ($role === 'ketua') {
                $role_label = 'Ketua Tim';
            } elseif (strpos($role, 'anggota') !== false) {
                $role_label = 'Anggota Tim';
            } elseif ($role === 'pembimbing') {
                $role_label = 'Dosen Pembimbing';
            } else {
                $role_label = ucfirst($role ?: 'Anggota');
            }

            $photo_field = get_field('photo') ?: get_field('foto');
            $photo_url = '';
            if (is_array($photo_field) && isset($photo_field['url'])) {
                $photo_url = $photo_field['url'];
            } elseif (is_string($photo_field)) {
                $photo_url = $photo_field;
            } elseif (is_numeric($photo_field)) {
                $photo_url = wp_get_attachment_url($photo_field);
            }
            if (empty($photo_url)) {
                $photo_url = get_template_directory_uri() . '/assets/images/default-avatar.png';
            }

            $team_members[] = [
                'name' => get_field('member_name') ?: get_field('nama') ?: get_the_title(),
                'photo' => $photo_url,
                'linkedin' => get_field('linkedin_url') ?: get_field('linkedin'),
                'role' => $role ?: 'anggota',
                'role_label' => $role_label,
                'identifier' => get_field('member_id') ?: get_field('nim_nidn'),
            ];
        }
        wp_reset_postdata();
    }
}

if (empty($team_members)) {
    return;
}

ob_start();
?>

<div class="achievement-team">

  <div class="achievement-team__grid">

    <?php foreach ($team_members as $member) : ?>

      <?php
      get_template_part(
        'template-parts/cards/member-card',
        null,
        [
          'member' => $member,
        ]
      );
      ?>

    <?php endforeach; ?>

  </div>

</div>

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' => 'Anggota Tim',
    'icon' => 'ph-users-three',
    'content' => $content,
  ]
);