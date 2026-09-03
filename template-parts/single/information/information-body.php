<?php
/**
 * Single Information Body & Share Panel Section
 *
 * @package WebJTI_Theme
 */

$title = $args['title'] ?? '';
$date = $args['date'] ?? '';
$reading_time = $args['reading_time'] ?? '';
$is_default = $args['is_default'] ?? false;
$content = $args['content'] ?? '';
$post_url = $args['post_url'] ?? '';
?>

<!-- Focused Center Layout (No Right Sidebar) -->
<div class="single-info__focused-layout">
    
    <!-- Article Content Area -->
    <article class="single-info__main-article focused">
        
        <header class="single-info__content-header">
            <h1 class="single-info__main-title"><?php echo esc_html($title); ?></h1>
            
            <div class="single-info__meta-row">
                <span class="single-info__meta-item">
                    <i class="ph ph-calendar"></i>
                    <span><?php echo esc_html($date); ?></span>
                </span>
                <span class="single-info__meta-sep">•</span>
                <span class="single-info__meta-item">
                    <i class="ph ph-clock"></i>
                    <span><?php echo esc_html($reading_time); ?> menit baca</span>
                </span>
            </div>
        </header>
        
        <!-- Main Body Copy -->
        <div class="single-info__body-text detail-content-body">
            <?php 
            if ($is_default) {
                echo wp_kses_post($content);
            } else {
                // Apply the content filter for standard database posts
                the_content();
            }
            ?>
        </div>
        
    </article>

     <!-- Sticky Floating Social Share Panel on the Right -->
    <aside class="single-info__social-right">
        <div class="single-info__social-right-inner">
            <span class="share-text-vertical">BAGIKAN</span>
            <div class="single-info__social-vertical-list">
                
                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="single-info__social-btn ig" aria-label="Bagikan ke Instagram">
                    <i class="ph-fill ph-instagram-logo"></i>
                </a>
                
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($post_url); ?>&text=<?php echo urlencode($title); ?>" target="_blank" rel="noopener noreferrer" class="single-info__social-btn x" aria-label="Bagikan ke X">
                    <i class="ph-fill ph-x-logo"></i>
                </a>
                
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_url); ?>" target="_blank" rel="noopener noreferrer" class="single-info__social-btn fb" aria-label="Bagikan ke Facebook">
                    <i class="ph-fill ph-facebook-logo"></i>
                </a>
                
                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($title . ' ' . $post_url); ?>" target="_blank" rel="noopener noreferrer" class="single-info__social-btn wa" aria-label="Bagikan ke WhatsApp">
                    <i class="ph-fill ph-whatsapp-logo"></i>
                </a>
                
                <button onclick="copyToClipboard('<?php echo esc_js($post_url); ?>')" class="single-info__social-btn copylink" aria-label="Salin Tautan">
                    <i class="ph ph-link"></i>
                </button>
                
            </div>
        </div>
    </aside>
    
</div>

<!-- Premium Bottom-Right Toast Success Notification Popup -->
<div id="toast-notification" class="jti-toast">
    <div class="jti-toast__content">
        <div class="jti-toast__icon-wrapper">
            <i class="ph-fill ph-check-circle"></i>
        </div>
        <div class="jti-toast__message">
            <span class="jti-toast__title">Tautan Tersalin!</span>
            <span class="jti-toast__desc">Link artikel telah disimpan ke clipboard Anda.</span>
        </div>
    </div>
</div>

<!-- Javascript Handles Sharing Copy Clipboard Actions & Dynamic Popups -->
<script>
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
            showToast();
        }).catch(function(err) {
            fallbackCopyToClipboard(text);
        });
    } else {
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.opacity = "0";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        showToast();
    } catch (err) {
        console.error('Fallback Gagal Menyalin', err);
    }
    document.body.removeChild(textArea);
}

function showToast() {
    var toast = document.getElementById('toast-notification');
    toast.classList.add('show');
    setTimeout(function() {
        toast.classList.remove('show');
    }, 3000);
}
</script>
