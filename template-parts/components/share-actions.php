<?php
/**
 * Share Actions
 *
 * @package WebJTI_Theme
 */

?>

<div class="share-actions">

  <span class="share-actions__title">

    Bagikan

  </span>

  <div class="share-actions__list">

    <a
      href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>"
      target="_blank"
      class="share-actions__button"
    >

      <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/x.png"
        alt="X"
      >

    </a>

    <a
      href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
      target="_blank"
      class="share-actions__button"
    >

      <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/facebook.png"
        alt="Facebook"
      >

    </a>

    <a
      href="https://api.whatsapp.com/send?text=<?php the_title(); ?>%20<?php the_permalink(); ?>"
      target="_blank"
      class="share-actions__button"
    >

      <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/whatsapp.png"
        alt="WhatsApp"
      >

    </a>

    <button
      class="share-actions__button"
      onclick="WebJTI.utils.copyToClipboard('<?php the_permalink(); ?>', this)"
    >

      <i class="ph ph-link"></i>

    </button>

  </div>

</div>