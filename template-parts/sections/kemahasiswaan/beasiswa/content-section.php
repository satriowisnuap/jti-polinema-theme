<?php
/**
 * Beasiswa Content Section
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_id = absint(get_the_ID());
$has_acf = function_exists('get_field');

// Fetch beasiswa CPT posts
$beasiswa_query = new WP_Query([
    'post_type'      => 'beasiswa',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
]);

$req_text = $has_acf ? get_field('beasiswa_requirements', $page_id) : '';
$requirements = [];
if (!empty($req_text)) {
    $lines = explode("\n", $req_text);
    foreach ($lines as $line) {
        $clean_line = trim($line);
        if (!empty($clean_line)) {
            $requirements[] = $clean_line;
        }
    }
}
if (empty($requirements)) {
    $requirements = [
        'Mahasiswa aktif Jurusan Teknologi Informasi Politeknik Negeri Malang.',
        'Tidak sedang menerima beasiswa dari instansi atau pihak lain.',
        'Memiliki IPK minimal 3.00 (berbeda tergantung jenis beasiswa).',
        'Berkelakuan baik dan tidak pernah melanggar tata tertib kampus.',
        'Melengkapi berkas administrasi seperti Surat Keterangan Tidak Mampu (SKTM) untuk beasiswa bantuan finansial.'
    ];
}

$faq = [];
if ($has_acf) {
    for ($i = 1; $i <= 5; $i++) {
        $q = get_field("faq_{$i}_q", $page_id);
        $a = get_field("faq_{$i}_a", $page_id);
        if (!empty($q) && !empty($a)) {
            $faq[] = ['q' => $q, 'a' => $a];
        }
    }
}
if (empty($faq)) {
    $faq = [
        [
            'q' => 'Kapan pendaftaran beasiswa biasanya dibuka?',
            'a' => 'Pendaftaran beasiswa umumnya dibuka pada awal semester ganjil atau genap, tergantung kebijakan masing-masing penyedia beasiswa.'
        ],
        [
            'q' => 'Apakah saya bisa mendaftar lebih dari satu beasiswa?',
            'a' => 'Boleh mendaftar, namun jika diterima, Anda hanya diperbolehkan menerima satu jenis beasiswa yang didanai oleh APBN/APBD atau instansi yang melarang penerimaan beasiswa ganda.'
        ],
        [
            'q' => 'Di mana saya bisa mendapatkan informasi terbaru tentang beasiswa?',
            'a' => 'Informasi terbaru akan diumumkan melalui website resmi JTI, grup komunikasi mahasiswa, serta mading jurusan.'
        ]
    ];
}

$tabs = [
    ['id' => 'informasi', 'label' => 'Informasi Umum'],
    ['id' => 'jenis', 'label' => 'Jenis Beasiswa'],
    ['id' => 'syarat', 'label' => 'Persyaratan'],
    ['id' => 'faq', 'label' => 'FAQ'],
];
?>

<style>
/* Premium Aesthetic Styles for Beasiswa Page */
.beasiswa-hero-card {
    background: linear-gradient(to right, #ffffff, #f8fafc);
    border-left: 5px solid #3b82f6;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.beasiswa-hero-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.08);
}
.beasiswa-hero-card p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #475569;
    margin: 0;
}

