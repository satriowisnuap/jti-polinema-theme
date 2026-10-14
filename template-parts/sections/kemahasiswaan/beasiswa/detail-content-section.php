<?php
/**
 * Beasiswa Detail Content Section
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_id = absint(get_the_ID());
$has_acf = function_exists('get_field');

// Mocking some data for the detail page. Ideally, these would come from ACF fields for each detail page.
$scholarship_title = $has_acf && get_field('detail_title', $page_id) ? get_field('detail_title', $page_id) : '-';
$provider = $has_acf && get_field('detail_provider', $page_id) ? get_field('detail_provider', $page_id) : '-';
$deadline = $has_acf && get_field('detail_deadline', $page_id) ? get_field('detail_deadline', $page_id) : '-';
$quota = $has_acf && get_field('detail_quota', $page_id) ? get_field('detail_quota', $page_id) : '-';
$status = $has_acf && get_field('detail_status', $page_id) ? get_field('detail_status', $page_id) : 'Buka'; // Buka / Tutup
$amount = $has_acf && get_field('detail_amount', $page_id) ? get_field('detail_amount', $page_id) : '-';
?>

<style>
/* Detail Beasiswa Styles */
.beasiswa-detail-header {
    background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
    border-radius: 16px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}
.bd-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.5rem;
}
.bd-provider {
    font-size: 1.1rem;
    color: #3b82f6;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 2rem;
}
.bd-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}
.bd-meta-item {
    background: #ffffff;
    padding: 1.25rem;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    border: 1px solid #f1f5f9;
}
.bd-meta-icon {
    background: #eff6ff;
    color: #3b82f6;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.bd-meta-content {
    display: flex;
    flex-direction: column;
}
.bd-meta-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.bd-meta-value {
    font-size: 1.05rem;
    color: #0f172a;
    font-weight: 700;
}
.bd-status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.bd-status-open {
    background: #dcfce7;
    color: #166534;
}
.bd-status-closed {
    background: #fee2e2;
    color: #991b1b;
}

/* Gutenberg Content Wrapper Styles */
.gutenberg-dynamic-content {
    background: #ffffff;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    color: #475569;
    line-height: 1.8;
    font-size: 1.05rem;
}
.gutenberg-dynamic-content h2, 
.gutenberg-dynamic-content h3, 
.gutenberg-dynamic-content h4 {
    color: #1e293b;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}
.gutenberg-dynamic-content h2:first-child,
.gutenberg-dynamic-content h3:first-child {
    margin-top: 0;
}
.gutenberg-dynamic-content img {
    border-radius: 12px;
    height: auto;
    max-width: 100%;
    margin: 1.5rem 0;
}
.gutenberg-dynamic-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}
.gutenberg-dynamic-content table th,
.gutenberg-dynamic-content table td {
    padding: 1rem;
    border: 1px solid #e2e8f0;
}
.gutenberg-dynamic-content table th {
    background: #f8fafc;
    color: #1e293b;
    font-weight: 600;
}
.gutenberg-dynamic-content a {
    color: #3b82f6;
    text-decoration: none;
}
.gutenberg-dynamic-content a:hover {
    text-decoration: underline;
}
.gutenberg-dynamic-content .wp-block-file {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.gutenberg-dynamic-content .wp-block-file a.wp-block-file__button {
    background: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
}
.gutenberg-dynamic-content ul, 
.gutenberg-dynamic-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1.5rem;
}
.gutenberg-dynamic-content li {
    margin-bottom: 0.5rem;
}
</style>

<div class="beasiswa-detail-wrapper">
    
    <!-- Header Section -->
    <header class="beasiswa-detail-header">
        <h1 class="bd-title"><?php echo esc_html($scholarship_title); ?></h1>
        <div class="bd-provider"><?php echo esc_html($provider); ?></div>
        
        <div class="bd-meta-grid">
            <div class="bd-meta-item">
                <div class="bd-meta-icon"><i class="ph ph-calendar-blank"></i></div>
                <div class="bd-meta-content">
                    <span class="bd-meta-label">Batas Pendaftaran</span>
                    <span class="bd-meta-value"><?php echo esc_html($deadline); ?></span>
                </div>
            </div>
            
            <div class="bd-meta-item">
                <div class="bd-meta-icon"><i class="ph ph-wallet"></i></div>
                <div class="bd-meta-content">
                    <span class="bd-meta-label">Benefit / Cakupan</span>
                    <span class="bd-meta-value"><?php echo esc_html($amount); ?></span>
                </div>
            </div>
            
            <div class="bd-meta-item">
                <div class="bd-meta-icon"><i class="ph ph-users"></i></div>
                <div class="bd-meta-content">
                    <span class="bd-meta-label">Kuota Penerima</span>
                    <span class="bd-meta-value"><?php echo esc_html($quota); ?></span>
                </div>
            </div>
            
            <div class="bd-meta-item">
                <div class="bd-meta-icon"><i class="ph ph-info"></i></div>
                <div class="bd-meta-content">
                    <span class="bd-meta-label">Status Pendaftaran</span>
                    <span class="bd-status-badge <?php echo strtolower($status) === 'buka' ? 'bd-status-open' : 'bd-status-closed'; ?>">
                        <?php echo esc_html($status); ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Native Gutenberg Content Section -->
    <div class="gutenberg-dynamic-content">
        <?php 
        // This allows the user to build the rest of the page using WordPress Block Editor (Gutenberg)
        // They can add Tables, PDF Files (File Block), Images, Flowcharts, Buttons, etc.
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                
                $content = get_the_content();
                if (empty(trim($content))) {
                    // Fallback content if the editor is completely empty
                    echo '<h2 style="margin-top:0;">Isi Detail Beasiswa</h2>';
                    echo '<p>Gunakan editor WordPress (Gutenberg) untuk menambahkan konten di sini. Anda bisa menambahkan <strong>Tabel</strong>, upload <strong>File PDF</strong>, gambar <strong>Alur Pendaftaran</strong>, dan berbagai elemen lainnya dengan sangat mudah (mendekati fitur Elementor).</p>';
                    echo '<ul>
                            <li>Klik tombol <strong>+</strong> di editor untuk menambah Blok.</li>
                            <li>Pilih blok <strong>File</strong> untuk melampirkan PDF.</li>
                            <li>Pilih blok <strong>Table</strong> untuk membuat tabel persyaratan/jadwal.</li>
                            <li>Pilih blok <strong>Image</strong> untuk diagram alur pendaftaran.</li>
                          </ul>';
                } else {
                    the_content();
                }
            }
        }
        ?>
    </div>

</div>
