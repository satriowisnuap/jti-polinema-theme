<?php

$tabs =
  $args['tabs'] ?? [];

$active =
  $args['active'] ?? '';

if (empty($tabs)) {
  return;
}

?>

<div class="segmented-tabs">

  <?php foreach ($tabs as $tab) : ?>

    <button
      class="
        segmented-tabs__button
        <?php echo $tab['id'] === $active ? 'is-active' : ''; ?>
      "
      data-tab="<?php echo esc_attr($tab['id']); ?>"
      type="button"
    >

      <?php
      echo esc_html($tab['label']);
      ?>

    </button>

  <?php endforeach; ?>

</div>