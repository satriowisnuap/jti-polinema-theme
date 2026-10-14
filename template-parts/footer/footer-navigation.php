<?php
/**
 * Footer Navigation Template
 *
 * @package WebJTI_Theme
 */
?>

<div class="ft-col ft-col--nav">
  <!-- Column 1: Program Studi -->
  <div class="ft-nav-group">
    <p class="ft-nav-label">
      <?php esc_html_e('Program Studi', 'webjti-theme'); ?>
    </p>
    <?php
    if (has_nav_menu('footer_programs')) :
      wp_nav_menu([
        'theme_location' => 'footer_programs',
        'menu_class'     => 'ft-nav-list',
        'container'      => false,
        'depth'          => 1,
        'fallback_cb'    => false,
      ]);
    else :
    ?>
      <ul class="ft-nav-list">
        <li><a href="#"><?php esc_html_e('Teknik Informatika', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Sistem Informasi Bisnis', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Manajemen Informatika', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Teknologi Informasi', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Pengembangan Lunak Situs', 'webjti-theme'); ?></a></li>
      </ul>
    <?php endif; ?>
  </div>

  <!-- Column 2: Akademik -->
  <div class="ft-nav-group">
    <p class="ft-nav-label">
      <?php esc_html_e('Akademik', 'webjti-theme'); ?>
    </p>
    <?php
    if (has_nav_menu('footer_academic')) :
      wp_nav_menu([
        'theme_location' => 'footer_academic',
        'menu_class'     => 'ft-nav-list',
        'container'      => false,
        'depth'          => 1,
        'fallback_cb'    => false,
      ]);
    else :
    ?>
      <ul class="ft-nav-list">
        <li><a href="#"><?php esc_html_e('Kalender Akademik', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Kurikulum', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Jadwal Kuliah', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('LMS', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Perpustakaan Digital', 'webjti-theme'); ?></a></li>
      </ul>
    <?php endif; ?>
  </div>

  <!-- Column 3: Penelitian -->
  <div class="ft-nav-group">
    <p class="ft-nav-label">
      <?php esc_html_e('Penelitian', 'webjti-theme'); ?>
    </p>
    <?php
    if (has_nav_menu('footer_research')) :
      wp_nav_menu([
        'theme_location' => 'footer_research',
        'menu_class'     => 'ft-nav-list',
        'container'      => false,
        'depth'          => 1,
        'fallback_cb'    => false,
      ]);
    else :
    ?>
      <ul class="ft-nav-list">
        <li><a href="#"><?php esc_html_e('Penelitian Dosen', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Pengabdian Dosen', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Laboratorium Lab', 'webjti-theme'); ?></a></li>
        <li><a href="#"><?php esc_html_e('Jurnal (JIP)', 'webjti-theme'); ?></a></li>
      </ul>
    <?php endif; ?>
  </div>
</div>