<?php
/**
 * Larangan Mahasiswa Section
 *
 * @package WebJTI_Theme
 */

$larangan_list    = get_field('larangan_list');    
$larangan_wysiwyg = get_field('larangan_content'); 

$larangan_content = '';

if (!empty($larangan_list) && is_array($larangan_list)) {
  $larangan_content = '<ol class="rules-list">';
  foreach ($larangan_list as $row) {
    $text = $row['item'] ?? $row['larangan_item'] ?? '';
    if (!empty($text)) {
      $larangan_content .= '<li class="rules-list-item">';
      $larangan_content .= '  <p class="rules-list-desc">' . esc_html($text) . '</p>';
      $larangan_content .= '</li>';
    }
  }
  $larangan_content .= '</ol>';
} 
elseif (!empty($larangan_wysiwyg)) {
  $larangan_content = $larangan_wysiwyg;
} 
else {
  $items = [
    'Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain;',
    'Berbusana tidak sopan dan tidak rapi, meliputi: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, dan/atau sepatu sandal di lingkungan kampus;',
    'Berambut tidak rapi atau gondrong bagi mahasiswa Iaki-laki. Batasan rambut gondrong atau tidak rapi apabila panjang rambut melewati batas alis mata di bagian depan, melewati telinga di bagian samping atau menyentuh kerah baju di bagian leher;',
    'Berambut dengan model punk, di cat selain hitam dan/ atau skinned;',
    'Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel;',
    'Meninggalkan sampah yang dapat menyebabkan kotor di seluruh area Polinema;',
    'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung;',
    'Merokok di luar area kawasan merokok;',
    'Bermain kartu, game online di area kampus;',
    'Mengotori atau mencoret-coret meja, kursi, tembok, dan fasilitas lain di lingkungan Polinema;',
    'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan;',
    'Merusak sarana dan prasarana yang ada di area Polinema;',
    'Melakukan aktivitas yang dapat mengganggu ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda yang tidak sesuai himbauan atau bahkan konvoi di luar acara wisuda tanpa izin, dll);',
    'Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang;',
    'Mengakses materi pornografi di kelas atau area kampus;',
    'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal;',
    'Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif;',
    'Melakukan kegiatan politik praktis di dalam kampus;',
    'Melakukan tindakan kekerasan atau perkelahian di dalam kampus;',
    'Melakukan penyalahgunaan identitas untuk perbuatan negatif;',
    'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan Polinema;',
    'Melakukan pencurian dalam bentuk apapun di lingkungan Polinema;',
    'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan;',
    'Melakukan pemerasan dan/atau penipuan;',
    'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus;',
    'Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema;',
    'Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah;',
    'Melakukan pemalsuan data / dokumen / tanda tangan;',
    'Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah;',
    'Menjatuhkan nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun;',
    'Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema;',
    'Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya;',
    'Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya;',
    'Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan.'
  ];

  $larangan_content = '<ol class="rules-list">';
  foreach ($items as $item) {
    $larangan_content .= '<li class="rules-list-item"><p class="rules-list-desc">' . esc_html($item) . '</p></li>';
  }
  $larangan_content .= '</ol>';
}

ob_start();
?>

<div class="larangan-mahasiswa-section">
  <div class="larangan-mahasiswa-section__content">
    <div class="larangan-mahasiswa-section__body">
      <?php
      echo wp_kses_post(
        $larangan_content
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
    'title' => 'Larangan bagi Mahasiswa',
    'icon' => 'ph-warning-octagon',
    'content' => $content,
    'section_slug' => 'larangan',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);