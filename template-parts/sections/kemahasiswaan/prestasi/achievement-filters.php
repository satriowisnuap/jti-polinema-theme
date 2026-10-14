<?php
/**
 * Achievement Filters
 *
 * @package WebJTI_Theme
 */

/* ============================================================
   FILTER OPTIONS
   ============================================================ */

$prodi_options = [];
$study_programs_data = webjti_get_study_programs(-1);

if (!empty($study_programs_data)) {
    foreach ($study_programs_data as $sp) {
        if (!empty($sp['id']) && $sp['id'] !== 0) {
            $label = $sp['title'];
            if (!empty($sp['badge'])) {
                $label .= ' (' . $sp['badge'] . ')';
            }
            $slug = get_post_field('post_name', $sp['id']);
            $value = str_replace('-', '_', $slug);
            $prodi_options[$value] = $label;
        }
    }
}

if (empty($prodi_options)) {
    $prodi_options = [
        'd2_ppls' => 'D2 Pengembangan Piranti Lunak Situs',
        'd3_mi_kediri' => 'D3 Manajemen Informatika (Kediri)',
        'd3_mi_lumajang' => 'D3 Manajemen Informatika (Lumajang)',
        'd4_teknik_informatika' => 'D4 Teknik Informatika',
        'd4_sistem_informasi_bisnis' => 'D4 Sistem Informasi Bisnis',
        's2_rekayasa_teknologi_informasi' => 'S2 Rekayasa Teknologi Informasi',
    ];
}


$juara_options = [
    'juara_1' => 'Juara 1',
    'juara_2' => 'Juara 2',
    'juara_3' => 'Juara 3',
    'harapan_1' => 'Harapan 1',
    'harapan_2' => 'Harapan 2',
    'finalis' => 'Finalis',
];

$tingkat_options = [
    'internasional' => 'Internasional',
    'nasional' => 'Nasional',
    'regional' => 'Regional',
    'lokal' => 'Lokal',
];

/* ============================================================
   ACTIVE FILTERS
   ============================================================ */

$f_prodi = isset($_GET['prodi'])
    ? sanitize_text_field($_GET['prodi'])
    : '';

$f_tahun = isset($_GET['tahun'])
    ? sanitize_text_field($_GET['tahun'])
    : '';

$f_juara = isset($_GET['juara'])
    ? sanitize_text_field($_GET['juara'])
    : '';

$f_tingkat = isset($_GET['tingkat'])
    ? sanitize_text_field($_GET['tingkat'])
    : '';

$f_search = isset($_GET['q'])
    ? sanitize_text_field($_GET['q'])
    : (isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '');

/* ============================================================
   YEAR OPTIONS
   ============================================================ */

$tahun_list = webjti_get_achievement_years();

?>

<form
    method="GET"
    class="prestasi-filters"
    id="prestasi-filter-form"
>

    <div class="filter-group">

        <!-- PROGRAM STUDI -->

        <select
            name="prodi"
            class="prestasi-select"
            onchange="this.form.submit()"
        >

            <option value="">
                Program Studi: All
            </option>

            <?php foreach ($prodi_options as $value => $label) : ?>

                <option
                    value="<?php echo esc_attr($value); ?>"
                    <?php selected($f_prodi, $value); ?>
                >

                    <?php echo esc_html($label); ?>

                </option>

            <?php endforeach; ?>

        </select>

        <!-- TAHUN -->

        <select
            name="tahun"
            class="prestasi-select"
            onchange="this.form.submit()"
        >

            <option value="">
                Tahun: All
            </option>

            <?php foreach ($tahun_list as $tahun) : ?>

                <option
                    value="<?php echo esc_attr($tahun); ?>"
                    <?php selected($f_tahun, (string) $tahun); ?>
                >

                    <?php echo esc_html($tahun); ?>

                </option>

            <?php endforeach; ?>

        </select>

        <!-- JUARA -->

        <select
            name="juara"
            class="prestasi-select"
            onchange="this.form.submit()"
        >

            <option value="">
                Juara: All
            </option>

            <?php foreach ($juara_options as $value => $label) : ?>

                <option
                    value="<?php echo esc_attr($value); ?>"
                    <?php selected($f_juara, $value); ?>
                >

                    <?php echo esc_html($label); ?>

                </option>

            <?php endforeach; ?>

        </select>

        <!-- TINGKAT -->

        <select
            name="tingkat"
            class="prestasi-select"
            onchange="this.form.submit()"
        >

            <option value="">
                Tingkat: All
            </option>

            <?php foreach ($tingkat_options as $value => $label) : ?>

                <option
                    value="<?php echo esc_attr($value); ?>"
                    <?php selected($f_tingkat, $value); ?>
                >

                    <?php echo esc_html($label); ?>

                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <!-- SEARCH -->

    <div class="prestasi-search-wrapper">

        <i class="ph ph-magnifying-glass"></i>

        <input
            type="text"
            name="q"
            class="prestasi-search-input"
            placeholder="Cari judul kompetisi, tahun, dll.."
            value="<?php echo esc_attr($f_search); ?>"
        >

    </div>

</form>