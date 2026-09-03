<?php
/**
 * Single Template: Career Program
 * Post Type: career_program
 *
 * @package WebJTI_Theme
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        
        $title = get_the_title();
        $date = get_the_date('d M Y');
        $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png';
        
        // ACF Fields
        $career_date_text = function_exists('get_field') ? get_field('career_date') : '';
        $career_location = function_exists('get_field') ? get_field('career_location') : '';
        $career_link = function_exists('get_field') ? get_field('career_link') : '';
        $career_reg_deadline = function_exists('get_field') ? get_field('career_registration_deadline') : '';
        
        $career_images = [];
        if (function_exists('get_field')) {
            for ($i = 1; $i <= 10; $i++) {
                $img = get_field('career_gallery_' . $i);
                if ($img && is_array($img)) {
                    $career_images[] = $img;
                }
            }
        }

        $is_registration_open = true;
        $deadline_passed = false;
        
        if ( !empty($career_reg_deadline) ) {
            $deadline_timestamp = strtotime($career_reg_deadline);
            $current_timestamp = current_time('timestamp');
            if ( $current_timestamp > $deadline_timestamp ) {
                $deadline_passed = true;
                $is_registration_open = false;
            }
        }
?>

<main id="primary" class="site-main single-career-page-main">
    
    <!-- Hero Header -->
    <div class="single-career__header" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)), url('<?php echo esc_url($image_url); ?>'); background-size: cover; background-position: center; padding: 100px 0; text-align: center; color: #fff;">
        <div class="container container--wide">
            <h1 class="single-career__title" style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;"><?php echo esc_html($title); ?></h1>
            <div class="single-career__meta" style="font-size: 1.1rem; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <?php if ($career_date_text): ?>
                    <span><i class="ph ph-calendar"></i> <?php echo esc_html($career_date_text); ?></span>
                <?php else: ?>
                    <span><i class="ph ph-calendar"></i> Dipublikasikan: <?php echo esc_html($date); ?></span>
                <?php endif; ?>
                
                <?php if ($career_location): ?>
                    <span><i class="ph ph-map-pin"></i> <?php echo esc_html($career_location); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="container container--wide" style="max-width: 900px; margin: 50px auto; padding: 0 20px;">
        <article class="single-career__article detail-content-body">
            
            <div class="single-career__content">
                <?php the_content(); ?>
            </div>

            <!-- Galeri Foto (Opsional) -->
            <?php if ( !empty($career_images) ) : ?>
                <div class="single-career__gallery" style="margin-top: 50px;">
                    <h3 style="margin-bottom: 20px; font-weight: 600; font-size: 1.8rem; border-bottom: 2px solid #eaeaea; padding-bottom: 10px;">Foto Terkait</h3>
                    
                    <div style="position: relative; display: flex; align-items: center;">
                        <!-- Left Arrow -->
                        <button onclick="document.getElementById('career-slider').scrollBy({left: -315, behavior: 'smooth'})" style="position: absolute; left: -15px; z-index: 10; background: #fff; border: 1px solid #ddd; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.15); font-size: 1.2rem; color: #333;"><i class="ph ph-caret-left"></i></button>
                        
                        <!-- Slider Container -->
                        <div id="career-slider" class="career-gallery-slider" style="display: flex; gap: 15px; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; width: 100%; padding: 10px 0;">
                            <?php foreach ( $career_images as $image ) : ?>
                                <a href="javascript:void(0);" onclick="openCareerModal('<?php echo esc_url($image['url']); ?>')" style="flex: 0 0 auto; width: 300px; display: block; overflow: hidden; border-radius: 8px; scroll-snap-align: start;">
                                    <img src="<?php echo esc_url($image['sizes']['medium_large'] ?? $image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" style="width: 100%; height: 220px; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"/>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <!-- Right Arrow -->
                        <button onclick="document.getElementById('career-slider').scrollBy({left: 315, behavior: 'smooth'})" style="position: absolute; right: -15px; z-index: 10; background: #fff; border: 1px solid #ddd; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.15); font-size: 1.2rem; color: #333;"><i class="ph ph-caret-right"></i></button>
                    </div>

                    <style>
                        .career-gallery-slider::-webkit-scrollbar { display: none; }
                        @keyframes careerZoom {
                            from {transform:scale(0.8); opacity:0;} 
                            to {transform:scale(1); opacity:1;}
                        }
                    </style>

                    <!-- Modal Fullscreen Image -->
                    <div id="careerImageModal" style="display: none; position: fixed; z-index: 99999; padding-top: 80px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); backdrop-filter: blur(5px);">
                        <span onclick="closeCareerModal()" style="position: absolute; top: 20px; right: 40px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; transition: 0.3s; z-index: 100000;" onmouseover="this.style.color='#bbb'" onmouseout="this.style.color='#f1f1f1'">&times;</span>
                        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                            <img id="careerModalImg" style="margin: auto; display: block; max-width: 90%; max-height: 85vh; object-fit: contain; animation-name: careerZoom; animation-duration: 0.4s; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                        </div>
                    </div>

                    <script>
                        function openCareerModal(imgUrl) {
                            document.getElementById('careerImageModal').style.display = 'block';
                            document.getElementById('careerModalImg').src = imgUrl;
                            document.body.style.overflow = 'hidden'; // Stop background scrolling
                        }
                        function closeCareerModal() {
                            document.getElementById('careerImageModal').style.display = 'none';
                            document.body.style.overflow = 'auto'; // Restore background scrolling
                        }
                        
                        // Close modal on click outside image
                        document.getElementById('careerImageModal').addEventListener('click', function(e) {
                            if (e.target === this || e.target.tagName === 'DIV') {
                                closeCareerModal();
                            }
                        });
                    </script>
                </div>
            <?php endif; ?>

            <!-- Tombol Pendaftaran (Opsional & Dinamis) -->
            <?php if ( $career_link ) : ?>
                <div class="single-career__action" style="margin-top: 50px; text-align: center; padding: 40px; background-color: #f8f9fa; border-radius: 12px;">
                    <h3 style="margin-bottom: 15px; font-size: 1.5rem; font-weight: 600;">Tertarik Mengikuti Program Ini?</h3>
                    
                    <?php if ( $deadline_passed ) : ?>
                        <p style="color: #dc3545; font-weight: 500; margin-bottom: 15px;">Pendaftaran telah ditutup pada <?php echo date_i18n('d F Y H:i', strtotime($career_reg_deadline)); ?>.</p>
                        <button class="career-btn disabled" disabled style="background-color: #6c757d; color: #fff; padding: 12px 30px; font-size: 1.1rem; border: none; border-radius: 6px; cursor: not-allowed; font-weight: 600;">Pendaftaran Ditutup</button>
                    <?php else: ?>
                        <?php if ( !empty($career_reg_deadline) ) : ?>
                            <p style="color: #198754; font-weight: 500; margin-bottom: 15px;">Batas pendaftaran: <?php echo date_i18n('d F Y H:i', strtotime($career_reg_deadline)); ?></p>
                        <?php endif; ?>
                        <a href="<?php echo esc_url($career_link); ?>" target="_blank" rel="noopener noreferrer" class="career-btn" style="display: inline-block; background-color: #0d6efd; color: #fff; padding: 12px 30px; font-size: 1.1rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; text-decoration: none; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#0b5ed7'" onmouseout="this.style.backgroundColor='#0d6efd'">Daftar Sekarang</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </article>
    </div>

</main>

<?php 
    endwhile; 
endif; 

get_footer(); 
?>
