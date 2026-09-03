<?php
/**
 * Template Name: Laboratory Detail
 * Template Post Type: laboratory
 *
 * @package WebJTI_Theme
 */

get_header();

get_template_part(
    'template-parts/components/page-header'
);

wp_enqueue_style(
    'jti-lecturer-detail',
    get_template_directory_uri() . '/assets/css/lecturer-detail.css',
    ['webjti-app'],
    filemtime(get_template_directory() . '/assets/css/lecturer-detail.css')
);

wp_enqueue_style(
    'jti-laboratory-detail',
    get_template_directory_uri() . '/assets/css/laboratory-detail.css',
    ['webjti-app', 'jti-lecturer-detail'],
    filemtime(get_template_directory() . '/assets/css/laboratory-detail.css')
);

if (have_posts()) :
    while (have_posts()) : the_post();
        $post_id = get_the_ID();
        
        // ACF Fields
        $vision = webjti_field('vision', $post_id);
        $mission = webjti_field('mission', $post_id);
        
        $head_of_lab = webjti_field('head_of_lab', $post_id) ?: webjti_field('lab_head', $post_id);
        $lab_members = webjti_field('lab_members', $post_id);
        
        // Helper function to query CPT features assigned to this laboratory
        if (!function_exists('webjti_get_lab_cpt_features')) {
            function webjti_get_lab_cpt_features($cpt_name, $lab_id, $default_icon = 'ph-desktop-tower') {
                $items = [];
                $query = new WP_Query([
                    'post_type'      => $cpt_name,
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'meta_query'     => [
                        [
                            'key'     => 'related_lab',
                            'value'   => $lab_id,
                            'compare' => '=',
                        ],
                    ],
                ]);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $item_id = get_the_ID();
                        $icon = get_field('item_icon', $item_id);
                        if (empty($icon) && function_exists('webjti_get_cpt_auto_icon')) {
                            $icon = webjti_get_cpt_auto_icon($item_id, $cpt_name);
                        }
                        // Baca item_description (ACF wysiwyg/textarea) sebagai prioritas, fallback ke konten post
                        $acf_desc = get_field('item_description', $item_id);
                        $desc = !empty($acf_desc) ? $acf_desc : apply_filters('the_content', get_the_content());
                        $items[] = [
                            'name'        => get_the_title(),
                            'description' => $desc,
                            'icon'        => !empty($icon) ? $icon : $default_icon,
                        ];
                    }
                    wp_reset_postdata();
                }
                return $items;
            }
        }

        $facilities = webjti_get_lab_cpt_features('lab_facility', $post_id, 'ph-desktop-tower');
        $activities = webjti_get_lab_cpt_features('lab_activity', $post_id, 'ph-kanban');
        $courses    = webjti_get_lab_cpt_features('lab_course', $post_id, 'ph-book-open');

        $sop_services = webjti_field('sop_services', $post_id);
        $gallery = webjti_field('gallery', $post_id);
        
        $terms = wp_get_post_terms($post_id, 'research_focus');

        // Description fallback (ACF profile_content -> Editor -> Short Description)
        $acf_profile = get_field('profile_content', $post_id);
        $raw_content = get_the_content();
        $short_desc  = webjti_field('short_description', $post_id);
        
        $profile_text = '';
        if (!empty($acf_profile)) {
            $profile_text = apply_filters('the_content', $acf_profile);
        } elseif (!empty($raw_content)) {
            $profile_text = apply_filters('the_content', $raw_content);
        } elseif (!empty($short_desc)) {
            $profile_text = wpautop(esc_html($short_desc));
        }
?>

