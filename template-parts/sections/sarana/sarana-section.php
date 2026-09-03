<?php
/**
 * Sarana dan Prasarana Section
 *
 * Queries from 'fasilitas' CPT grouped by 'kategori_fasilitas' taxonomy.
 * Includes interactive search bar header and tabbed categories.
 *
 * @package WebJTI_Theme
 */

// ── Page context ──────────────────────────────────────────────────
$page_id = get_queried_object_id() ?: get_the_ID();

$get_field = function ( $key ) use ( $page_id ) {
    if ( function_exists( 'get_field' ) ) {
        $val = get_field( $key, $page_id );
        if ( ! empty( $val ) ) {
            return $val;
        }
    }
    return get_post_meta( $page_id, $key, true );
};

// ── ACF: Page intro fields ────────────────────────────────────────
$sarana_intro_title = $get_field( 'sarana_intro_title' ) ?: 'Sarana dan Prasarana';
$sarana_intro_desc  = $get_field( 'sarana_intro_desc' )  ?: '';

// ── Build categories from 'kategori_fasilitas' taxonomy ──────────
$tax_terms = get_terms([
    'taxonomy'   => 'kategori_fasilitas',
    'hide_empty' => true,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
]);

$sarana_categories = [];

if ( ! is_wp_error( $tax_terms ) && ! empty( $tax_terms ) ) {
    foreach ( $tax_terms as $term ) {
        $fac_query = new WP_Query([
            'post_type'      => 'fasilitas',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => [[
                'taxonomy' => 'kategori_fasilitas',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ]],
            'orderby'        => 'title',
            'order'          => 'ASC',
            'no_found_rows'  => true,
        ]);

        $facilities = [];
        if ( $fac_query->have_posts() ) {
            while ( $fac_query->have_posts() ) {
                $fac_query->the_post();
                $fac_id   = get_the_ID();
                $fac_img  = get_the_post_thumbnail_url( $fac_id, 'large' ) ?: '';
                $fac_desc = function_exists( 'get_field' ) ? ( get_field( 'fasilitas_description', $fac_id ) ?: '' ) : '';
                if ( empty( $fac_desc ) ) {
                    $fac_desc = get_the_excerpt();
                }

                $facilities[] = [
                    'name'        => get_the_title(),
                    'image'       => $fac_img,
                    'description' => $fac_desc,
                ];
            }
            wp_reset_postdata();
        }

        $cat_icon = ( function_exists( 'get_field' ) ) ? get_field( 'kategori_icon', $term ) : '';
        if ( empty( $cat_icon ) ) {
            $cat_icon = get_term_meta( $term->term_id, 'kategori_icon', true ) ?: 'ph-folder';
        }

        $sarana_categories[] = [
            'tab_id'     => $term->slug,
            'tab_label'  => $term->name,
            'tab_icon'   => $cat_icon,
            'facilities' => $facilities,
        ];
    }
}

