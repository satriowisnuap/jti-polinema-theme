<?php
/**
 * Akademik Content Section - Kalender Akademik
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// Fetch ACF fields
$title          = get_field('kalender_akademik_title');
$description    = get_field('kalender_akademik_description');
$image_data     = get_field('kalender_akademik_image');
$download_text  = get_field('kalender_akademik_download_text');
$download_file  = get_field('kalender_akademik_download_file');
$download_url   = get_field('kalender_akademik_download_url');

// Determine whether to display custom section title (avoid duplicate "Kalender Akademik")
$page_title = get_the_title();
$show_title = !empty($title) && strcasecmp(trim($title), 'Kalender Akademik') !== 0 && strcasecmp(trim($title), trim($page_title)) !== 0;

// Process & clean download text to prevent redundant text
if (!function_exists('webjti_clean_download_text')) {
    function webjti_clean_download_text($text) {
        if (empty($text)) {
            return '';
        }
        $text = trim($text);
        
        // Strip trailing/repeated "DISINI", "di sini", "Di Sini"
        $text = preg_replace('/\s*(DISINI|di sini|Di Sini)\b/iu', '', $text);
        
        // Split by lines to deduplicate identical lines
        $lines = preg_split('/[\r\n]+/', $text);
        $unique_lines = [];
        foreach ($lines as $line) {
            $line_trimmed = trim($line);
            if (!empty($line_trimmed) && !in_array($line_trimmed, $unique_lines, true)) {
                $unique_lines[] = $line_trimmed;
            }
        }
        $text = implode(' ', $unique_lines);

        // Deduplicate repeated string if identical block is duplicated (e.g. "ABC ABC") with dotall /ius
        if (preg_match('/^(.+?)\s+\1$/ius', trim($text), $matches)) {
            $text = trim($matches[1]);
        }

        // Substring repeat check for cases like "Phrase Phrase"
        $words = preg_split('/\s+/u', trim($text));
        $count = count($words);
        if ($count >= 4 && $count % 2 === 0) {
            $half = $count / 2;
            $first_half = implode(' ', array_slice($words, 0, $half));
            $second_half = implode(' ', array_slice($words, $half));
            if (strcasecmp($first_half, $second_half) === 0) {
                $text = $first_half;
            }
        }

        return trim($text);
    }
}

$download_text = webjti_clean_download_text($download_text);

if (empty($download_text)) {
    $download_text = 'Untuk Download Kalender Akademik Tahun Akademik 2025 / 2026';
}

// Clean description if it contains duplicate download phrase
if (!empty($description) && !empty($download_text)) {
    $escaped_dl_text = preg_quote($download_text, '/');
    $description = preg_replace('/<p>\s*' . $escaped_dl_text . '\s*<\/p>/iu', '', $description);
    $description = preg_replace('/' . $escaped_dl_text . '/iu', '', $description);
    $description = trim($description);
}

// Process Image URL & Alt
$image_url = '';
$image_alt = 'Kalender Akademik JTI';

if (!empty($image_data)) {
    if (is_array($image_data)) {
        $image_url = $image_data['url'] ?? '';
        $image_alt = !empty($image_data['alt']) ? $image_data['alt'] : 'Kalender Akademik JTI';
    } elseif (is_numeric($image_data)) {
        $image_src = wp_get_attachment_image_src($image_data, 'full');
        $image_url = $image_src ? $image_src[0] : '';
        $alt_text  = get_post_meta($image_data, '_wp_attachment_image_alt', true);
        if (!empty($alt_text)) {
            $image_alt = $alt_text;
        }
    } elseif (is_string($image_data)) {
        $image_url = $image_data;
    }
}

// Fallback to Featured Image (Gambar Unggulan) if empty
if (empty($image_url) && has_post_thumbnail()) {
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $thumbnail_id = get_post_thumbnail_id();
    $alt_text  = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    if (!empty($alt_text)) {
        $image_alt = $alt_text;
    }
}

// Process Download URL
$final_download_url = '';

if (!empty($download_file)) {
    if (is_array($download_file)) {
        $final_download_url = $download_file['url'] ?? '';
    } elseif (is_numeric($download_file)) {
        $final_download_url = wp_get_attachment_url($download_file) ?: '';
    } elseif (is_string($download_file)) {
        $final_download_url = $download_file;
    }
}

if (empty($final_download_url) && !empty($download_url)) {
    $final_download_url = $download_url;
}
?>

<?php
ob_start();
?>

<section class="kalender-akademik-section">

    <?php if (!empty($description)) : ?>
        <div class="kalender-akademik__header">
            <?php if (!empty($description)) : ?>
                <div class="kalender-akademik__description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Large Display Image Container with Lightbox Pop-up Zoom -->
    <?php if (!empty($image_url)) : ?>
        <div class="kalender-akademik__image-container">
            <div
                class="kalender-akademik__image-wrapper gallery-item"
                data-full="<?php echo esc_url($image_url); ?>"
                title="Klik untuk memperbesar kalender akademik"
                role="button"
                tabindex="0"
            >
                <img
                    src="<?php echo esc_url($image_url); ?>"
                    alt="<?php echo esc_attr($image_alt); ?>"
                    class="kalender-akademik__image"
                    loading="lazy"
                />
                <div class="kalender-akademik__image-overlay">
                    <div class="kalender-akademik__overlay-content">
                        <i class="ph ph-magnifying-glass-plus"></i>
                        <span>Klik untuk Memperbesar Kalender</span>
                    </div>
                </div>
            </div>
            <div class="kalender-akademik__image-action">
                <button
                    type="button"
                    class="kalender-akademik__zoom-btn gallery-item"
                    data-full="<?php echo esc_url($image_url); ?>"
                >
                    <i class="ph ph-magnifying-glass-plus"></i>
                    Perbesar Kalender
                </button>
            </div>
        </div>
    <?php else : ?>
        <!-- Fallback to Post Content (WordPress editor) if no image is uploaded in ACF/Featured Image -->
        <?php 
        $post_content = get_post_field('post_content', get_the_ID());
        if (!empty($post_content)) : 
        ?>
            <div class="kalender-akademik__custom-content content-rich-text" style="margin-bottom: 32px;">
                <?php echo apply_filters('the_content', $post_content); ?>
            </div>
        <?php else : ?>
            <!-- Placeholder Box if Image is Not Yet Uploaded -->
            <div class="kalender-akademik__image-container">
                <div class="kalender-akademik__image-wrapper" style="padding: 60px 20px; text-align: center; color: #79716B;">
                    <div style="font-size: 48px; margin-bottom: 12px; color: #EE6D08;">
                        <i class="ph ph-calendar-blank"></i>
                    </div>
                    <p style="font-size: 16px; font-weight: 500; margin: 0;">
                        Gambar Kalender Akademik belum di-upload. Silakan upload melalui Admin Panel (ACF Fields), Gambar Unggulan, atau masukkan konten gambar di Editor Halaman.
                    </p>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Download Information Banner -->
    <div class="kalender-akademik__download-box">
        <div class="kalender-akademik__download-info">
            <div class="kalender-akademik__download-icon">
                <i class="ph ph-file-pdf"></i>
            </div>
            <p class="kalender-akademik__download-text">
                <?php echo esc_html($download_text); ?>
            </p>
        </div>

        <?php if (!empty($final_download_url)) : ?>
            <a
                href="<?php echo esc_url($final_download_url); ?>"
                class="kalender-akademik__download-link"
                target="_blank"
                download
            >
                DISINI
                <i class="ph ph-download-simple"></i>
            </a>
        <?php else : ?>
            <a
                href="#"
                class="kalender-akademik__download-link"
                onclick="alert('File download kalender akademik belum tersedia.'); return false;"
            >
                DISINI
                <i class="ph ph-download-simple"></i>
            </a>
        <?php endif; ?>
    </div>

</section>

<?php
$ka_block_content = ob_get_clean();

get_template_part(
    'template-parts/components/content-block',
    null,
    [
        'title'              => 'Kalender Akademik',
        'icon'               => 'ph-calendar-blank',
        'content'            => $ka_block_content,
        'section_slug'       => 'kalender-akademik',
        'allow_custom_title' => true,
        'allow_custom_icon'  => true,
        'class'              => 'kalender-akademik-block',
    ]
);
?>

<!-- Fullscreen Lightbox Modal for Kalender Akademik Pop-up Zoom -->
<div id="gallery-lightbox" class="gallery-lightbox" aria-hidden="true">
  <div class="lightbox-overlay"></div>
  <span class="lightbox-close">&times;</span>
  <img id="lightbox-img" class="lightbox-content" src="" alt="Kalender Akademik Full">
</div>

