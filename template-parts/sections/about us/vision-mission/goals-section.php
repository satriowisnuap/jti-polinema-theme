<?php
/**
 * Goals Section
 *
 * @package WebJTI_Theme
 */

$goals_content = get_field('tujuan_content');

if (!$goals_content) {
  $goals_content = 
    '<ol class="mission-list">' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Mandiri lulusan berkarakter</h4>' .
    '    <p class="mission-list-desc">Menghasilkan lulusan bidang Teknologi Informasi dan Rekayasa Perangkat Lunak yang berketuhanan, beretika dan bermoral baik, berpengetahuan dan berketerampilan tinggi, siap bekerja dan/atau berwirausaha yang mampu bersaing dalam skala global.</p>' .
    '  </li>' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Agenda penelitian internasional</h4>' .
    '    <p class="mission-list-desc">Menghasilkan penelitian terapan bidang Teknologi Informasi dan Rekayasa Perangkat Lunak yang berskala internasional, meningkatkan efektivitas, efisiensi, dan produktivitas dalam dunia usaha dan industri, serta mengarah pada perolehan HaKI dan paten.</p>' .
    '  </li>' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Jangkau masyarakat luas</h4>' .
    '    <p class="mission-list-desc">Menghasilkan pengabdian kepada masyarakat melalui penerapan dan penyebarluasan ilmu pengetahuan dan teknologi serta pemberian layanan jasa secara profesional dalam bidang Teknologi Informasi dan Rekayasa Perangkat Lunak.</p>' .
    '  </li>' .
    '  <li class="mission-list-item">' .
    '    <h4 class="mission-list-title">Upaya kerjasama berdaya saing</h4>' .
    '    <p class="mission-list-desc">Terwujudnya kerjasama yang saling menguntungkan dengan berbagai pihak baik di dalam maupun di luar negeri pada bidang Teknologi Informasi untuk meningkatkan daya saing.</p>' .
    '  </li>' .
    '</ol>';
}

ob_start();

?>

<div class="goals-section">

  <div class="goals-section__content">

    <h3 class="mission-intro-text">
      <?php
      esc_html_e(
        'Empat Tujuan Strategis JTI',
        'webjti'
      );
      ?>
    </h3>

    <div class="goals-section__body">

      <?php
      echo wp_kses_post(
        $goals_content
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
      'Tujuan Jurusan',

    'icon' =>
      'ph-chart-polar',

    'content' =>
      $content,

    'section_slug' => 'tujuan',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);