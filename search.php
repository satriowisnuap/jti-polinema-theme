<?php
/**
 * Search Results Template
 *
 * @package WebJTI_Theme
 */

get_header();

// Get the search query
$search_query = get_search_query();
?>

<main id="primary" class="site-main search-page">

    <?php
    /*
    ==================================================
    PAGE HEADER
    ==================================================
    */
    get_template_part(
        'template-parts/components/page-header'
    );
    ?>

    <div class="container container--wide">

        <div class="page-layout with-sidebar">

            <?php
            /*
            ==================================================
            SIDEBAR NAVIGATION
            ==================================================
            */
            get_template_part(
                'template-parts/components/sidebar/sidebar'
            );
            ?>

            <div class="page-content search-page-content">

                <div class="search-results-info" style="margin-bottom: 24px; color: var(--neutral-06); font-size: var(--b3-size);">
                    <?php
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    echo sprintf(
                        esc_html( _n( 'Ditemukan %d hasil pencarian yang cocok.', 'Ditemukan %d hasil pencarian yang cocok.', $total_results, 'webjti' ) ),
                        $total_results
                    );
                    ?>
                </div>

                <?php if ( have_posts() ) : ?>

                    <div class="information-filtered-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 32px; margin-bottom: 40px;">

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php
                            $post_type = get_post_type();
                            $post_type_label = '';

                            // Resolve human-readable post type labels
                            if ( 'lecturer' === $post_type ) {
                                $post_type_label = 'Tenaga Pengajar';
                            } elseif ( 'staff' === $post_type ) {
                                $post_type_label = 'Tenaga Kependidikan';
                            } elseif ( 'information' === $post_type ) {
                                $category_value = function_exists('get_field') ? get_field('category') : '';
                                if ( 'announcement' === $category_value ) {
                                    $post_type_label = 'Pengumuman';
                                } elseif ( 'event' === $category_value ) {
                                    $post_type_label = 'Agenda';
                                } else {
                                    $post_type_label = 'Berita';
                                }
                            } elseif ( 'page' === $post_type ) {
                                $post_type_label = 'Halaman';
                            } elseif ( 'post' === $post_type ) {
                                $post_type_label = 'Artikel';
                            } else {
                                $post_type_obj = get_post_type_object( $post_type );
                                $post_type_label = $post_type_obj ? $post_type_obj->labels->singular_name : 'Konten';
                            }

                            // Estimate reading time dynamically
                            $content = get_the_content();
                            $word_count = str_word_count( strip_tags( $content ) );
                            $reading_time = ceil( $word_count / 200 );
                            if ( $reading_time < 1 ) {
                                $reading_time = 1;
                            }

                            // Resolve image
                            $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
                            if ( ! $image_url ) {
                                $image_url = get_template_directory_uri() . '/assets/images/placeholders/page-header.jpg';
                            }

                            // Resolve excerpt
                            $excerpt = get_the_excerpt();
                            if ( empty( $excerpt ) ) {
                                $excerpt = wp_trim_words( strip_tags( get_the_content() ), 18, '...' );
                            }

                            $info = [
                                'url'          => get_permalink(),
                                'image'        => $image_url,
                                'title'        => get_the_title(),
                                'category'     => $post_type_label,
                                'date'         => get_the_date(),
                                'reading_time' => $reading_time,
                                'excerpt'      => $excerpt,
                            ];

                            get_template_part(
                                'template-parts/cards/information-card',
                                null,
                                [
                                    'info' => $info,
                                ]
                            );
                            ?>

                        <?php endwhile; ?>

                    </div>

                    <!-- Pagination -->
                    <div class="information-pagination-box" style="margin-top: 40px;">
                        <div class="pagination-container">
                            <?php
                            echo paginate_links([
                                'prev_next' => true,
                                'prev_text' => '<i class="ph ph-arrow-left"></i> Sebelumnya',
                                'next_text' => 'Selanjutnya <i class="ph ph-arrow-right"></i>',
                                'type'      => 'plain',
                            ]);
                            ?>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="information-no-results" style="text-align: center; padding: 80px 24px;">
                        <i class="ph ph-magnifying-glass-x" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;"></i>
                        <h3 style="color: var(--neutral-09); margin-bottom: 12px; font-weight: 500; font-size: 22px;">Tidak Ada Hasil Pencarian</h3>
                        <p style="color: var(--neutral-06); font-size: 16px; max-width: 480px; margin: 0 auto 24px auto; line-height: 1.5;">
                            Maaf, kami tidak menemukan data atau halaman yang sesuai dengan kata kunci pencarian &ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;. Silakan coba dengan kata kunci lain.
                        </p>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary" style="display: inline-flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-house"></i>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>

                <?php endif; ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php
get_footer();
