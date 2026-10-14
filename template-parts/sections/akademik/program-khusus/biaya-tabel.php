<?php
/**
 * Rincian Biaya (Format Tabel)
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$biaya_list = $args['biaya_list'] ?? [];

$grouped_biaya = [];
if (!empty($biaya_list)) {
    foreach ($biaya_list as $item) {
        if (isset($item['kelompok_program']) || isset($item['ipi_utama'])) {
            $kelompok = !empty($item['kelompok_program']) ? $item['kelompok_program'] : 'Lainnya';
            if (!isset($grouped_biaya[$kelompok])) {
                $grouped_biaya[$kelompok] = [];
            }
            $grouped_biaya[$kelompok][] = $item;
        } else {
            // Fallback for old data format
            $grouped_biaya['Umum'][] = $item;
        }
    }
}
?>
<?php
$biaya_pendaftaran = $args['biaya_pendaftaran'] ?? '';
?>

<?php if (!empty($biaya_pendaftaran)) : ?>
    <div class="biaya-pendaftaran-box" style="margin-bottom: 20px; padding: 15px; border-left: 4px solid #007bff; background-color: #f8f9fa;">
        <p style="margin: 0; font-weight: bold;">Biaya Pendaftaran: <span style="font-weight: normal;"><?php echo esc_html($biaya_pendaftaran); ?></span></p>
    </div>
<?php endif; ?>

<?php if (!empty($grouped_biaya)) : ?>
    <div class="biaya-block" style="overflow-x:auto;">
        <table class="table biaya-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background-color: #007bff; color: white;">
                <tr>
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: center; vertical-align: middle;">No</th>
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: center; vertical-align: middle;">Bidang</th>
                    <th colspan="3" style="padding: 10px; border: 1px solid #ddd; text-align: center;">IPI</th>
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: center; vertical-align: middle;">UKT/<br>Semester</th>
                </tr>
                <tr>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: center; font-weight: normal; font-size: 0.9em;">Calon Mahasiswa dari Kampus Utama</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: center; font-weight: normal; font-size: 0.9em;">Calon Mahasiswa dari Kampus PSDKU Polinema</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: center; font-weight: normal; font-size: 0.9em;">Calon Mahasiswa dari luar Kampus Polinema</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grouped_biaya as $kelompok => $items) : ?>
                    <?php if ($kelompok !== 'Umum' && $kelompok !== 'Lainnya') : ?>
                    <tr>
                        <td colspan="6" style="padding: 10px; border: 1px solid #ddd; text-align: center; font-weight: bold; background-color: #f9f9f9;">
                            <u><?php echo esc_html($kelompok); ?></u>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <?php $no = 1; foreach ($items as $item) : 
                        if (isset($item['label']) && isset($item['value']) && !isset($item['bidang'])) {
                            // Old format fallback
                            $bidang = $item['label'];
                            $ipi_utama = $item['value'];
                            $ipi_psdku = '-';
                            $ipi_luar = '-';
                            $ukt = '-';
                        } else {
                            // New horizontal format
                            $bidang = $item['bidang'] ?? '-';
                            $ipi_utama = $item['ipi_utama'] ?? '-';
                            $ipi_psdku = $item['ipi_psdku'] ?? '-';
                            $ipi_luar = $item['ipi_luar'] ?? '-';
                            $ukt = $item['ukt'] ?? '-';
                        }
                    ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?php echo $no++; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo esc_html($bidang); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo esc_html($ipi_utama); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo esc_html($ipi_psdku); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo esc_html($ipi_luar); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo esc_html($ukt); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p>Informasi biaya belum tersedia.</p>
<?php endif; ?>
