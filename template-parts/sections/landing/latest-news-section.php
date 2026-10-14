<?php
/**
 * Latest News / Information Section
 */

$news_data = webjti_get_information_posts();
$spotlight = $news_data['spotlight'];
$posts     = $news_data['posts'];

// If no posts at all, don't show the section.
if ( ! $spotlight && empty( $posts ) ) {
    return;
}

$badge_text = get_theme_mod('jti_info_badge_text', 'Informasi');
if (empty(trim($badge_text))) {
    $badge_text = 'Informasi';
}

$title_text = get_theme_mod('jti_info_title_text', 'Berita Terkini dan Informasi Menarik dari Kampus');
if (empty(trim($title_text))) {
    $title_text = 'Berita Terkini dan Informasi Menarik dari Kampus';
}

?>

<section class="information-section" id="informasi" aria-labelledby="information-heading">
    <div class="container container--wide">
        
        <header class="information-header">
            <div class="badge-section">
                <span class="badge-section-text"><?php echo esc_html($badge_text); ?></span>
            </div>
            <h2 id="information-heading" class="information-title">
                <?php echo nl2br(esc_html($title_text)); ?>
            </h2>
        </header>

        <div class="information-grid">
            
            <?php if ( $spotlight ) : ?>
                <article class="information-spotlight">
                    <a href="<?php echo esc_url( $spotlight['permalink'] ); ?>" class="information-spotlight-link">
                        <div class="information-spotlight-image-wrapper">
                            <img src="<?php echo esc_url( $spotlight['image'] ); ?>" alt="" class="information-spotlight-image" loading="lazy">
                            <div class="information-spotlight-overlay">
                                <span class="information-spotlight-overlay-text"><?php esc_html_e( 'SPOTLIGHT', 'webjti' ); ?></span>
                            </div>
                        </div>
                        <div class="information-spotlight-content">
                            <span class="information-tag"><?php echo esc_html( strtoupper( $spotlight['category'] ) ); ?></span>
                            <h3 class="information-spotlight-title"><?php echo esc_html( $spotlight['title'] ); ?></h3>
                            <p class="information-spotlight-excerpt"><?php echo esc_html( $spotlight['excerpt'] ); ?></p>
                            <div class="information-meta">
                                <span class="information-meta-item">
                                    <i class="ph ph-calendar-blank" aria-hidden="true"></i> 
                                    <?php echo esc_html( $spotlight['date'] ); ?>
                                </span>
                                <span class="information-meta-item">
                                    <i class="ph ph-clock" aria-hidden="true"></i> 
                                    <?php echo esc_html( $spotlight['reading_time'] ); ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endif; ?>

            <?php if ( ! empty( $posts ) ) : ?>
                <div class="information-list">
                    <?php foreach ( $posts as $index => $item ) : ?>
                        <article class="information-card">
                            <a href="<?php echo esc_url( $item['permalink'] ); ?>" class="information-card-link">
                                <div class="information-card-image-wrapper">
                                    <img src="<?php echo esc_url( $item['image'] ); ?>" alt="" class="information-card-image" loading="lazy">
                                </div>
                                <div class="information-card-content">
                                    <span class="information-tag"><?php echo esc_html( strtoupper( $item['category'] ) ); ?></span>
                                    <h3 class="information-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
                                    <div class="information-meta">
                                        <span class="information-meta-item">
                                            <i class="ph ph-calendar-blank" aria-hidden="true"></i> 
                                            <?php echo esc_html( $item['date'] ); ?>
                                        </span>
                                        <span class="information-meta-item">
                                            <i class="ph ph-clock" aria-hidden="true"></i> 
                                            <?php echo esc_html( $item['reading_time'] ); ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        
                        <?php if ( $index < count( $posts ) - 1 ) : ?>
                            <div class="information-divider" aria-hidden="true"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

        <footer class="information-footer">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'information' ) ?: home_url('/informasi') ); ?>" class="btn btn-outline">
                <?php esc_html_e( 'Lihat Selengkapnya', 'webjti' ); ?>
            </a>
        </footer>

    </div>
</section>
