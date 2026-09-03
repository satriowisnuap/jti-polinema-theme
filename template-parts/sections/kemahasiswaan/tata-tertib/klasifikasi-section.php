<?php
/**
 * Klasifikasi Pelanggaran Section
 *
 * @package WebJTI_Theme
 */

$klasifikasi_desc   = get_field('klasifikasi_description');
$tingkat_list       = get_field('tingkat_pelanggaran_list');
$akumulasi_desc     = get_field('akumulasi_description');
$akumulasi_list     = get_field('akumulasi_list');
$klasifikasi_wysiwyg = get_field('klasifikasi_content'); 

$klasifikasi_content = '';

if (!empty($klasifikasi_wysiwyg)) {
  $klasifikasi_content = $klasifikasi_wysiwyg;
} 
elseif (!empty($tingkat_list) || !empty($akumulasi_list)) {
  $desc1 = $klasifikasi_desc ?: 'Pelanggaran terhadap tata tertib di atas dikategori menjadi 5 tingkat pelanggaran, yaitu:';
  $klasifikasi_content .= '<p class="rules-intro">' . esc_html($desc1) . '</p>';

  if (!empty($tingkat_list) && is_array($tingkat_list)) {
    $klasifikasi_content .= '<ul class="rules-list levels-list">';
    foreach ($tingkat_list as $row) {
      $tingkat = $row['tingkat'] ?? '';
      $kategori = $row['kategori'] ?? '';
      if (!empty($tingkat)) {
        $klasifikasi_content .= '<li class="rules-list-item">';
        $klasifikasi_content .= '  <strong>' . esc_html($tingkat) . '</strong>' . ($kategori ? ', merupakan ' . esc_html($kategori) : '');
        $klasifikasi_content .= '</li>';
      }
    }
    $klasifikasi_content .= '</ul>';
  }

  $desc2 = $akumulasi_desc ?: 'Pelanggaran Tata Tertib Kehidupan Kampus akan diakumulasikan untuk setiap kategori pelanggaran dan berlaku sepanjang mahasiswa masih tercatat sebagai mahasiswa di Polinema. Akumulasi Pelanggaran Tata Tertib Kehidupan kampus mengikuti aturan sebagai berikut:';
  $klasifikasi_content .= '<p class="rules-intro mt-4">' . esc_html($desc2) . '</p>';

  if (!empty($akumulasi_list) && is_array($akumulasi_list)) {
    $klasifikasi_content .= '<ol class="rules-list accumulation-list">';
    foreach ($akumulasi_list as $row) {
      $rule = $row['rule'] ?? $row['item'] ?? '';
      if (!empty($rule)) {
        $klasifikasi_content .= '<li class="rules-list-item"><p class="rules-list-desc">' . esc_html($rule) . '</p></li>';
      }
    }
    $klasifikasi_content .= '</ol>';
  }
} 
else {
  $klasifikasi_content = 
    '<p class="rules-intro">Pelanggaran terhadap tata tertib di atas dikategori menjadi 5 tingkat pelanggaran, yaitu:</p>' .
    '<ul class="rules-list levels-list">' .
    '  <li class="rules-list-item">Pelanggaran tingkat I, merupakan pelanggaran sangat berat</li>' .
    '  <li class="rules-list-item">Pelanggaran tingkat II, merupakan pelanggaran berat</li>' .
    '  <li class="rules-list-item">Pelanggaran tingkat III, merupakan pelanggaran cukup berat</li>' .
    '  <li class="rules-list-item">Pelanggaran tingkat IV, merupakan pelanggaran sedang</li>' .
    '  <li class="rules-list-item">Pelanggaran tingkat V, merupakan pelanggaran ringan</li>' .
    '</ul>' .
    '<p class="rules-intro mt-4">Pelanggaran Tata Tertib Kehidupan Kampus akan diakumulasikan untuk setiap kategori pelanggaran dan berlaku sepanjang mahasiswa masih tercatat sebagai mahasiswa di Polinema. Akumulasi Pelanggaran Tata Tertib Kehidupan kampus mengikuti aturan sebagai berikut:</p>' .
    '<ol class="rules-list accumulation-list">' .
    '  <li class="rules-list-item"><p class="rules-list-desc">Apabila pelanggaran tingkat V dilakukan 3 (tiga) kali maka klasifikasi pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat IV.</p></li>' .
    '  <li class="rules-list-item"><p class="rules-list-desc">Apabila pelanggaran tingkat IV dilakukan 3 (tiga) kali maka klasifikasi pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat III.</p></li>' .
    '  <li class="rules-list-item"><p class="rules-list-desc">Apabila pelanggaran tingkat III dilakukan 3 (tiga) kali maka klasifikasi pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat II.</p></li>' .
    '  <li class="rules-list-item"><p class="rules-list-desc">Apabila pelanggaran tingkat II dilakukan 3 (tiga) kali maka klasifikasi pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat I.</p></li>' .
    '</ol>';
}

ob_start();
?>

<div class="klasifikasi-mahasiswa-section">
  <div class="klasifikasi-mahasiswa-section__content">
    <div class="klasifikasi-mahasiswa-section__body">
      <?php
      echo wp_kses_post(
        $klasifikasi_content
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
    'title' => 'Klasifikasi & Tingkat Pelanggaran',
    'icon' => 'ph-list-checks',
    'content' => $content,
    'section_slug' => 'klasifikasi',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);