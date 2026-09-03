<?php
/**
 * Jurnal Section
 *
 * Displays journal (JIP) information with cover image, description,
 * and a link to the journal website.
 *
 * @package WebJTI_Theme
 */

// Fetch ACF fields (if available) or fall back to defaults
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

// ── Dynamic fields ────────────────────────────────────────────────
$jurnal_title           = $get_field( 'jurnal_title' )           ?: 'JIP (Jurnal Informatika Polinema)';
$jurnal_issn_print      = $get_field( 'jurnal_issn_print' )      ?: '2614-6371';
$jurnal_issn_online     = $get_field( 'jurnal_issn_online' )     ?: '2407-070X';
$jurnal_sidebar_content = $get_field( 'jurnal_sidebar_content' ) ?: '';
$jurnal_website_url     = $get_field( 'jurnal_website_url' )     ?: 'https://jurnal.polinema.ac.id/index.php/jip/';
$jurnal_sinta_url       = $get_field( 'jurnal_sinta_url' )       ?: 'https://sinta.kemdikbud.go.id/journals/';
$jurnal_cta_text        = $get_field( 'jurnal_cta_text' )        ?: 'Klik disini untuk Informasi lebih Lengkapnya';

// ── Image Selection Hierarchy: Featured Image -> ACF Image -> Default Asset ──
$jurnal_cover_url = '';

if ( has_post_thumbnail( $page_id ) ) {
    $jurnal_cover_url = get_the_post_thumbnail_url( $page_id, 'full' );
}

if ( empty( $jurnal_cover_url ) ) {
    $acf_cover = $get_field( 'jurnal_cover_image' );
    if ( is_array( $acf_cover ) && ! empty( $acf_cover['url'] ) ) {
        $jurnal_cover_url = $acf_cover['url'];
    } elseif ( is_numeric( $acf_cover ) ) {
        $jurnal_cover_url = wp_get_attachment_image_url( $acf_cover, 'full' );
    } elseif ( is_string( $acf_cover ) && ! empty( $acf_cover ) ) {
        $jurnal_cover_url = $acf_cover;
    }
}

if ( empty( $jurnal_cover_url ) ) {
    $jurnal_cover_url = get_template_directory_uri() . '/assets/images/jurnal-jip-cover.png';
}

// ── Default description ────────────────
$default_description =
    '<p><strong>JIP (Jurnal Informatika Polinema)</strong> dimaksudkan sebagai sarana bagi para peneliti, akademisi, dan praktisi untuk mempublikasikan hasil atau temuan penelitian, konsep, dan gagasan terkini mengenai Pengembangan Aplikasi Teknologi Informasi.</p>' .
    '<p>JIP saat ini terakreditasi <strong>SINTA 4</strong> dengan keputusan ' .
        '<a href="' . esc_url( $jurnal_sinta_url ) . '" target="_blank" rel="noopener">SK Kemenristekdikti Nomor 28/E/KPT/2019</a>' .
        ' dan terindeks secara internasional oleh Google Scholar, Dimensions, BASE dan Crossref.</p>' .
    '<p>Jurnal ini terbit 4 kali dalam setahun, bulan terbitnya artikel:</p>' .
    '<ul>' .
        '<li>No. 1. November</li>' .
        '<li>No. 2. February</li>' .
        '<li>No. 3. May</li>' .
        '<li>No. 4. August</li>' .
    '</ul>' .
    '<p>Artikel yang diterbitkan melalui proses tinjauan buta tunggal dan pemeriksa plagiarisme (batas kesamaan maksimum 20%).</p>' .
    '<p>Jurnal ini menggunakan Kebijakan Pengarsipan Digital: Jaringan Pelestarian Proyek Pengetahuan Publik (PKP PN).</p>';

$description = $default_description;

$content_allowed = wp_kses_allowed_html( 'post' );
?>

<section class="jurnal-section">

    <!-- ============================================================
         PAGE HEADER BLOCK
    ============================================================ -->
    <div class="jurnal-section__header">

        <div class="jurnal-section__header-icon">
            <i class="ph-fill ph-book-open" aria-hidden="true"></i>
        </div>

        <div class="jurnal-section__header-text">
            <h1 class="jurnal-section__page-title">
                <?php echo esc_html( $jurnal_title ); ?>
            </h1>
        </div>

    </div><!-- .jurnal-section__header -->

    <!-- ============================================================
         MAIN CONTENT CARD
    ============================================================ -->
    <div class="jurnal-section__card">

        <!-- Left: Description -->
        <div class="jurnal-section__description">
            <?php echo wp_kses( $description, $content_allowed ); ?>
        </div><!-- .jurnal-section__description -->

        <!-- Right: Cover Image + ISSN badges + Custom Sidebar Content -->
        <aside class="jurnal-section__cover-wrap" aria-label="Cover Jurnal">

            <a
                href="<?php echo esc_url( $jurnal_website_url ); ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="jurnal-section__cover-link"
                title="<?php echo esc_attr( $jurnal_title ); ?>"
            >
                <figure class="jurnal-section__cover-figure">
                    <img
                        src="<?php echo esc_url( $jurnal_cover_url ); ?>"
                        alt="<?php echo esc_attr( 'Cover ' . $jurnal_title ); ?>"
                        class="jurnal-section__cover-image"
                        loading="lazy"
                        decoding="async"
                    />
                </figure>
            </a>

            <!-- ISSN Badges -->
            <?php if ( $jurnal_issn_print || $jurnal_issn_online ) : ?>
                <div class="jurnal-section__issn-group">

                    <?php if ( $jurnal_issn_print ) : ?>
                        <div class="jurnal-section__issn-item">
                            <span class="jurnal-section__issn-label">ISSN:</span>
                            <span class="jurnal-section__issn-value">
                                <?php echo esc_html( $jurnal_issn_print ); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ( $jurnal_issn_online ) : ?>
                        <div class="jurnal-section__issn-item">
                            <span class="jurnal-section__issn-label">E-ISSN:</span>
                            <span class="jurnal-section__issn-value">
                                <?php echo esc_html( $jurnal_issn_online ); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                </div><!-- .jurnal-section__issn-group -->
            <?php endif; ?>

            <!-- Custom Content Below JIP Cover / ISSN -->
            <?php if ( ! empty( $jurnal_sidebar_content ) ) : ?>
                <div class="jurnal-section__sidebar-custom-content">
                    <?php echo wp_kses( $jurnal_sidebar_content, $content_allowed ); ?>
                </div>
            <?php endif; ?>

        </aside><!-- .jurnal-section__cover-wrap -->

    </div><!-- .jurnal-section__card -->

    <!-- ============================================================
         CTA BUTTON
    ============================================================ -->
    <div class="jurnal-section__cta">
        <a
            href="<?php echo esc_url( $jurnal_website_url ); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="btn jurnal-section__cta-btn"
            id="jurnal-cta-button"
        >
            <i class="ph ph-arrow-square-out" aria-hidden="true"></i>
            <?php echo esc_html( $jurnal_cta_text ); ?>
        </a>
    </div><!-- .jurnal-section__cta -->

</section><!-- .jurnal-section -->
