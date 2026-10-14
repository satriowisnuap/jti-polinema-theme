<?php
/**
 * Shared Content Block
 *
 * Reusable content section block.
 *
 * @package WebJTI_Theme
 */

$title = $args['title'] ?? '';
$content = $args['content'] ?? '';
$icon = $args['icon'] ?? 'ph-book-open';
$section_slug = $args['section_slug'] ?? '';
$class = trim($args['class'] ?? '');
$block_classes = array_filter([
  'content-block',
  $class
]);
$block_class = implode(' ', $block_classes);

// Helper to sanitize titles into slugs (e.g. "Visi Jurusan" -> "visi-jurusan")
$sanitize_slug = function($str) {
  $str = strtolower($str);
  $str = preg_replace('/[^a-z0-9\-]/', '-', $str);
  $str = preg_replace('/-+/', '-', $str);
  return trim($str, '-');
};

// If no explicit section_slug is passed, automatically derive it from the default title
if (empty($section_slug) && !empty($title)) {
  $section_slug = $sanitize_slug($title);
}

// Automatically enable title and icon overrides if a section slug is defined or derived
$allow_custom_title = $args['allow_custom_title'] ?? (!empty($section_slug));
$allow_custom_icon = $args['allow_custom_icon'] ?? (!empty($section_slug));

// Helper to fetch custom field value from meta or ACF (immune to loop pollution)
$get_custom_field_value = function($field_key) {
  $page_id = get_queried_object_id() ?: get_the_ID();
  $val = get_post_meta($page_id, $field_key, true);
  if (empty($val) && function_exists('get_field')) {
    $val = get_field($field_key, $page_id);
  }
  return $val;
};

// 1. Resolve Dynamic Title (Isolated by Section Slug)
if ($allow_custom_title && !empty($section_slug)) {
  $slug_variations = [
    $section_slug,
    str_replace('-', '_', $section_slug)
  ];
  
  // Add common dynamic field prefixes for the Sejarah section to avoid key mismatches
  if ($section_slug === 'sejarah-kami' || $section_slug === 'sejarah') {
    $slug_variations[] = 'history_content';
    $slug_variations[] = 'history-content';
    $slug_variations[] = 'sejarah';
    $slug_variations[] = 'history';
  }
  
  $custom_title = '';
  foreach ($slug_variations as $slug_var) {
    $custom_title = $get_custom_field_value($slug_var . '_title');
    if (!empty($custom_title)) {
      break;
    }
  }
  
  if (!empty($custom_title)) {
    $title = $custom_title;
  }
}

// 2. Resolve Dynamic Icon (Isolated by Section Slug)
if ($allow_custom_icon) {
  $custom_icon = '';
  
  if (!empty($section_slug)) {
    $slug_variations = [
      $section_slug,
      str_replace('-', '_', $section_slug)
    ];
    
    if ($section_slug === 'sejarah-kami' || $section_slug === 'sejarah') {
      $slug_variations[] = 'history_content';
      $slug_variations[] = 'history-content';
      $slug_variations[] = 'sejarah';
      $slug_variations[] = 'history';
    }
    
    foreach ($slug_variations as $slug_var) {
      $custom_icon = $get_custom_field_value($slug_var . '_ikon') ?: $get_custom_field_value($slug_var . '_icon');
      if (!empty($custom_icon)) {
        break;
      }
    }
  }
  
  // Global fallback: if no section-specific icon is set, fall back to the global 'ikon'/'icon' custom fields of the page
  if (empty($custom_icon)) {
    $custom_icon = $get_custom_field_value('ikon') ?: $get_custom_field_value('icon');
  }
  
  if (!empty($custom_icon)) {
    $icon = $custom_icon;
  }
}

// Ensure proper phosphor class prefix
if (!empty($icon) && strpos($icon, 'ph-') === false) {
  $icon = 'ph-' . $icon;
}

$debug_page_id = get_queried_object_id() ?: get_the_ID();
$debug_custom_fields = get_post_custom($debug_page_id) ?: [];

$content_allowed = wp_kses_allowed_html('post');
$content_allowed['iframe'] = [
  'src' => true,
  'title' => true,
  'allow' => true,
  'allowfullscreen' => true,
  'referrerpolicy' => true,
  'loading' => true,
  'width' => true,
  'height' => true,
  'frameborder' => true,
  'name' => true,
  'id' => true,
  'class' => true,
];
?>
<!-- DEBUG INFO:
  Page ID: <?php echo $debug_page_id; ?>
  Section Slug: <?php echo esc_html($section_slug); ?>
  Allow Custom Title: <?php echo $allow_custom_title ? 'true' : 'false'; ?>
  Allow Custom Icon: <?php echo $allow_custom_icon ? 'true' : 'false'; ?>
  Resolved Title: <?php echo esc_html($title); ?>
  Resolved Icon: <?php echo esc_html($icon); ?>
  
  Available Custom Fields:
  <?php 
  foreach ($debug_custom_fields as $key => $values) {
    // Only show non-system keys to keep it clean
    if (strpos($key, '_') !== 0) {
      echo esc_html($key) . ' => ' . esc_html($values[0]) . "\n  ";
    }
  } 
  ?>
-->

<section class="<?php echo esc_attr($block_class); ?>">

  <header class="content-block__header">

    <div class="content-block__icon">

      <i
        class="ph-fill <?php echo esc_attr($icon); ?>"
        aria-hidden="true"
      ></i>

    </div>

    <?php if ($title) : ?>

      <h2 class="content-block__title">

        <?php
        echo esc_html($title);
        ?>

      </h2>

    <?php endif; ?>

  </header>

  <?php if ($content) : ?>

    <div class="content-block__body">

      <?php
      echo wp_kses($content, $content_allowed);
      ?>

    </div>

  <?php endif; ?>

</section>