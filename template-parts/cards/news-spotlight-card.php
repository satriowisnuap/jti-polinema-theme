<?php

$post =
  $args['post'] ?? null;

if (!$post) {
  return;
}

?>

<article class="news-spotlight-card">

  <a
    href="<?php echo esc_url($post['permalink']); ?>"
    class="news-spotlight-card__image-link"
    aria-label="<?php echo esc_attr($post['title']); ?>"
  >

    <img
      src="<?php echo esc_url($post['image']); ?>"
      alt="<?php echo esc_attr($post['title']); ?>"
      class="news-spotlight-card__image"
      loading="lazy"
    >

  </a>

  <div class="news-spotlight-card__content">

    <div class="news-spotlight-card__meta">

      <span class="news-spotlight-card__category">

        <?php
        echo esc_html($post['category']);
        ?>

      </span>

      <span class="news-spotlight-card__dot"></span>

      <time
        datetime="<?php echo esc_attr(get_the_date('c', $post['id'])); ?>"
      >

        <?php
        echo esc_html($post['date']);
        ?>

      </time>

      <span class="news-spotlight-card__dot"></span>

      <span class="news-spotlight-card__reading-time">

        <?php
        echo esc_html($post['reading_time']);
        ?>

      </span>

    </div>

    <h2 class="news-spotlight-card__title">

      <a href="<?php echo esc_url($post['permalink']); ?>">

        <?php
        echo esc_html($post['title']);
        ?>

      </a>

    </h2>

    <p class="news-spotlight-card__excerpt">

      <?php
      echo esc_html($post['excerpt']);
      ?>

    </p>

    <a
      href="<?php echo esc_url($post['permalink']); ?>"
      class="news-spotlight-card__button"
      aria-label="<?php echo esc_attr(
        sprintf(
          __('Baca selengkapnya: %s', 'webjti'),
          $post['title']
        )
      ); ?>"
    >

      <?php
      esc_html_e(
        'Baca Selengkapnya',
        'webjti'
      );
      ?>

      <i class="ph ph-arrow-up-right"></i>

    </a>

  </div>

</article>