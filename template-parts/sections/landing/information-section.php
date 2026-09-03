<?php

$data =
  webjti_get_information_posts();

$spotlight =
  $data['spotlight'];

$posts =
  $data['posts'];

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
    <div class="section-header">
      <div class="badge badge--section">
        <?php echo esc_html($badge_text); ?>
      </div>
      <h2 class="section-title">
        <?php echo nl2br(esc_html($title_text)); ?>
      </h2>
    </div>

    <div class="information-grid">
      
      <!-- SPOTLIGHT (Left side) -->
      <?php
      get_template_part(
        'template-parts/cards/information-spotlight-card',
        null,
        [
          'spotlight' => $spotlight,
        ]
      );
      ?>

      <!-- LIST POSTS (Right side) -->
      <div class="information-list">
        <?php foreach ($posts as $index => $item) : ?>
          <?php
          get_template_part(
            'template-parts/cards/information-list-card',
            null,
            [
              'item' => $item,
              'show_divider' => $index < count($posts) - 1,
            ]
          );
          ?>
        <?php endforeach; ?>
      </div>

    </div>

    <?php
    $info_page_id = get_theme_mod('jti_page_informasi');
    $info_page_link = $info_page_id ? get_permalink($info_page_id) : site_url('/information');
    ?>
    <div class="information-footer">
      <a href="<?php echo esc_url($info_page_link); ?>" class="btn btn--outline">
        Lihat Selengkapnya
      </a>
    </div>
</section>