<main id="primary" class="site-main single-laboratory-page">
    <div class="container container--wide single-laboratory__container">
        
        <div class="page-layout with-sidebar">
            
            <?php
            /*
            ==================================================
            SIDEBAR NAVIGATION
            ==================================================
            */
            get_template_part(
                'template-parts/components/sidebar/sidebar'
            );
            ?>
            
            <div class="page-content single-laboratory__content-blocks">

                <?php if (!empty($profile_text)) : 
                    ob_start();
                    ?>
                    <div class="content-rich-text">
                        <?php echo $profile_text; ?>
                    </div>
                    <?php
                    $profile_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Profil Laboratorium',
                            'icon'    => 'ph-buildings',
                            'content' => $profile_content,
                        ]
                    );
                endif; ?>

                <?php if ($vision || $mission) : ?>
                <div class="lab-vismis-grid">
                    <?php if ($vision) : 
                        ob_start();
                        ?>
                        <div class="content-rich-text">
                            <?php echo wp_kses_post($vision); ?>
                        </div>
                        <?php
                        $vision_content = ob_get_clean();

                        get_template_part(
                            'template-parts/components/content-block',
                            null,
                            [
                                'title'   => 'Visi',
                                'icon'    => 'ph-eye',
                                'content' => $vision_content,
                            ]
                        );
                    endif; ?>

                    <?php if ($mission) : 
                        ob_start();
                        ?>
                        <div class="content-rich-text">
                            <?php echo wp_kses_post($mission); ?>
                        </div>
                        <?php
                        $mission_content = ob_get_clean();

                        get_template_part(
                            'template-parts/components/content-block',
                            null,
                            [
                                'title'   => 'Misi',
                                'icon'    => 'ph-target',
                                'content' => $mission_content,
                            ]
                        );
                    endif; ?>
                </div>
                <?php endif; ?>

                <?php
                // Query Fokus Riset CPT
                $lab_focus_items = [];
                $focus_query = new WP_Query([
                    'post_type'      => 'lab_focus',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'meta_query'     => [
                        [
                            'key'     => 'related_lab',
                            'value'   => $post_id,
                            'compare' => '=',
                        ],
                    ],
                ]);
                if ($focus_query->have_posts()) {
                    while ($focus_query->have_posts()) {
                        $focus_query->the_post();
                        $f_id = get_the_ID();
                        $f_icon = get_field('item_icon', $f_id);
                        if (empty($f_icon) && function_exists('webjti_get_cpt_auto_icon')) {
                            $f_icon = webjti_get_cpt_auto_icon($f_id, 'lab_focus');
                        }
                        $lab_focus_items[] = [
                            'title' => get_the_title(),
                            'icon'  => $f_icon ?: 'ph-target',
                        ];
                    }
                    wp_reset_postdata();
                }

                // Fallback/merge dengan taxonomy terms lama
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $lab_focus_items[] = [
                            'title' => $term->name,
                            'icon'  => 'ph-target',
                        ];
                    }
                }
                ?>

                <?php if (!empty($lab_focus_items)) : 
                    ob_start();
                    ?>
                    <div class="lab-focus-list">
                        <?php foreach ($lab_focus_items as $focus) : ?>
                            <span class="lab-focus-badge">
                                <?php if (!empty($focus['icon'])) : ?>
                                    <i class="ph <?php echo esc_attr($focus['icon']); ?>" style="margin-right: 6px;"></i>
                                <?php endif; ?>
                                <?php echo esc_html($focus['title']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <?php 
                    $focus_media = get_field('focus_media', $post_id);
                    if (!empty($focus_media)) : 
                        // Extract figure/img tags using regex
                        preg_match_all('/<figure[^>]*>.*?<img[^>]+>.*?<\/figure>|<img[^>]+>/is', $focus_media, $focus_matches);
                        
                        // Remove figures/images from the text content
                        $focus_text = preg_replace('/<figure[^>]*>.*?<img[^>]+>.*?<\/figure>|<img[^>]+>/is', '', $focus_media);
                        
                        // Clean up empty tags left behind (e.g. empty paragraphs)
                        $focus_text = preg_replace('/<p>\s*(?:&nbsp;)*\s*<\/p>/is', '', $focus_text);
                        $focus_text = trim($focus_text);
                        
                        $focus_images = !empty($focus_matches[0]) ? $focus_matches[0] : [];
                    ?>
                        <div class="lab-focus-content" style="margin-top: 20px;">
                            <?php if (!empty($focus_text)) : ?>
                                <div class="lab-focus-text content-rich-text">
                                    <?php echo apply_filters('the_content', $focus_text); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($focus_images)) : ?>
                                <div class="lab-focus-media">
                                    <?php foreach ($focus_images as $img_html) : ?>
                                        <div class="lab-focus-media-item">
                                            <?php echo $img_html; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $focus_block_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Fokus Riset',
                            'icon'    => 'ph-target',
                            'content' => $focus_block_content,
                        ]
                    );
                endif; ?>

                <?php if ($head_of_lab || !empty($lab_members)) : 
                    ob_start();
                    ?>
                    <div class="lab-org-tree">
                        <?php if ($head_of_lab) : 
                            $head_lecturer = webjti_get_single_lecturer(is_object($head_of_lab) ? $head_of_lab->ID : $head_of_lab);
                        ?>
                            <div class="lab-org-node lab-org-node--head">
                                <div class="lab-role-tag"><i class="ph ph-crown"></i> Kepala Laboratorium</div>
                                <?php if ($head_lecturer) : ?>
                                    <div class="lab-team-card lab-team-card--head">
                                        <div class="lab-team-card__top">
                                            <img src="<?php echo esc_url($head_lecturer['photo']); ?>" alt="<?php echo esc_attr($head_lecturer['name']); ?>" class="lab-team-card__img" />
                                            <div class="lab-team-card__info">
                                                <span class="lab-team-card__role lab-team-card__role--head">
                                                    <i class="ph ph-crown"></i> Kepala Laboratorium
                                                </span>
                                                <h4 class="lab-team-card__name">
                                                    <a href="<?php echo esc_url($head_lecturer['permalink']); ?>"><?php echo esc_html($head_lecturer['name']); ?></a>
                                                </h4>
                                                <?php if (!empty($head_lecturer['nip'])) : ?>
                                                    <span class="lab-team-card__meta">NIP. <?php echo esc_html($head_lecturer['nip']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="lab-team-card__actions">
                                            <?php if (!empty($head_lecturer['sinta'])) : ?>
                                                <a href="<?php echo esc_url($head_lecturer['sinta']); ?>" target="_blank" rel="noopener noreferrer" class="lab-team-btn lab-team-btn--sinta" title="Profil SINTA">
                                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                                                    <span>SINTA</span>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo esc_url($head_lecturer['permalink']); ?>" class="lab-team-btn lab-team-btn--detail">
                                                <span>Detail Dosen</span>
                                                <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($head_of_lab && !empty($lab_members)) : ?>
                            <div class="lab-org-connector"></div>
                        <?php endif; ?>

                        <?php if (!empty($lab_members)) : ?>
                            <div class="lab-org-section">
                                <div class="lab-role-tag lab-role-tag--member"><i class="ph ph-users-three"></i> Anggota</div>
                                <div class="lab-org-grid">
                                    <?php foreach ($lab_members as $member) : 
                                        $m_id = is_object($member) ? $member->ID : $member;
                                        $member_lecturer = webjti_get_single_lecturer($m_id);
                                        if ($member_lecturer) :
                                    ?>
                                        <div class="lab-team-card">
                                            <div class="lab-team-card__top">
                                                <img src="<?php echo esc_url($member_lecturer['photo']); ?>" alt="<?php echo esc_attr($member_lecturer['name']); ?>" class="lab-team-card__img" />
                                                <div class="lab-team-card__info">
                                                    <span class="lab-team-card__role lab-team-card__role--member">
                                                        <i class="ph ph-user"></i> Peneliti
                                                    </span>
                                                    <h4 class="lab-team-card__name">
                                                        <a href="<?php echo esc_url($member_lecturer['permalink']); ?>"><?php echo esc_html($member_lecturer['name']); ?></a>
                                                    </h4>
                                                    <?php if (!empty($member_lecturer['nip'])) : ?>
                                                        <span class="lab-team-card__meta">NIP. <?php echo esc_html($member_lecturer['nip']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="lab-team-card__actions">
                                                <?php if (!empty($member_lecturer['sinta'])) : ?>
                                                    <a href="<?php echo esc_url($member_lecturer['sinta']); ?>" target="_blank" rel="noopener noreferrer" class="lab-team-btn lab-team-btn--sinta" title="Profil SINTA">
                                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                                                        <span>SINTA</span>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?php echo esc_url($member_lecturer['permalink']); ?>" class="lab-team-btn lab-team-btn--detail">
                                                    <span>Detail Dosen</span>
                                                    <i class="ph ph-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    $team_block_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Struktur & Anggota Laboratorium',
                            'icon'    => 'ph-tree-structure',
                            'content' => $team_block_content,
                        ]
                    );
                endif; ?>

                <?php 
                // ── Sorotan Publikasi (Gabungan semua dosen Kepala & Anggota Lab) ──
                $pub_all_publications = [];
                $pub_lecturer_ids = [];
                
                // 1. Dosen Kepala Laboratorium
                if (!empty($head_of_lab)) {
                    $pub_h_id = is_object($head_of_lab) ? $head_of_lab->ID : (is_array($head_of_lab) ? ($head_of_lab['ID'] ?? 0) : intval($head_of_lab));
                    if ($pub_h_id > 0) $pub_lecturer_ids[] = $pub_h_id;
                }

                // 2. Dosen Anggota Laboratorium
                if (!empty($lab_members) && is_iterable($lab_members)) {
                    foreach ($lab_members as $pub_member) {
                        $pub_m_id = is_object($pub_member) ? $pub_member->ID : (is_array($pub_member) ? ($pub_member['ID'] ?? 0) : intval($pub_member));
                        if ($pub_m_id > 0) $pub_lecturer_ids[] = $pub_m_id;
                    }
                }

                // 3. Query dosen yang terhubung ke laboratorium ini via field relasi 'laboratory' atau 'related_lab'
                $assoc_lecturers = get_posts([
                    'post_type'      => 'lecturer',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'fields'         => 'ids',
                    'meta_query'     => [
                        'relation' => 'OR',
                        [
                            'key'     => 'laboratory',
                            'value'   => $post_id,
                            'compare' => '=',
                        ],
                        [
                            'key'     => 'laboratory',
                            'value'   => '"' . $post_id . '"',
                            'compare' => 'LIKE',
                        ],
                        [
                            'key'     => 'related_lab',
                            'value'   => $post_id,
                            'compare' => '=',
                        ]
                    ]
                ]);
                if (!empty($assoc_lecturers)) {
                    $pub_lecturer_ids = array_merge($pub_lecturer_ids, $assoc_lecturers);
                }

                // Filter unik ID dosen
                $pub_lecturer_ids = array_unique(array_filter($pub_lecturer_ids));

                // 4. Ambil semua publikasi dari setiap dosen
                foreach ($pub_lecturer_ids as $pub_lid) {
                    $pub_pubs = webjti_get_lecturer_publications($pub_lid);
                    if (!empty($pub_pubs)) {
                        $pub_all_publications = array_merge($pub_all_publications, $pub_pubs);
                    }
                }

                // 5. Deduplikasi publikasi berdasarkan Judul (mencegah duplikat jika 2 dosen menulis bersama)
                $pub_unique = [];
                foreach ($pub_all_publications as $pub_item) {
                    $pub_unique[$pub_item['title']] = $pub_item;
                }
                $pub_all_publications = array_values($pub_unique);

                // 6. Urutkan dari tahun terbaru
                usort($pub_all_publications, function($a, $b) {
                    return intval($b['year']) - intval($a['year']);
                });

                if (!empty($pub_all_publications)) :
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-publication',
                        null,
                        [
                            'publications' => $pub_all_publications,
                            'sinta_link'   => '',
                        ]
                    );
                endif;
                ?>

                <?php
                // ── Galeri Foto Laboratorium (CPT lab_gallery + fallback field gallery) ──
                $lab_all_gallery_images = [];

                // 1. Query CPT lab_gallery
                $cpt_gallery_query = new WP_Query([
                    'post_type'      => 'lab_gallery',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'meta_query'     => [
                        [
                            'key'     => 'related_lab',
                            'value'   => $post_id,
                            'compare' => '=',
                        ],
                    ],
                ]);

                if ($cpt_gallery_query->have_posts()) {
                    while ($cpt_gallery_query->have_posts()) {
                        $cpt_gallery_query->the_post();
                        $g_id = get_the_ID();

                        // 1a. Extract image from Featured Image - Get direct ID
                        if (has_post_thumbnail($g_id)) {
                            $thumb_id = get_post_thumbnail_id($g_id);
                            if ($thumb_id) {
                                $lab_all_gallery_images[] = $thumb_id;
                            }
                        }

                        // 1b. Extract <img> src from Add Media editor content - Resolve resized URLs to IDs
                        $g_content = get_post_field('post_content', $g_id);
                        if (!empty($g_content)) {
                            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $g_content, $g_matches);
                            if (!empty($g_matches[1])) {
                                foreach ($g_matches[1] as $src_url) {
                                    $attachment_id = attachment_url_to_postid($src_url);
                                    if ($attachment_id) {
                                        $lab_all_gallery_images[] = $attachment_id;
                                    } else {
                                        $lab_all_gallery_images[] = ['url' => $src_url];
                                    }
                                }
                            }
                        }

                        // 1c. ACF Image Fields (gallery_image / gallery_image_1..6 / lab_gallery_images)
                        $g_img = get_field('gallery_image', $g_id);
                        if (!empty($g_img)) {
                            if (is_string($g_img)) {
                                $attachment_id = attachment_url_to_postid($g_img);
                                $lab_all_gallery_images[] = $attachment_id ? $attachment_id : ['url' => $g_img];
                            } else {
                                $lab_all_gallery_images[] = $g_img;
                            }
                        }
                        $imgs = get_field('lab_gallery_images', $g_id);
                        if (!empty($imgs) && is_array($imgs)) {
                            foreach ($imgs as $img_item) {
                                if (is_string($img_item)) {
                                    $attachment_id = attachment_url_to_postid($img_item);
                                    $lab_all_gallery_images[] = $attachment_id ? $attachment_id : ['url' => $img_item];
                                } else {
                                    $lab_all_gallery_images[] = $img_item;
                                }
                            }
                        }
                        for ($g_i = 1; $g_i <= 6; $g_i++) {
                            $g_img_sub = get_field('gallery_image_' . $g_i, $g_id);
                            if (!empty($g_img_sub)) {
                                if (is_string($g_img_sub)) {
                                    $attachment_id = attachment_url_to_postid($g_img_sub);
                                    $lab_all_gallery_images[] = $attachment_id ? $attachment_id : ['url' => $g_img_sub];
                                } else {
                                    $lab_all_gallery_images[] = $g_img_sub;
                                }
                            }
                        }
                    }
                    wp_reset_postdata();
                }

                // 2. Fallback / Merge dengan field gallery pada CPT laboratory
                if (!empty($gallery) && is_array($gallery)) {
                    foreach ($gallery as $gallery_item) {
                        if (is_string($gallery_item)) {
                            $attachment_id = attachment_url_to_postid($gallery_item);
                            $lab_all_gallery_images[] = $attachment_id ? $attachment_id : ['url' => $gallery_item];
                        } else {
                            $lab_all_gallery_images[] = $gallery_item;
                        }
                    }
                }

                // 3. Query CPT lab_video for this laboratory
                $lab_videos = [];
                $video_query = new WP_Query([
                    'post_type'      => 'lab_video',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'meta_query'     => [
                        [
                            'key'     => 'related_lab',
                            'value'   => $post_id,
                            'compare' => '=',
                        ],
                    ],
                ]);

                if (!function_exists('webjti_get_youtube_id')) {
                    function webjti_get_youtube_id($url) {
                        $pattern = '%^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|watch\?.+&v=|shorts/))([\w-]{11})(?:.+)?$%x';
                        preg_match($pattern, $url, $matches);
                        return isset($matches[1]) ? $matches[1] : '';
                    }
                }

                if ($video_query->have_posts()) {
                    while ($video_query->have_posts()) {
                        $video_query->the_post();
                        $v_id = get_the_ID();
                        $youtube_link = get_field('youtube_link', $v_id);
                        $video_id = webjti_get_youtube_id($youtube_link);
                        
                        if ($video_id) {
                            $video_thumb = get_field('video_thumbnail', $v_id);
                            $thumb_url = '';
                            if (!empty($video_thumb)) {
                                $thumb_url = is_array($video_thumb) ? ($video_thumb['sizes']['medium_large'] ?? ($video_thumb['url'] ?? '')) : $video_thumb;
                            } elseif (has_post_thumbnail($v_id)) {
                                $thumb_url = get_the_post_thumbnail_url($v_id, 'medium_large');
                            } else {
                                $thumb_url = 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
                            }
                            
                            $lab_videos[] = [
                                'title'    => get_the_title(),
                                'video_id' => $video_id,
                                'thumbnail'=> $thumb_url,
                            ];
                        }
                    }
                    wp_reset_postdata();
                }
                ?>

                <?php if (!empty($lab_all_gallery_images) || !empty($lab_videos)) : ?>
                <section class="lab-section lab-gallery-section slider-wrapper" id="lab-gallery-section">
                    <div class="section-header">
                        <h2><i class="ph ph-images-square"></i> Galeri Labolatorium</h2>
                    </div>

                    <?php if (!empty($lab_all_gallery_images)) : ?>
                    <div class="lab-gallery-slider-wrap slider-container" style="margin-bottom: 28px;">
                        <div class="lab-gallery-grid slider-track" id="labGalleryGrid">
                            <?php foreach ($lab_all_gallery_images as $g_idx => $img) :
                                if (is_numeric($img)) {
                                    $img_url_thumb = wp_get_attachment_image_url((int) $img, 'medium_large') ?: wp_get_attachment_url((int) $img);
                                    $img_url_full  = wp_get_attachment_url((int) $img);
                                    $img_alt       = get_post_meta((int) $img, '_wp_attachment_image_alt', true) ?: get_the_title((int) $img);
                                } elseif (is_array($img)) {
                                    $img_url_thumb = $img['sizes']['medium_large'] ?? ($img['url'] ?? '');
                                    $img_url_full  = $img['url'] ?? $img_url_thumb;
                                    $img_alt       = $img['alt'] ?: ($img['title'] ?: 'Foto Laboratorium');
                                } else {
                                    $img_url_thumb = $img;
                                    $img_url_full  = $img;
                                    $img_alt       = 'Foto Laboratorium';
                                }
                            ?>
                                <div class="slider-item">
                                    <div class="lab-gallery-card gallery-item" data-full="<?php echo esc_url($img_url_full); ?>">
                                        <div class="lab-gallery-card__img-wrap">
                                            <img src="<?php echo esc_url($img_url_thumb); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy" />
                                            <div class="lab-gallery-card__overlay">
                                                <i class="ph ph-magnifying-glass-plus"></i>
                                                <span>Lihat Foto</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($lab_videos)) : ?>
                    <div class="lab-gallery-slider-wrap slider-container">
                        <div class="lab-gallery-grid slider-track" id="labVideoGrid">
                            <?php foreach ($lab_videos as $video) : ?>
                                <div class="slider-item">
                                    <div class="lab-gallery-card" data-video-id="<?php echo esc_attr($video['video_id']); ?>">
                                        <div class="lab-gallery-card__img-wrap">
                                            <img src="<?php echo esc_url($video['thumbnail']); ?>" alt="<?php echo esc_attr($video['title']); ?>" loading="lazy" />
                                            <div class="lab-gallery-card__overlay">
                                                <i class="ph ph-play-circle"></i>
                                                <span>Tonton Video</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </section>

                <?php if (!empty($lab_all_gallery_images)) : ?>
                <!-- Lightbox Modal -->
                <div id="gallery-lightbox" class="gallery-lightbox" aria-hidden="true">
                  <div class="lightbox-overlay"></div>
                  <div class="lightbox-toolbar">
                    <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-in" title="Perbesar (Zoom In)">
                      <i class="ph ph-magnifying-glass-plus"></i> <span>Zoom In</span>
                    </button>
                    <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-out" title="Perkecil (Zoom Out)">
                      <i class="ph ph-magnifying-glass-minus"></i> <span>Zoom Out</span>
                    </button>
                    <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-reset" title="Ukuran Semula">
                      <i class="ph ph-arrows-out-cardinal"></i> <span>Reset</span>
                    </button>
                    <a class="lightbox-tool-btn lightbox-tool-btn--primary" id="lightbox-download-link" href="#" target="_blank" download title="Download">
                      <i class="ph ph-download-simple"></i> <span>Download</span>
                    </a>
                  </div>
                  <span class="lightbox-close">&times;</span>
                  <img id="lightbox-img" class="lightbox-content" src="" alt="Foto Laboratorium Full">
                  
                  <?php if (count($lab_all_gallery_images) > 1) : ?>
                    <div class="prev"><i class="ph ph-caret-left"></i></div>
                    <div class="next"><i class="ph ph-caret-right"></i></div>
                  <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php endif; ?>

                <?php if (!empty($facilities)) : 
                    ob_start();
                    ?>
                    <div class="lab-badge-grid">
                        <?php foreach ($facilities as $fac) : ?>
                            <div class="lab-badge-card">
                                <div class="lab-badge-card__icon">
                                    <div class="lab-badge-card__icon-wrap">
                                        <i class="ph <?php echo esc_attr($fac['icon'] ?: 'ph-desktop-tower'); ?>"></i>
                                    </div>
                                </div>
                                <div class="lab-badge-card__content">
                                    <span class="lab-badge-card__title"><?php echo esc_html($fac['name']); ?></span>
                                    <?php if (!empty($fac['description'])) : ?>
                                        <div class="lab-badge-card__desc"><?php echo wp_kses_post($fac['description']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    $facilities_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Fasilitas & Peralatan',
                            'icon'    => 'ph-desktop-tower',
                            'content' => $facilities_content,
                        ]
                    );
                endif; ?>

                <?php if (!empty($activities)) : 
                    ob_start();
                    ?>
                    <div class="lab-badge-grid">
                        <?php foreach ($activities as $act) : ?>
                            <div class="lab-badge-card">
                                <div class="lab-badge-card__icon">
                                    <div class="lab-badge-card__icon-wrap">
                                        <i class="ph <?php echo esc_attr($act['icon'] ?: 'ph-kanban'); ?>"></i>
                                    </div>
                                </div>
                                <div class="lab-badge-card__content">
                                    <span class="lab-badge-card__title"><?php echo esc_html($act['name']); ?></span>
                                    <?php if (!empty($act['description'])) : ?>
                                        <div class="lab-badge-card__desc"><?php echo wp_kses_post($act['description']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    $activities_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Kegiatan & Proyek',
                            'icon'    => 'ph-kanban',
                            'content' => $activities_content,
                        ]
                    );
                endif; ?>

                <?php if (!empty($courses)) : 
                    ob_start();
                    ?>
                    <div class="lab-badge-grid">
                        <?php foreach ($courses as $course) : ?>
                            <div class="lab-badge-card">
                                <div class="lab-badge-card__icon">
                                    <div class="lab-badge-card__icon-wrap">
                                        <i class="ph <?php echo esc_attr($course['icon'] ?: 'ph-book-open'); ?>"></i>
                                    </div>
                                </div>
                                <div class="lab-badge-card__content">
                                    <span class="lab-badge-card__title"><?php echo esc_html($course['name']); ?></span>
                                    <?php if (!empty($course['description'])) : ?>
                                        <div class="lab-badge-card__desc"><?php echo wp_kses_post($course['description']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    $courses_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Perkuliahan Terkait',
                            'icon'    => 'ph-book-open',
                            'content' => $courses_content,
                        ]
                    );
                endif; ?>

                <?php 
                $partnership = get_field('partnership_content', $post_id);
                if (!empty($partnership)) : 
                    // Extract figure/img tags using regex
                    preg_match_all('/<figure[^>]*>.*?<img[^>]+>.*?<\/figure>|<img[^>]+>/is', $partnership, $matches);
                    
                    // Remove figures/images from the text content
                    $partnership_text = preg_replace('/<figure[^>]*>.*?<img[^>]+>.*?<\/figure>|<img[^>]+>/is', '', $partnership);
                    
                    // Clean up empty tags left behind (e.g. empty paragraphs)
                    $partnership_text = preg_replace('/<p>\s*(?:&nbsp;)*\s*<\/p>/is', '', $partnership_text);
                    $partnership_text = trim($partnership_text);
                    
                    $partnership_images = !empty($matches[0]) ? $matches[0] : [];

                    ob_start();
                    ?>
                    <div class="lab-partnership__body">
                        <?php if (!empty($partnership_text)) : ?>
                            <div class="lab-partnership__text content-rich-text">
                                <?php echo apply_filters('the_content', $partnership_text); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($partnership_images)) : ?>
                            <div class="lab-partnership__media">
                                <?php foreach ($partnership_images as $img_html) : ?>
                                    <div class="lab-partnership__media-item">
                                        <?php echo $img_html; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    $partnership_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Kerjasama & Partnership',
                            'icon'    => 'ph-handshake',
                            'content' => $partnership_content,
                        ]
                    );
                endif; ?>

                <?php if ($sop_services) : 
                    ob_start();
                    ?>
                    <div class="content-rich-text">
                        <?php echo wp_kses_post($sop_services); ?>
                    </div>
                    <?php
                    $sop_content = ob_get_clean();

                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'SOP dan Layanan',
                            'icon'    => 'ph-file-text',
                            'content' => $sop_content,
                        ]
                    );
                endif; ?>

                <?php 
                $lab_website_url = get_field('lab_website_url', $post_id);
                if (!empty($lab_website_url)) : 
                ?>
                <div class="lab-external-website-section" style="margin-top: 16px; display: flex; justify-content: flex-end;">
                    <a
                        href="<?php echo esc_url($lab_website_url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn--primary"
                        style="display: inline-flex; align-items: center; gap: 8px;"
                    >
                        <i class="ph ph-globe" style="font-size: 20px;"></i>
                        <span>Kunjungi Website Resmi Laboratorium</span>
                        <i class="ph ph-arrow-up-right" style="font-size: 16px;"></i>
                    </a>
                </div>
                <?php endif; ?>

            </div><!-- .single-laboratory__content-blocks -->

        </div><!-- .page-layout -->
        
    </div><!-- .container -->
</main>

<?php
    endwhile;
else :
?>
<main id="primary" class="site-main single-laboratory-page">
    <div class="container container--wide">
        <div class="lecturer-empty-state">
            <i class="ph ph-buildings"></i>
            <h2><?php esc_html_e('Laboratorium Tidak Ditemukan', 'webjti'); ?></h2>
        </div>
    </div>
</main>
<?php
endif;
get_footer();
