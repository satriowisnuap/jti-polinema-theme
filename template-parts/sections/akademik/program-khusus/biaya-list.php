<?php
/**
 * Rincian Biaya (Format List/Card)
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$pendaftaran = $args['biaya_pendaftaran'] ?? '';
$ipi = $args['biaya_ipi'] ?? '';
$ukt = $args['biaya_ukt'] ?? '';
$mitra_list = $args['biaya_mitra_list'] ?? [];
$catatan = $args['biaya_catatan'] ?? '';
?>

<div class="biaya-list-container" style="display: flex; flex-direction: column; gap: 1.5rem;">

    <!-- Komponen Biaya Polinema -->
    <div class="biaya-card" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem;">Biaya Pendidikan di Polinema</h3>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
            <?php if ($pendaftaran) : ?>
            <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 0.5rem;">
                <span style="font-weight: 500; color: #475569;">Biaya Pendaftaran</span>
                <span style="font-weight: 700; color: #0f172a;"><?php echo esc_html($pendaftaran); ?></span>
            </li>
            <?php endif; ?>
            
            <?php if ($ipi) : ?>
            <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 0.5rem;">
                <span style="font-weight: 500; color: #475569;">IPI Rekayasa</span>
                <span style="font-weight: 700; color: #0f172a;"><?php echo esc_html($ipi); ?></span>
            </li>
            <?php endif; ?>

            <?php if ($ukt) : ?>
            <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #cbd5e1; padding-bottom: 0.5rem;">
                <span style="font-weight: 500; color: #475569;">UKT / Semester</span>
                <span style="font-weight: 700; color: #0f172a;"><?php echo esc_html($ukt); ?></span>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Komponen Biaya Kampus Mitra -->
    <?php if (!empty($mitra_list)) : ?>
    <div class="biaya-card" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 1.5rem;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #166534; border-bottom: 2px solid #bbf7d0; padding-bottom: 0.5rem;">Biaya di Kampus Mitra</h3>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($mitra_list as $mitra) : 
                $label = $mitra['label'] ?? '';
                $nominal = $mitra['nominal'] ?? '';
                $currency = $mitra['currency'] ?? 'CNY';
            ?>
            <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #bbf7d0; padding-bottom: 0.5rem;">
                <span style="font-weight: 500; color: #166534;"><?php echo esc_html($label); ?></span>
                <span style="font-weight: 700; color: #14532d;">
                    <?php echo esc_html($nominal); ?> 
                    <span style="background: #dcfce7; color: #166534; font-size: 0.8rem; padding: 2px 6px; border-radius: 4px; margin-left: 4px;"><?php echo esc_html($currency); ?></span>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Catatan Tambahan -->
    <?php if ($catatan) : ?>
    <div class="biaya-notes" style="background: #fffbeb; border-left: 4px solid #fbbf24; padding: 1rem; font-size: 0.95rem; color: #92400e;">
        <?php echo apply_filters('the_content', $catatan); ?>
    </div>
    <?php endif; ?>

</div>
