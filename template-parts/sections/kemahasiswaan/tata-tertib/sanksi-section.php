<?php
/**
 * Sanksi Pelanggaran Section
 *
 * @package WebJTI_Theme
 */

$sanksi_list    = get_field('sanksi_list');    
$sanksi_wysiwyg = get_field('sanksi_content'); 

$sanksi_content = '';

if (!empty($sanksi_wysiwyg)) {
  $sanksi_content = $sanksi_wysiwyg;
} 
elseif (!empty($sanksi_list) && is_array($sanksi_list)) {
  $sanksi_content = '<ul class="rules-list sanctions-list">';
  foreach ($sanksi_list as $row) {
    $tingkat = $row['tingkat'] ?? '';
    $detail  = $row['detail'] ?? $row['item'] ?? '';
    if (!empty($tingkat) || !empty($detail)) {
      $sanksi_content .= '<li class="rules-list-item">';
      if (!empty($tingkat)) {
        $sanksi_content .= '  <strong>' . esc_html($tingkat) . '</strong>: ';
      }
      $sanksi_content .= wp_kses_post($detail);
      $sanksi_content .= '</li>';
    }
  }
  $sanksi_content .= '</ul>';
} 
else {
  $sanksi_content = 
    '<p class="rules-intro">Berikut adalah sanksi yang diberikan berdasarkan tingkat pelanggarannya:</p>' .
    '<ul class="rules-list sanctions-list">' .
    '  <li class="rules-list-item">' .
    '    <strong>Sanksi atas pelanggaran Tingkat V</strong>: Teguran lisan disertai dengan surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai, ditandatangani mahasiswa yang bersangkutan dan DPA.' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <strong>Sanksi atas pelanggaran Tingkat IV</strong>: Teguran tertulis disertai dengan pemanggilan orang tua/wali dan membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai, ditandatangani mahasiswa, orang tua/wali, dan DPA.' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <strong>Sanksi atas pelanggaran Tingkat III</strong>:' .
    '    <ol class="sub-rules-list mt-2">' .
    '      <li>Membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai ditandatangani mahasiswa, orang tua/wali, dan DPA;</li>' .
    '      <li>Melakukan tugas khusus, misalnya bertanggung jawab untuk memperbaiki atau membersihkan kembali, dan tugas-tugas lainnya.</li>' .
    '    </ol>' .
    '  </li>' .
    '</ul>';
}

ob_start();
?>

<div class="sanksi-mahasiswa-section">
  <div class="sanksi-mahasiswa-section__content">
    <div class="sanksi-mahasiswa-section__body">
      <?php
      echo wp_kses_post(
        $sanksi_content
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
    'title' => 'Sanksi Pelanggaran',
    'icon' => 'ph-gavel',
    'content' => $content,
    'section_slug' => 'sanksi',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);