/* Gutenberg Content Additions for Landing Page */
.gutenberg-content-area {
    margin-top: 1.5rem;
    color: #475569;
    line-height: 1.8;
    font-size: 1.05rem;
}
.gutenberg-content-area h2, 
.gutenberg-content-area h3, 
.gutenberg-content-area h4 {
    color: #1e293b;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}
.gutenberg-content-area h2:first-child,
.gutenberg-content-area h3:first-child {
    margin-top: 0;
}
.gutenberg-content-area img {
    border-radius: 12px;
    height: auto;
    max-width: 100%;
    margin: 1.5rem 0;
}
.gutenberg-content-area table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}
.gutenberg-content-area table th,
.gutenberg-content-area table td {
    padding: 1rem;
    border: 1px solid #e2e8f0;
}
.gutenberg-content-area table th {
    background: #f8fafc;
    color: #1e293b;
    font-weight: 600;
}
.gutenberg-content-area a {
    color: #3b82f6;
    text-decoration: none;
}
.gutenberg-content-area a:hover {
    text-decoration: underline;
}
.gutenberg-content-area .wp-block-file {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.gutenberg-content-area .wp-block-file a.wp-block-file__button {
    background: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
}
.gutenberg-content-area ul, 
.gutenberg-content-area ol {
    margin-left: 1.5rem;
    margin-bottom: 1.5rem;
}
.gutenberg-content-area li {
    margin-bottom: 0.5rem;
}


.scholarship-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}
.scholarship-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #f1f5f9;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}
.scholarship-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: var(--card-color, #3b82f6);
    transition: height 0.3s ease;
}
.scholarship-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
.scholarship-card:hover::before {
    height: 100%;
    opacity: 0.03;
}
.scholarship-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--card-color, #3b82f6);
    color: white;
    font-size: 28px;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 15px -3px rgba(var(--card-color-rgb, 59, 130, 246), 0.3);
}
.scholarship-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}
.scholarship-provider {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
}
.scholarship-desc {
    color: #475569;
    line-height: 1.6;
    margin-bottom: 0;
    flex-grow: 1;
}

.scholarship-action {
    margin-top: 1.5rem;
    font-weight: 600;
    color: #3b82f6; /* Fallback, usually overridden by inline style if solid color used, but we'll use a generic color or inherit */
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    transition: gap 0.3s ease;
}
.scholarship-card:hover .scholarship-action {
    gap: 0.75rem;
    color: #2563eb;
}

.req-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.req-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}
.req-item:hover {
    background: #ffffff;
    border-color: #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    transform: translateX(5px);
}
.req-icon {
    color: #10b981;
    font-size: 1.25rem;
    margin-right: 1rem;
    margin-top: 2px;
}
.req-text {
    color: #334155;
    font-size: 1.05rem;
    line-height: 1.6;
}

