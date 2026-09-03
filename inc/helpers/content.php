<?php

/* ========================================
   GET VIDEO SECTION DATA
======================================== */

function webjti_get_video_section_data() {

  $video_url = get_theme_mod('jti_video_url_text', 'https://youtu.be/aJYMCM1aEcA');
  if (empty(trim($video_url))) {
    $video_url = 'https://youtu.be/aJYMCM1aEcA';
  }

  $channel_url = get_theme_mod('jti_video_button_url', 'https://www.youtube.com/@jtipolinema367/featured');
  if (empty(trim($channel_url))) {
    $channel_url = 'https://www.youtube.com/@jtipolinema367/featured';
  }

  $video_id = 'aJYMCM1aEcA';
  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
  if (isset($match[1])) {
    $video_id = $match[1];
  }

  // Auto-fallback protection if the saved URL resolved to the deleted/private/old video
  if ($video_id === 'hWqAqix5apI' || $video_id === '7lLigiVgJsE' || $video_id === '3zPFX4DuYt4' || $video_id === 'gT829Qn-8Yk') {
    $video_id = 'aJYMCM1aEcA';
  }

  return [

    'video_id' =>
      $video_id,

    'embed_url' =>
      'https://www.youtube.com/embed/'
      . $video_id
      . '?rel=0&modestbranding=1',

    'channel_url' =>
      $channel_url,

  ];

}

/* ========================================
   GET CAMPUS DATA
======================================== */

function webjti_get_campuses() {
  $campuses = [];
  
  $defaults = [
    [
      'title'   => 'JTI Kampus Utama',
      'address' => 'Jl. Soekarno Hatta No. 9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141',
      'email'   => 'humas@jti.polinema.ac.id',
    ],
    [
      'title'   => 'JTI Kampus Lumajang',
      'address' => 'Jl. Raya Klakah No. 123, Kec. Klakah, Kabupaten Lumajang, Jawa Timur 67356',
      'email'   => 'humas.lmj@jti.polinema.ac.id',
    ],
    [
      'title'   => 'JTI Kampus Kediri',
      'address' => 'Jl. Veteran No. 45, Mojoroto, Kec. Mojoroto, Kota Kediri, Jawa Timur 64112',
      'email'   => 'humas.kdr@jti.polinema.ac.id',
    ],
    [
      'title'   => 'JTI Kampus Pamekasan',
      'address' => 'Jl. Panglegur No. 8, Panglegur, Kec. Tlanakan, Kabupaten Pamekasan, Jawa Timur 69371',
      'email'   => 'humas.pmk@jti.polinema.ac.id',
    ],
  ];

  for ($i = 1; $i <= 4; $i++) {
    $default = $defaults[$i - 1];
    $title = get_theme_mod("jti_campus_{$i}_title", $default['title']);
    $address = get_theme_mod("jti_campus_{$i}_address", $default['address']);
    $email = get_theme_mod("jti_campus_{$i}_email", $default['email']);
    
    if (!empty(trim($title)) || !empty(trim($address))) {
      $campuses[] = [
        'title'   => empty(trim($title)) ? $default['title'] : $title,
        'address' => empty(trim($address)) ? $default['address'] : $address,
        'email'   => empty(trim($email)) ? $default['email'] : $email,
      ];
    }
  }

  return $campuses;
}

/* ========================================
   GET HISTORY WELCOME SECTION
======================================== */

function webjti_get_history_welcome_data() {
  $title = get_theme_mod('jti_history_welcome_title', 'Sambutan Ketua Jurusan Teknologi Informasi Polinema');
  if (empty(trim($title))) {
    $title = 'Sambutan Ketua Jurusan Teknologi Informasi Polinema';
  }

  $video_url = get_theme_mod('jti_history_welcome_video_url', 'https://youtu.be/aJYMCM1aEcA');
  if (empty(trim($video_url))) {
    $video_url = 'https://youtu.be/aJYMCM1aEcA';
  }

  $video_id = 'aJYMCM1aEcA';
  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
  if (isset($match[1])) {
    $video_id = $match[1];
  }

  if ($video_id === '3zPFX4DuYt4' || $video_id === 'gT829Qn-8Yk' || $video_id === 'hWqAqix5apI' || $video_id === '7lLigiVgJsE') {
    $video_id = 'aJYMCM1aEcA';
  }

  $name = get_theme_mod('jti_history_welcome_name', 'Mungki Astiningrum, ST., M.Kom.');
  if (empty(trim($name))) {
    $name = 'Mungki Astiningrum, ST., M.Kom.';
  }

  $image = get_theme_mod('jti_history_welcome_image', '');
  if (empty(trim($image))) {
    $image = get_template_directory_uri() . '/assets/images/placeholders/bu mungki.png';
  }

  $bg_image = get_theme_mod('jti_history_welcome_bg', '');

  return [
    'title'    => $title,
    'video_id' => $video_id,
    'name'     => $name,
    'image'    => $image,
    'bg_image' => $bg_image,
  ];
}