// ── Default static categories (fallback when CPT is empty) ────────
if ( empty( $sarana_categories ) ) {
    $sarana_categories = [
        [
            'tab_id'    => 'fasilitas-pembelajaran',
            'tab_label' => 'Fasilitas Pembelajaran',
            'tab_icon'  => 'ph-chalkboard-teacher',
            'facilities' => [
                ['name' => 'Ruang Kelas Reguler',       'image' => '', 'icon' => '', 'description' => 'Ruang kelas reguler JTI Polinema dilengkapi dengan kursi dan meja ergonomis, papan tulis, proyektor, serta AC untuk kenyamanan belajar mahasiswa.'],
                ['name' => 'Laboratorium Komputer',      'image' => '', 'icon' => '', 'description' => 'Laboratorium komputer JTI menyediakan komputer berperforma tinggi untuk praktikum pemrograman, jaringan, multimedia, dan keamanan siber.'],
                ['name' => 'Ruang Baca / Perpustakaan', 'image' => '', 'icon' => '', 'description' => 'Ruang baca JTI menyediakan koleksi buku teks, jurnal ilmiah, dan referensi akademik. Dilengkapi area diskusi dan akses WiFi.'],
            ],
        ],
        [
            'tab_id'    => 'fasilitas-kemahasiswaan',
            'tab_label' => 'Fasilitas Kemahasiswaan',
            'tab_icon'  => 'ph-users-three',
            'facilities' => [
                ['name' => 'Ruang Himpunan Mahasiswa', 'image' => '', 'icon' => '', 'description' => 'Ruang sekretariat himpunan mahasiswa untuk kegiatan organisasi, rapat, dan koordinasi UKM di lingkungan JTI Polinema.'],
                ['name' => 'Aula Serbaguna',           'image' => '', 'icon' => '', 'description' => 'Aula JTI digunakan untuk seminar, workshop, wisuda, dan kegiatan kemahasiswaan. Berkapasitas ratusan peserta dengan audio-visual memadai.'],
            ],
        ],
        [
            'tab_id'    => 'fasilitas-penunjang',
            'tab_label' => 'Fasilitas Penunjang',
            'tab_icon'  => 'ph-buildings',
            'facilities' => [
                ['name' => 'Kantin dan Area Makan', 'image' => '', 'icon' => '', 'description' => 'Kantin JTI menyediakan berbagai pilihan makanan dan minuman terjangkau untuk mahasiswa, dosen, dan staf.'],
                ['name' => 'Area Parkir',            'image' => '', 'icon' => '', 'description' => 'JTI Polinema menyediakan area parkir luas dan aman untuk kendaraan roda dua maupun roda empat.'],
                ['name' => 'Musholla',               'image' => '', 'icon' => '', 'description' => 'Fasilitas musholla tersedia untuk memenuhi kebutuhan ibadah civitas akademika JTI dengan suasana bersih dan nyaman.'],
            ],
        ],
        [
            'tab_id'    => 'fasilitas-sistem-informasi',
            'tab_label' => 'Fasilitas Sistem Informasi',
            'tab_icon'  => 'ph-monitor',
            'facilities' => [
                ['name' => 'Server Center',       'image' => '', 'icon' => '', 'description' => 'Pusat data JTI dengan infrastruktur server handal untuk menunjang kegiatan akademik digital dan layanan e-learning.'],
                ['name' => 'Jaringan WiFi Kampus','image' => '', 'icon' => '', 'description' => 'Seluruh area kampus JTI terjangkau WiFi berkecepatan tinggi untuk seluruh civitas akademika.'],
            ],
        ],
        [
            'tab_id'    => 'fasilitas-disabilitas',
            'tab_label' => 'Fasilitas Disabilitas',
            'tab_icon'  => 'ph-wheelchair',
            'facilities' => [
                ['name' => 'Akses Ramp dan Lift',  'image' => '', 'icon' => '', 'description' => 'Gedung JTI dilengkapi ramp dan lift untuk memudahkan akses bagi mahasiswa berkebutuhan khusus.'],
                ['name' => 'Toilet Disabilitas',   'image' => '', 'icon' => '', 'description' => 'Toilet khusus disabilitas tersedia di setiap lantai gedung utama JTI untuk kesetaraan akses.'],
            ],
        ],
    ];
}

$content_kses = wp_kses_allowed_html( 'post' );
?>

