<?php

$title =
  $args['title'] ?? '';

$items =
  $args['items'] ?? [];

$current_slug =
  $args['current_slug'] ?? '';

?>

<div class="sidebar-group">

    <h4 class="sidebar-group-title">

        <?php echo esc_html($title); ?>

    </h4>

    <ul class="sidebar-menu-list">

        <?php foreach ($items as $item) : ?>

            <?php
            get_template_part(
                'template-parts/components/sidebar/sidebar-item',
                null,
                [
                    'item' => $item,
                    'current_slug' => $current_slug,
                ]
            );
            ?>

        <?php endforeach; ?>

    </ul>

</div>