.faq-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.faq-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}
.faq-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}
.faq-q {
    font-weight: 700;
    color: #0f172a;
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
}
.faq-q i {
    color: #3b82f6;
    margin-right: 0.75rem;
    font-size: 1.25rem;
}
.faq-a {
    color: #475569;
    line-height: 1.7;
    margin-left: 2rem;
    margin-bottom: 0;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.tab-panel.active {
    animation: fadeIn 0.5s ease forwards;
}
</style>

<div class="tabs-container akademik-tabs beasiswa-tabs">
    <div class="akademik-tabs__nav">
        <?php foreach ($tabs as $index => $tab) : ?>
            <button
                class="tab-btn <?php echo $index === 0 ? 'active' : ''; ?>"
                type="button"
                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                data-tab="<?php echo esc_attr($tab['id']); ?>"
            >
                <?php echo esc_html($tab['label']); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="akademik-tabs__panels">
        
        <!-- Informasi Umum -->
        <div class="tab-panel active" data-panel="informasi" aria-hidden="false">
            <section class="akademik-program-section">
                <?php
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title' => 'Pusat Informasi Beasiswa JTI',
                        'icon' => 'ph-info',
                        'content' => '',
                        'class' => 'content-block--strong-title',
                    ]
                );
                ?>
                <div class="beasiswa-hero-card gutenberg-content-area">
                    <?php 
                    // Menggunakan the_content() agar user bisa memasukkan blok apapun via Gutenberg
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            $content = get_the_content();
                            if (empty(trim($content))) {
                                echo '<p>Jurusan Teknologi Informasi (JTI) Politeknik Negeri Malang menyediakan dan mengelola berbagai program beasiswa yang bertujuan untuk mendukung mahasiswa berprestasi serta membantu mahasiswa yang membutuhkan dukungan finansial.</p>';
                                echo '<p style="color:#64748b; font-size: 0.95rem; margin-top: 1rem;"><i>* Anda dapat mengedit konten bagian ini (termasuk menambahkan tabel, gambar, alur, atau PDF) secara langsung melalui editor WordPress (Gutenberg) di halaman ini.</i></p>';
                            } else {
                                the_content();
                            }
                        }
                    }
                    ?>
                </div>
            </section>
        </div>

        <!-- Jenis Beasiswa -->
        <div class="tab-panel" data-panel="jenis" aria-hidden="true">
            <section class="akademik-program-section">
                <?php
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title' => 'Jenis Beasiswa',
                        'icon' => 'ph-list-dashes',
                        'content' => '<p style="color: #64748b; margin-bottom: 1rem;">Temukan beasiswa yang paling sesuai dengan kualifikasi dan kebutuhan Anda.</p>',
                        'class' => 'content-block--strong-title',
                    ]
                );
                ?>
                
                <div class="scholarship-grid">
                    <?php 
                    if ($beasiswa_query->have_posts()) :
                        while ($beasiswa_query->have_posts()) : $beasiswa_query->the_post();
                            $b_id = get_the_ID();
                            $b_title = get_the_title();
                            $b_provider = $has_acf ? get_field('detail_provider', $b_id) : '';
                            $b_desc = $has_acf ? get_field('card_description', $b_id) : get_the_excerpt();
                            $b_icon = $has_acf && get_field('card_icon', $b_id) ? get_field('card_icon', $b_id) : 'ph-student';
                            $b_color = $has_acf && get_field('card_color', $b_id) ? get_field('card_color', $b_id) : 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
                            $b_link = get_permalink();
                    ?>
                        <a href="<?php echo esc_url($b_link); ?>" class="scholarship-card" style="--card-color: <?php echo esc_attr($b_color); ?>;">
                            <div class="scholarship-icon">
                                <i class="ph <?php echo esc_attr($b_icon); ?>"></i>
                            </div>
                            <h3 class="scholarship-title"><?php echo esc_html($b_title); ?></h3>
                            <?php if (!empty($b_provider)): ?>
                                <div class="scholarship-provider"><?php echo esc_html($b_provider); ?></div>
                            <?php endif; ?>
                            <p class="scholarship-desc"><?php echo esc_html($b_desc); ?></p>
                            <div class="scholarship-action">
                                Lihat Detail <i class="ph ph-arrow-right"></i>
                            </div>
                        </a>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    else : 
                    ?>
                        <p style="color: #64748b;">Belum ada data beasiswa yang ditambahkan. Silakan tambahkan beasiswa melalui menu "Beasiswa" di sidebar kiri Dashboard.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <!-- Persyaratan -->
        <div class="tab-panel" data-panel="syarat" aria-hidden="true">
            <section class="akademik-program-section">
                <?php
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title' => 'Persyaratan Umum',
                        'icon' => 'ph-check-circle',
                        'content' => '<p style="color: #64748b; margin-bottom: 1.5rem;">Berikut adalah beberapa persyaratan umum yang sering menjadi kriteria utama pendaftaran beasiswa.</p>',
                        'class' => 'content-block--strong-title',
                    ]
                );
                ?>
                
                <ul class="req-list">
                    <?php foreach ($requirements as $req) : ?>
                        <li class="req-item">
                            <i class="ph-check-square-offset req-icon"></i>
                            <div class="req-text"><?php echo esc_html($req); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>

        <!-- FAQ -->
        <div class="tab-panel" data-panel="faq" aria-hidden="true">
            <section class="akademik-program-section">
                <?php
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title' => 'Frequently Asked Questions (FAQ)',
                        'icon' => 'ph-question',
                        'content' => '<p style="color: #64748b; margin-bottom: 1.5rem;">Pertanyaan yang sering diajukan mengenai proses pendaftaran dan pencairan beasiswa.</p>',
                        'class' => 'content-block--strong-title',
                    ]
                );
                ?>
                
                <div class="faq-container">
                    <?php foreach ($faq as $item) : ?>
                        <div class="faq-card">
                            <h4 class="faq-q"><i class="ph-chat-circle-text"></i> <?php echo esc_html($item['q']); ?></h4>
                            <p class="faq-a"><?php echo esc_html($item['a']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

    </div>
</div>
