<?php
/**
 * Achievement Table Section
 *
 * @package WebJTI_Theme
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Retrieve matched achievements from our unified helper (handles both DB & Mock fallback)
$result = webjti_get_achievements_list($_GET, $paged, 10);
$rows = $result['rows'];
$max_pages = $result['max_pages'];
?>

<div class="achievement-table-section">
    <div class="tabular-data-wrapper" style="margin-bottom: 24px;">
        <table class="tabular-data-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Prodi</th>
                    <th style="width: 15%;">Ketua Tim</th>
                    <th style="width: 24%;">Judul Kompetisi</th>
                    <th style="width: 8%;">Tahun</th>
                    <th style="width: 11%;">Juara</th>
                    <th style="width: 13%;">Tingkat</th>
                    <th style="width: 9%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)) : ?>
                    <?php foreach ($rows as $row) : ?>
                        <?php
                        get_template_part(
                            'template-parts/cards/achievement-table-row',
                            null,
                            [
                                'row' => $row,
                            ]
                        );
                        ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 48px; color: var(--neutral-05); background: var(--neutral-00);">
                            Tidak ada data prestasi yang cocok dengan filter yang dipilih.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    get_template_part(
        'template-parts/sections/kemahasiswaan/prestasi/achievement-pagination',
        null,
        [
            'paged'     => $paged,
            'max_pages' => $max_pages,
        ]
    );
    ?>
</div>
