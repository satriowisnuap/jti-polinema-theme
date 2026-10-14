<?php
/**
 * History Content Section
 *
 * @package WebJTI_Theme
 */

$rendered = false;

while (have_posts()) :

  the_post();
  $rendered = true;

  $title = get_the_title();
  $content = apply_filters('the_content', get_the_content());

  if (empty(trim(strip_tags($content)))) {
    $content = 
      '<p>Jurusan Teknologi Informasi Politeknik Negeri Malang berawal dari pendirian Program Studi Diploma 3 (D3) Manajemen Informatika (MI) pada tanggal 24 Juni 2005 berdasarkan SK Nomor Pendirian Program Studi 2001/D/T/2005. Melalui surat keputusan tersebut, Polinema diberikan izin oleh Direktorat Jenderal Pendidikan Tinggi (Dikti) untuk menyelenggarakan Program Studi Manajemen Informatika jenjang D3 di bawah Jurusan Teknik Elektro.</p>' .
      '<p>Pada awal berdirinya, Prodi D3 MI memiliki 92 mahasiswa, 1 teknisi, 1 tenaga administrasi, 6 dosen tetap, dan beberapa dosen luar biasa. Kepercayaan masyarakat terus meningkat jumlah mahasiswa bertumbuh dari 92 di tahun 2005 menjadi 502 di tahun 2019.</p>';
  }

  get_template_part(
    'template-parts/components/content-block',
    null,
    [

      'title' =>
        $title ?: 'Sejarah Kami',

      'icon' =>
        'ph-buildings',

      'content' =>
        $content,

    ]
  );

endwhile;

if (!$rendered) {
  $default_content = 
    '<p>Jurusan Teknologi Informasi Politeknik Negeri Malang berawal dari pendirian Program Studi Diploma 3 (D3) Manajemen Informatika (MI) pada tanggal 24 Juni 2005 berdasarkan SK Nomor Pendirian Program Studi 2001/D/T/2005. Melalui surat keputusan tersebut, Polinema diberikan izin oleh Direktorat Jenderal Pendidikan Tinggi (Dikti) untuk menyelenggarakan Program Studi Manajemen Informatika jenjang D3 di bawah Jurusan Teknik Elektro.</p>' .
    '<p>Pada awal berdirinya, Prodi D3 MI memiliki 92 mahasiswa, 1 teknisi, 1 tenaga administrasi, 6 dosen tetap, dan beberapa dosen luar biasa. Kepercayaan masyarakat terus meningkat jumlah mahasiswa bertumbuh dari 92 di tahun 2005 menjadi 502 di tahun 2019.</p>';

  get_template_part(
    'template-parts/components/content-block',
    null,
    [
      'title' => 'Sejarah Kami',
      'icon' => 'ph-buildings',
      'content' => $default_content,
    ]
  );
}