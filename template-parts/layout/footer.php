<?php
/**
 * Footer Layout Template
 *
 * @package WebJTI_Theme
 */
?>
<footer id="colophon" class="site-footer">
  <div class="ft-body">
    <div class="container container--wide ft-container">
      <?php
      get_template_part(
        'template-parts/footer/footer-brand'
      );
      ?>

      <?php
      get_template_part(
        'template-parts/footer/footer-navigation'
      );
      ?>

      <?php
      get_template_part(
        'template-parts/footer/footer-social'
      );
      ?>
    </div>
  </div>

  <?php
  get_template_part(
    'template-parts/footer/footer-bottom'
  );
  ?>
</footer>