<?php
/* ========================================
   GET CAMPUS STATS
======================================== */

function webjti_get_campus_stats() {

  $total_prodi_override = get_theme_mod('webjti_total_prodi', '');
  if (!empty($total_prodi_override)) {
    $total_prodi = $total_prodi_override;
  } else {
    $prodi_count = wp_count_posts('study_program');
    $total_prodi = $prodi_count->publish ?? 0;
    if (!$total_prodi) {
      $total_prodi = 12; // Fallback
    }
  }

  $total_mahasiswa =
    get_theme_mod(
      'webjti_total_mahasiswa',
      '1245+'
    );

  $total_alumni =
    get_theme_mod(
      'webjti_total_alumni',
      '4567+'
    );

  $total_labs_override = get_theme_mod('webjti_total_labs', '');
  if (!empty($total_labs_override)) {
    $total_labs = $total_labs_override;
  } else {
    $labs_count = wp_count_posts('labs') ?? (object) [];
    $total_labs = $labs_count->publish ?? 0;
    if (!$total_labs) {
      $total_labs = 14; // Fallback
    }
  }

  return [

    [
      'icon'  => 'ph-graduation-cap',
      'value' => $total_prodi,
      'label' => 'Program Studi',
    ],

    [
      'icon'  => 'ph-users-three',
      'value' => $total_mahasiswa,
      'label' => 'Mahasiswa Aktif',
    ],

    [
      'icon'  => 'ph-student',
      'value' => $total_alumni,
      'label' => 'Alumni',
    ],

    [
      'icon'  => 'ph-flask',
      'value' => $total_labs,
      'label' => 'Laboratorium Riset',
    ],

  ];

}