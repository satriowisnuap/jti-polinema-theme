<?php
/**
 * kewajiban Mahasiswa Section
 *
 * @package WebJTI_Theme
 */

$kewajiban_list    = get_field('kewajiban_list');    
$kewajiban_wysiwyg = get_field('kewajiban_content'); 

$kewajiban_content = '';

if (!empty($kewajiban_list) && is_array($kewajiban_list)) {
  $kewajiban_content = '<ol class="rules-list">';
  foreach ($kewajiban_list as $row) {
    $text = $row['item'] ?? $row['kewajiban_item'] ?? '';
    if (!empty($text)) {
      $kewajiban_content .= '<li class="rules-list-item">';
      $kewajiban_content .= '  <p class="rules-list-desc">' . esc_html($text) . '</p>';
      $kewajiban_content .= '</li>';
    }
  }
  $kewajiban_content .= '</ol>';
} 

elseif (!empty($kewajiban_wysiwyg)) {
  $kewajiban_content = $kewajiban_wysiwyg;
} 

else {
  $kewajiban_content = 
    '<ol class="rules-list">' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Mematuhi semua peraturan/ketentuan yang berlaku pada Polinema.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Turut serta menjaga sarana dan prasarana.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Mematuhi dan menjaga ketertiban kampus Polinema.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Menggunakan bahasa yang baik dalam berkomunikasi dengan pihak lain.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Menjunjung tinggi integritas dan rasa tanggung jawab sebagai masyarakat akademik.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Menjaga kewibawaan dan nama baik Polinema.</p>' .
    '  </li>' .
    '  <li class="rules-list-item">' .
    '    <p class="rules-list-desc">Menjunjung tinggi kebudayaan nasional.</p>' .
    '  </li>' .
    '</ol>';
}

ob_start();
?>

<div class="kewajiban-mahasiswa-section">
  <div class="kewajiban-mahasiswa-section__content">
    <div class="kewajiban-mahasiswa-section__body">
      <?php
      echo wp_kses_post(
        $kewajiban_content
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
    'title' => 'Kewajiban Mahasiswa',
    'icon' => 'ph-book-open-text',
    'content' => $content,
    'section_slug' => 'kewajiban',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);