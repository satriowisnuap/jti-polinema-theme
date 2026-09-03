<?php
/**
 * Mission Section
 *
 * @package WebJTI_Theme
 */

$mission_content = get_field('misi_content');

if (!$mission_content) {
  $mission_content = 
    '<ol class="mission-list">' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Future-ready Education</h4>' .
    '    <p class="mission-list-desc">Melaksanakan pendidikan vokasi yang inovatif berdasarkan sistem pendidikan terapan dengan memanfaatkan kemajuan Teknologi Informasi dan Telekomunikasi, sehingga mampu menghasilkan lulusan yang siap kerja dengan daya saing global.</p>' .
    '  </li>' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Applied Research</h4>' .
    '    <p class="mission-list-desc">Menghasilkan penelitian terapan berbasis produk dan jasa bidang Informatika.</p>' .
    '  </li>' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Social Impact</h4>' .
    '    <p class="mission-list-desc">Melaksanakan pengabdian masyarakat dengan menggunakan kemajuan Teknologi Informasi untuk meningkatkan kesejahteraan.</p>' .
    '  </li>' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Tech Collaboration</h4>' .
    '    <p class="mission-list-desc">Terwujudnya kerjasama yang saling menguntungkan dengan berbagai pihak baik di dalam maupun di luar negeri pada bidang Teknologi Informasi.</p>' .
    '  </li>' .
    '</ol>';
}

$fast_pillars = [];
$letters = ['F', 'A', 'S', 'T'];
$default_titles = [
  'Future-ready<br>Education',
  'Applied<br>Research',
  'Social<br>Impact',
  'Tech<br>Collaboration'
];
$default_icons = [
  'ph-monitor-play',
  'ph-flask',
  'ph-users-three',
  'ph-handshake'
];

for ($i = 1; $i <= 4; $i++) {
  $idx = $i - 1;
  $title = '';
  $icon_val = '';
  
  if (function_exists('get_field')) {
    $title = get_field("fast_card_{$i}_title");
    $icon_val = get_field("fast_card_{$i}_icon") ?: get_field("fast_card_{$i}_ikon");
  }
  
  if (empty($title)) {
    $title = get_post_meta(get_the_ID(), "fast_card_{$i}_title", true);
  }
  if (empty($icon_val)) {
    $icon_val = get_post_meta(get_the_ID(), "fast_card_{$i}_icon", true) ?: get_post_meta(get_the_ID(), "fast_card_{$i}_ikon", true);
  }
  
  // Resolve image field (supports Array, ID, or URL)
  $icon_url = '';
  if (!empty($icon_val)) {
    if (is_array($icon_val)) {
      $icon_url = $icon_val['url'] ?? '';
    } elseif (is_numeric($icon_val)) {
      $icon_url = wp_get_attachment_url($icon_val);
    } else {
      $icon_url = $icon_val; // already a URL string
    }
  }
  
  $fast_pillars[] = [
    'letter' => $letters[$idx],
    'title'  => empty($title) ? $default_titles[$idx] : $title,
    'icon'   => $icon_url,
    'icon_class' => empty($icon_url) ? $default_icons[$idx] : '',
  ];
}

ob_start();

?>

<div class="mission-section">

  <div class="fast-card-grid">

    <?php foreach ($fast_pillars as $item) : ?>

      <?php
      get_template_part(
        'template-parts/cards/fast-pillars-card',
        null,
        [
          'item' => $item,
        ]
      );
      ?>

    <?php endforeach; ?>

  </div>

  <div class="mission-section__content">

    <h3 class="mission-intro-text">
      <?php
      esc_html_e(
        'Empat Pilar Misi JTI',
        'webjti'
      );
      ?>
    </h3>

    <div class="mission-section__body">

      <?php
      echo wp_kses_post(
        $mission_content
      );
      ?>

    </div>

  </div>

</div>

<?php

$content =
  ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' =>
      'Misi Jurusan',

    'icon' =>
      'ph-gear-fine',

    'content' =>
      $content,

    'section_slug' => 'misi',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);