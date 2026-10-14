<?php

$post =
  $args['post'] ?? null;

if (!$post) {
  return;
}

?>

<article class="news-card">

  <a
    href="<?php echo esc_url($post['permalink']); ?>"
    class="news-card__image-link"
    aria-label="<?php echo esc_attr($post['title']); ?>"
  >

    <img
      src="<?php echo esc_url($post['image']); ?>"
      alt="<?php echo esc_attr($post['title']); ?>"
      class="news-card__image"
      loading="lazy"
    >

  </a>

  <div class="news-card__content">

    <div class="news-card__meta">

      <span class="news-card__category">

        <?php
        echo esc_html($post['category']);
        ?>

      </span>

      <span class="news-card__dot"></span>

      <time
        datetime="<?php echo esc_attr(get_the_date('c', $post['id'])); ?>"
      >

        <?php
        echo esc_html($post['date']);
        ?>

      </time>

      <span class="news-card__dot"></span>

      <span class="news-card__reading-time">

        <?php
        echo esc_html($post['reading_time']);
        ?>

      </span>

    </div>

    <h3 class="news-card__title">

      <a href="<?php echo esc_url($post['permalink']); ?>">

        <?php
        echo esc_html($post['title']);
        ?>

      </a>

    </h3>

    <p class="news-card__excerpt">

      <?php
      echo esc_html($post['excerpt']);
      ?>

    </p>

  </div>

</article>