<section class="sarana-section" id="sarana-prasarana">

    <!-- ============================================================
         HEADER TOOLBAR WITH SEARCH
    ============================================================ -->
    <div class="sarana-section__header">
        <div class="sarana-section__header-text">
            <h1 class="sarana-section__page-title">
                <?php echo esc_html( $sarana_intro_title ); ?>
            </h1>
            <?php if ( $sarana_intro_desc ) : ?>
                <p class="sarana-section__intro-desc">
                    <?php echo esc_html( $sarana_intro_desc ); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="search-toolbar sarana-search-toolbar">
            <i class="ph ph-magnifying-glass" aria-hidden="true"></i>
            <input
                type="text"
                id="sarana-search-input"
                class="search-input"
                placeholder="<?php esc_attr_e( 'Cari fasilitas...', 'webjti-theme' ); ?>"
                autocomplete="off"
            />
        </div>
    </div><!-- .sarana-section__header -->

    <!-- ============================================================
         CATEGORY TABS
    ============================================================ -->
    <div class="sarana-section__tabs-wrapper" role="navigation" aria-label="Kategori Fasilitas">
        <div class="sarana-section__tabs" role="tablist">
            <?php foreach ( $sarana_categories as $cat_index => $cat ) :
                $cat_id    = sanitize_html_class( $cat['tab_id'] );
                $cat_label = esc_html( $cat['tab_label'] );
                $cat_icon  = esc_attr( $cat['tab_icon'] ?? 'ph-folder' );
                $is_active = ( $cat_index === 0 );
            ?>
                <button
                    class="sarana-section__tab <?php echo $is_active ? 'is-active' : ''; ?>"
                    role="tab"
                    id="tab-btn-<?php echo esc_attr( $cat_id ); ?>"
                    aria-controls="tab-panel-<?php echo esc_attr( $cat_id ); ?>"
                    aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                    data-target="<?php echo esc_attr( $cat_id ); ?>"
                    type="button"
                >
                    <i class="ph-fill <?php echo $cat_icon; ?>" aria-hidden="true"></i>
                    <span><?php echo $cat_label; ?></span>
                </button>
            <?php endforeach; ?>
        </div><!-- .sarana-section__tabs -->
    </div><!-- .sarana-section__tabs-wrapper -->

    <!-- ============================================================
         TAB PANELS
    ============================================================ -->
    <div class="sarana-section__panels">
        <?php foreach ( $sarana_categories as $cat_index => $cat ) :
            $cat_id     = sanitize_html_class( $cat['tab_id'] );
            $is_active  = ( $cat_index === 0 );
            $facilities = $cat['facilities'] ?? [];
        ?>
            <div
                class="sarana-section__panel <?php echo $is_active ? 'is-active' : ''; ?>"
                id="tab-panel-<?php echo esc_attr( $cat_id ); ?>"
                role="tabpanel"
                aria-labelledby="tab-btn-<?php echo esc_attr( $cat_id ); ?>"
                <?php echo ! $is_active ? 'hidden' : ''; ?>
            >
                <?php if ( ! empty( $facilities ) ) : ?>
                    <ul class="sarana-section__facility-list">
                        <?php foreach ( $facilities as $fac ) :
                            $fac_name = $fac['name'] ?? '';
                            $fac_img  = $fac['image'] ?? '';
                            $fac_desc = $fac['description'] ?? '';
                        ?>
                            <li class="sarana-section__facility-item">

                                <?php if ( $fac_img ) : ?>
                                    <div class="sarana-section__facility-image-wrap">
                                        <img
                                            src="<?php echo esc_url( $fac_img ); ?>"
                                            alt="<?php echo esc_attr( $fac_name ); ?>"
                                            class="sarana-section__facility-image gallery-item"
                                            data-full="<?php echo esc_url( $fac_img ); ?>"
                                            loading="lazy"
                                            decoding="async"
                                            style="cursor: pointer;"
                                        />
                                    </div>
                                <?php else : ?>
                                    <div class="sarana-section__facility-image-wrap sarana-section__facility-image-wrap--placeholder">
                                        <div class="sarana-section__facility-placeholder">
                                            <i class="ph ph-image" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="sarana-section__facility-body">
                                    <?php if ( $fac_name ) : ?>
                                        <h3 class="sarana-section__facility-name">
                                            <?php echo esc_html( $fac_name ); ?>
                                        </h3>
                                    <?php endif; ?>
                                    <?php if ( $fac_desc ) : ?>
                                        <div class="sarana-section__facility-desc">
                                            <?php echo wp_kses( $fac_desc, $content_kses ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div><!-- .sarana-section__facility-body -->

                            </li><!-- .sarana-section__facility-item -->
                        <?php endforeach; ?>
                    </ul><!-- .sarana-section__facility-list -->
                <?php else : ?>
                    <p class="sarana-section__empty">
                        <?php esc_html_e( 'Belum ada data fasilitas untuk kategori ini.', 'webjti-theme' ); ?>
                    </p>
                <?php endif; ?>
            </div><!-- .sarana-section__panel -->
        <?php endforeach; ?>
    </div><!-- .sarana-section__panels -->

</section><!-- .sarana-section -->

<!-- Premium Lightbox Modal for Sarana -->
<div id="sarana-lightbox" class="gallery-lightbox" aria-hidden="true">
  <div class="lightbox-overlay" onclick="closeSaranaLightbox()"></div>
  <span class="lightbox-close" onclick="closeSaranaLightbox()">&times;</span>
  <img id="sarana-lightbox-img" class="lightbox-content" src="" alt="Zoomed Fasilitas">
  
  <div class="prev" onclick="prevSaranaImage()"><i class="ph ph-caret-left"></i></div>
  <div class="next" onclick="nextSaranaImage()"><i class="ph ph-caret-right"></i></div>
</div>

<script>
let currentSaranaImages = [];
let currentSaranaIndex = 0;

function openSaranaLightbox(index) {
    const lightbox = document.getElementById('sarana-lightbox');
    const img = document.getElementById('sarana-lightbox-img');
    if (!lightbox || !img) return;
    
    currentSaranaIndex = index;
    img.src = currentSaranaImages[index];
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeSaranaLightbox() {
    const lightbox = document.getElementById('sarana-lightbox');
    if (lightbox) {
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
}

function prevSaranaImage() {
    if (currentSaranaImages.length === 0) return;
    currentSaranaIndex = (currentSaranaIndex - 1 + currentSaranaImages.length) % currentSaranaImages.length;
    document.getElementById('sarana-lightbox-img').src = currentSaranaImages[currentSaranaIndex];
}

function nextSaranaImage() {
    if (currentSaranaImages.length === 0) return;
    currentSaranaIndex = (currentSaranaIndex + 1) % currentSaranaImages.length;
    document.getElementById('sarana-lightbox-img').src = currentSaranaImages[currentSaranaIndex];
}

document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.sarana-section__facility-image.gallery-item');
    currentSaranaImages = Array.from(items).map(img => img.getAttribute('data-full'));
    
    items.forEach((item, index) => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openSaranaLightbox(index);
        });
    });
});
</script>

