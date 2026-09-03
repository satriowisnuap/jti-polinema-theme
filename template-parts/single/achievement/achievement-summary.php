<?php
/**
 * Achievement Summary Block
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;

if (!$achievement) {
    return;
}

$tahun = $achievement['tahun_prestasi'] ?? '';
$penyelenggara = $achievement['penyelenggara'] ?? '';
$lokasi = $achievement['lokasi'] ?? '';
$bidang = $achievement['bidang'] ?? '';
$jumlah_peserta = $achievement['jumlah_peserta'] ?? '';

ob_start();
?>

<div class="achievement-summary">

  <div class="achievement-summary__grid">

    <div class="achievement-summary__item">
      <span class="achievement-summary__label">Tahun</span>
      <p class="achievement-summary__value">
        <?php echo esc_html($tahun ?: '-'); ?>
      </p>
    </div>

    <div class="achievement-summary__item">
      <span class="achievement-summary__label">Penyelenggara</span>
      <p class="achievement-summary__value">
        <?php echo esc_html($penyelenggara ?: '-'); ?>
      </p>
    </div>

    <div class="achievement-summary__item">
      <span class="achievement-summary__label">Lokasi</span>
      <p class="achievement-summary__value">
        <?php echo esc_html($lokasi ?: '-'); ?>
      </p>
    </div>

    <div class="achievement-summary__item">
      <span class="achievement-summary__label">Bidang</span>
      <p class="achievement-summary__value">
        <?php echo esc_html($bidang ?: '-'); ?>
      </p>
    </div>

    <div class="achievement-summary__item">
      <span class="achievement-summary__label">Jumlah Peserta</span>
      <p class="achievement-summary__value">
        <?php echo esc_html($jumlah_peserta ?: '-'); ?>
      </p>
    </div>

  </div>

</div>

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' => 'Capaian Prestasi',
    'icon' => 'ph-medal',
    'content' => $content,
  ]
);