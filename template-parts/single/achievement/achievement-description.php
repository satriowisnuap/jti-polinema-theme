<?php
/**
 * Achievement Description Block
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;

if (!$achievement) {
    return;
}

$description = $achievement['deskripsi'] ?? '';

if (empty($description)) {
  return;
}

ob_start();
?>

<div class="achievement-description">
  <?php echo wpautop($description); ?>
</div>

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' => 'Deskripsi Kompetisi',
    'icon' => 'ph-text-aa',
    'content' => $content,
  ]
);