<script>
(function () {
    'use strict';
    var tabs        = document.querySelectorAll('.sarana-section__tab');
    var panels      = document.querySelectorAll('.sarana-section__panel');
    var searchInput = document.getElementById('sarana-search-input');
    var activeTabTarget = tabs.length ? tabs[0].dataset.target : '';

    function activateTab(btn) {
        activeTabTarget = btn.dataset.target;
        tabs.forEach(function (t) {
            var on = (t.dataset.target === activeTabTarget);
            t.classList.toggle('is-active', on);
            t.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        if (!searchInput || !searchInput.value.trim()) {
            panels.forEach(function (p) {
                var on = (p.id === 'tab-panel-' + activeTabTarget);
                p.classList.toggle('is-active', on);
                if (on) { p.removeAttribute('hidden'); }
                else    { p.setAttribute('hidden', ''); }
            });
        }
    }

    tabs.forEach(function (btn) {
        btn.addEventListener('click', function () { activateTab(btn); });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var query = this.value.trim().toLowerCase();

            if (query === '') {
                tabs.forEach(function (t) {
                    var on = (t.dataset.target === activeTabTarget);
                    t.classList.toggle('is-active', on);
                });
                panels.forEach(function (p) {
                    var on = (p.id === 'tab-panel-' + activeTabTarget);
                    p.classList.toggle('is-active', on);
                    if (on) { p.removeAttribute('hidden'); }
                    else    { p.setAttribute('hidden', ''); }
                    p.querySelectorAll('.sarana-section__facility-item').forEach(function(item) {
                        item.style.display = '';
                    });
                });
                return;
            }

            panels.forEach(function (p) {
                var items = p.querySelectorAll('.sarana-section__facility-item');
                var matchCount = 0;

                items.forEach(function (item) {
                    var text = item.textContent.toLowerCase();
                    if (text.indexOf(query) !== -1) {
                        item.style.display = '';
                        matchCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (matchCount > 0) {
                    p.classList.add('is-active');
                    p.removeAttribute('hidden');
                } else {
                    p.classList.remove('is-active');
                    p.setAttribute('hidden', '');
                }
            });
        });
    }
})();
</script>
