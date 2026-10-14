<?php
/**
 * Hak Mahasiswa Section
 *
 * @package WebJTI_Theme
 */

$hak_list    = get_field('hak_list');    
$hak_wysiwyg = get_field('hak_content'); 

$hak_content = '';

if (!empty($hak_list) && is_array($hak_list)) {
  $hak_content = '<ol class="rules-list">';
  foreach ($hak_list as $row) {
    $text = $row['item'] ?? $row['hak_item'] ?? '';
    if (!empty($text)) {
      $hak_content .= '<li class="rules-list-item">';
      $hak_content .= '  <p class="rules-list-desc">' . esc_html($text) . '</p>';
      $hak_content .= '</li>';
    }
  }
  $hak_content .= '</ol>';
} 

elseif (!empty($hak_wysiwyg)) {
  $hak_content = $hak_wysiwyg;
} 

else {
  $hak_content = 
    '<ol class="rules-list">' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Menggunakan kebebasan akademik secara bertanggung jawab untuk menuntut dan mengkaji ilmu sesuai dengan norma yang berlaku dalam lingkungan akademik.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Memperoleh pengajaran sebaik-baiknya dan layanan bidang akademik.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Memanfaatkan fasilitas Polinema dalam rangka kelancaran proses belajar.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Mendapat bimbingan dari dosen yang bertanggung jawab atas program studi yang diikutinya dalam penyelesaian studinya.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Memperoleh layanan informasi yang berkaitan dengan program studi yang diikutinya serta hasil belajarnya.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Memanfaatkan sumberdaya Polinema melalui perwakilan/organisasi kemahasiswaan untuk mengurus dan mengatur kesejahteraan, minat dan tata kehidupan bermasyarakat.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Ikut serta dalam kegiatan organisasi mahasiswa Polinema.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Menerima penghargaan atas prestasi akademik dan non akademik yang dicapai.</p>' .
    '  </li>' .
    '</ol>';
}

ob_start();
?>

<div class="hak-mahasiswa-section">
  <div class="hak-mahasiswa-section__content">
    <div class="hak-mahasiswa-section__body">
      <?php
      echo wp_kses_post(
        $hak_content
      );
      ?>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' => 'Hak Mahasiswa',
    'icon' => 'ph-user-check',
    'content' => $content,
    'section_slug' => 'hak',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);