/* ========================================
   AUTO ICON GENERATOR FOR LAB CPTs
======================================== */

/**
 * Automatically get or generate a unique icon for Laboratory feature CPTs
 *
 * @param int $post_id
 * @param string $cpt
 * @return string Phosphor icon class name
 */
function webjti_get_cpt_auto_icon($post_id, $cpt = '') {
  if (!$post_id) return 'ph-desktop-tower';

  if (empty($cpt)) {
    $cpt = get_post_type($post_id);
  }

  $saved_icon = get_post_meta($post_id, 'item_icon', true);
  if (!empty($saved_icon)) {
    return $saved_icon;
  }

  $pools = [
    'lab_facility' => [
      'ph-desktop-tower', 'ph-monitor', 'ph-cpu', 'ph-hard-drives', 
      'ph-device-mobile', 'ph-robot', 'ph-printer', 'ph-circuit-board', 
      'ph-wifi-high', 'ph-laptop', 'ph-broadcast', 'ph-headset',
      'ph-wrench', 'ph-sliders', 'ph-floppy-disk', 'ph-game-controller'
    ],
    'lab_activity' => [
      'ph-kanban', 'ph-projector-screen-chart', 'ph-presentation', 'ph-lightbulb', 
      'ph-code-block', 'ph-rocket-launch', 'ph-git-branch', 'ph-handshake', 
      'ph-trophy', 'ph-terminal-window', 'ph-trend-up', 'ph-gear-six',
      'ph-users-three', 'ph-calendar-check', 'ph-briefcase', 'ph-sparkles'
    ],
    'lab_course'   => [
      'ph-book-open', 'ph-graduation-cap', 'ph-chalkboard-teacher', 'ph-student', 
      'ph-brackets-curly', 'ph-database', 'ph-browsers', 'ph-brain', 
      'ph-certificate', 'ph-notebook', 'ph-file-code', 'ph-exam',
      'ph-certificate-check', 'ph-read-cv-logo', 'ph-book-bookmark', 'ph-lecture-hall'
    ],
    'lab_focus'    => [
      'ph-target', 'ph-atom', 'ph-compass', 'ph-flask', 
      'ph-magnifying-glass', 'ph-globe-hemisphere-west', 'ph-chart-line-up', 'ph-shield-check', 
      'ph-fingerprint', 'ph-cloud-arrow-up', 'ph-crosshair', 'ph-squares-four',
      'ph-lightning', 'ph-eye', 'ph-chart-polar', 'ph-stack'
    ],
  ];

  if (!isset($pools[$cpt])) {
    return 'ph-desktop-tower';
  }

  $icons = $pools[$cpt];
  $title = get_the_title($post_id);
  $hash = abs(crc32($title . '_' . $post_id));
  $index = $hash % count($icons);

  return $icons[$index];
}

/**
 * Auto-assign item_icon meta on save for Laboratory feature CPTs
 */
add_action('save_post', function($post_id, $post, $update) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!$post || $post->post_status === 'auto-draft' || $post->post_type === 'revision') return;

  $target_cpts = ['lab_facility', 'lab_activity', 'lab_course', 'lab_focus'];
  if (in_array($post->post_type, $target_cpts, true)) {
    $auto_icon = webjti_get_cpt_auto_icon($post_id, $post->post_type);
    update_post_meta($post_id, 'item_icon', $auto_icon);
  }

  if ($post->post_type === 'aturan_akademik') {
    if (function_exists('webjti_get_aturan_akademik_auto_icon')) {
      $current_icon = function_exists('get_field') ? get_field('aa_icon', $post_id) : get_post_meta($post_id, 'aa_icon', true);
      $auto_icon    = webjti_get_aturan_akademik_auto_icon($post_id);

      if (empty($current_icon) || $current_icon === 'book-open') {
        if (function_exists('update_field')) {
          update_field('aa_icon', $auto_icon, $post_id);
        }
        update_post_meta($post_id, 'aa_icon', $auto_icon);
      } else {
        $clean_icon = trim(str_replace(['ph-', 'ph ', 'ph-fill'], '', $current_icon));
        if ($clean_icon !== $current_icon) {
          if (function_exists('update_field')) {
            update_field('aa_icon', $clean_icon, $post_id);
          }
          update_post_meta($post_id, 'aa_icon', $clean_icon);
        }
      }
    }
  }
}, 20, 3);