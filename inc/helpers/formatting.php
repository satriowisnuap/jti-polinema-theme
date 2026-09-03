<?php

/* ========================================
   FORMAT DATE
======================================== */

function webjti_format_date($date) {

  return date_i18n(
    'd F Y',
    strtotime($date)
  );

}

/* ========================================
   READING TIME
======================================== */

function webjti_reading_time($content) {

  $word_count =
    str_word_count(
      wp_strip_all_tags($content)
    );

  $minutes =
    ceil($word_count / 200);

  return $minutes . ' min read';

}

/* ========================================
   FORMAT NEWS POST
======================================== */

function webjti_format_news_post($post_id = null) {

  $post_id =
    $post_id ?: get_the_ID();

  $category_value = function_exists('get_field') ? strtolower(get_field('category', $post_id)) : '';
  $category_map = [
    'news'         => 'Berita',
    'announcement' => 'Pengumuman',
    'event'        => 'Agenda',
    'berita'       => 'Berita',
    'pengumuman'   => 'Pengumuman',
    'agenda'       => 'Agenda',
  ];
  $category_name = $category_map[$category_value] ?? 'Berita';

  $content =
    strip_tags(
      get_post_field(
        'post_content',
        $post_id
      )
    );

  $word_count =
    str_word_count($content);

  $reading_time =
    max(
      1,
      ceil($word_count / 200)
    );

  $excerpt =
    get_the_excerpt($post_id);

  if (!$excerpt) {

    $excerpt =
      wp_trim_words(
        $content,
        50,
        '...'
      );

  }

  return [

    'id' =>
      $post_id,

    'title' =>
      get_the_title($post_id),

    'excerpt' =>
      $excerpt,

    'permalink' =>
      get_permalink($post_id),

    'category' =>
      $category_name,

    'image' =>
      has_post_thumbnail($post_id)
        ? get_the_post_thumbnail_url(
            $post_id,
            'large'
          )
        : get_template_directory_uri()
            . '/assets/images/placeholders/news-placeholder.jpg',

    'date' =>
      date_i18n(
        'j F Y',
        get_post_time('U', false, $post_id)
      ),

    'reading_time' =>
      $reading_time . ' min',

  ];

}

/* ========================================
   GET LAB SIDEBAR ICON
======================================== */

if (!function_exists('webjti_get_lab_sidebar_icon')) {
    /**
     * Get distinct Phosphor icon name for a laboratory item in the sidebar
     *
     * @param array|object|int $lab Lab data array, post object, or ID
     * @param int $index Optional fallback index for distinct rotation
     * @return string Phosphor icon name (without 'ph-' prefix)
     */
    function webjti_get_lab_sidebar_icon($lab, $index = 0) {
        $lab_id = 0;
        $title  = '';
        $code   = '';
        $custom_icon = '';

        if (is_array($lab)) {
            $lab_id      = $lab['id'] ?? 0;
            $title       = $lab['title'] ?? '';
            $code        = $lab['code'] ?? '';
            $custom_icon = $lab['icon'] ?? ($lab['sidebar_icon'] ?? ($lab['lab_icon'] ?? ''));
        } elseif (is_object($lab)) {
            $lab_id = $lab->ID;
            $title  = $lab->post_title;
        } elseif (is_numeric($lab)) {
            $lab_id = (int) $lab;
            $title  = get_the_title($lab_id);
        }

        if ($lab_id > 0 && function_exists('get_field')) {
            if (empty($custom_icon)) {
                $custom_icon = get_field('sidebar_icon', $lab_id) ?: get_field('lab_icon', $lab_id) ?: get_field('icon', $lab_id);
            }
            if (empty($code)) {
                $code = get_field('lab_code', $lab_id) ?: '';
            }
        }

        // 1. If ACF custom icon field is specified, use it
        if (!empty($custom_icon)) {
            $clean_icon = trim(str_replace(['ph-', 'ph ', 'ph-fill'], '', $custom_icon));
            if (!empty($clean_icon)) {
                return $clean_icon;
            }
        }

        // 2. Keyword-based smart icon matching
        $haystack = strtolower($title . ' ' . $code);

        if (preg_match('/(informatika terapan|terapan|\bis\b)/iu', $haystack)) {
            return 'code';
        }
        if (preg_match('/(siber|security|keamanan|nsc|cyber|audit|infrastruktur)/iu', $haystack)) {
            return 'shield-check';
        }
        if (preg_match('/(rekayasa|perangkat lunak|rpl|software|devops|coding|program)/iu', $haystack)) {
            return 'code-block';
        }
        if (preg_match('/(visi|cerdas|ivss|ai|artificial|vision|intelligence|pattern|robot)/iu', $haystack)) {
            return 'eye';
        }
        if (preg_match('/(learning|inlet|pembelajaran|edtech|education|pendidikan)/iu', $haystack)) {
            return 'graduation-cap';
        }
        if (preg_match('/(bisnis|ba|analytics|analisa|erp|management|enterprise)/iu', $haystack)) {
            return 'chart-line-up';
        }
        if (preg_match('/(database|data|basis data|big data)/iu', $haystack)) {
            return 'database';
        }
        if (preg_match('/(jaringan|network|telekomunikasi|iot|broadcasting)/iu', $haystack)) {
            return 'broadcast';
        }
        if (preg_match('/(game|multimedia|desain|grafis|media)/iu', $haystack)) {
            return 'game-controller';
        }
        if (preg_match('/(mobile|aplikasi|app)/iu', $haystack)) {
            return 'device-mobile';
        }
        if (preg_match('/(sistem|system|embedded|hardware)/iu', $haystack)) {
            return 'cpu';
        }

        // 3. Fallback set of distinct tech & lab Phosphor icons (rotated per lab entry so no two labs have identical icon)
        $diverse_icons = [
            'flask',
            'cpu',
            'atom',
            'circuit-board',
            'brackets-curly',
            'desktop-tower',
            'terminal-window',
            'devices',
            'brain',
            'binary',
        ];

        $key_num = ($lab_id > 0) ? (int)$lab_id : (int)$index;
        return $diverse_icons[$key_num % count($diverse_icons)];
    }
}

if (!function_exists('webjti_get_aturan_akademik_auto_icon')) {
    /**
     * Get or auto-determine Phosphor icon name (without 'ph-' prefix) for Academic Regulations (aturan_akademik)
     *
     * @param int|object|string $post_or_title Post ID, WP_Post object, or title string
     * @param string $content_or_custom Optional content string or custom icon override
     * @return string Phosphor icon name (without 'ph-' prefix)
     */
    function webjti_get_aturan_akademik_auto_icon($post_or_title, $content_or_custom = '') {
        $post_id     = 0;
        $title       = '';
        $content     = '';
        $custom_icon = '';

        if (is_numeric($post_or_title) && (int)$post_or_title > 0) {
            $post_id = (int)$post_or_title;
            $post    = get_post($post_id);
            if ($post) {
                $title = $post->post_title;
            }
            if (function_exists('get_field')) {
                $custom_icon = get_field('aa_icon', $post_id);
                $content     = get_field('aa_description', $post_id) ?: '';
            }
            if (empty($content) && $post) {
                $content = $post->post_content;
            }
        } elseif (is_object($post_or_title) && isset($post_or_title->ID)) {
            $post_id = $post_or_title->ID;
            $title   = $post_or_title->post_title;
            if (function_exists('get_field')) {
                $custom_icon = get_field('aa_icon', $post_id);
                $content     = get_field('aa_description', $post_id) ?: '';
            }
            if (empty($content)) {
                $content = $post_or_title->post_content;
            }
        } elseif (is_string($post_or_title)) {
            $title = $post_or_title;
            if (!empty($content_or_custom)) {
                $content = $content_or_custom;
            }
        }

        // If custom icon was explicitly set (and not empty/default placeholder), clean and use it
        if (!empty($custom_icon)) {
            $clean_icon = trim(str_replace(['ph-', 'ph ', 'ph-fill'], '', $custom_icon));
            if (!empty($clean_icon) && $clean_icon !== 'book-open') {
                return $clean_icon;
            }
        }

        // Search title and content for keywords
        $haystack = strtolower(strip_tags($title . ' ' . $content));

        // Keyword mapping rules for Academic Regulations
        if (preg_match('/(pembelajaran|mengajar|kuliah|kurikulum|pengajaran|kelas|praktikum|tatap muka)/iu', $haystack)) {
            return 'chalkboard-teacher';
        }
        if (preg_match('/(jadwal|kalender|waktu|jam|pertemuan|agenda|periode|semester)/iu', $haystack)) {
            return 'calendar-blank';
        }
        if (preg_match('/(ketidakhadiran|kehadiran|absen|presensi|izin|sakit|alpha|terlambat)/iu', $haystack)) {
            return 'user-minus';
        }
        if (preg_match('/(evaluasi hasil|evaluasi belajar|uts|uas|kuis|tugas|ujian|asesmen|evaluasi)/iu', $haystack)) {
            return 'clipboard-text';
        }
        if (preg_match('/(penilaian|sistem penilaian|nilai|skala|grade|bobot|ipk|ips|indeks)/iu', $haystack)) {
            return 'star';
        }
        if (preg_match('/(yudisium|wisuda|gelar|alumni|kelulusan)/iu', $haystack)) {
            return 'graduation-cap';
        }
        if (preg_match('/(akhir studi|evaluasi akhir|skripsi|tugas akhir|ta|sidang|disertasi|tesis)/iu', $haystack)) {
            return 'exam';
        }
        if (preg_match('/(status akademik|status|cuti|registrasi|herregistrasi|ktm|kartu|non-aktif|aktif)/iu', $haystack)) {
            return 'identification-card';
        }
        if (preg_match('/(predikat|cumlaude|pujian|prestasi|penghargaan|trofi|kehormatan|juara)/iu', $haystack)) {
            return 'trophy';
        }
        if (preg_match('/(tata tertib|etika|perilaku|sanksi|pelanggaran|peringatan|disiplin|larangan|aturan)/iu', $haystack)) {
            return 'shield-warning';
        }
        if (preg_match('/(biaya|keuangan|ukt|spp|pembayaran|bayar|tunggakan)/iu', $haystack)) {
            return 'credit-card';
        }
        if (preg_match('/(magang|pkl|praktek|kerja lapangan)/iu', $haystack)) {
            return 'briefcase';
        }
        if (preg_match('/(dokumen|surat|sertifikat|ijazah|transkrip|skpi)/iu', $haystack)) {
            return 'file-text';
        }

        // Fallback set of Phosphor academic icons (rotated deterministically)
        $fallback_icons = [
            'book-open',
            'graduation-cap',
            'chalkboard-teacher',
            'clipboard-text',
            'calendar-blank',
            'star',
            'identification-card',
            'exam',
            'trophy',
            'notebook',
            'file-text',
            'shield-check',
        ];

        $hash_key = ($post_id > 0) ? (int)$post_id : abs(crc32($title));
        return $fallback_icons[$hash_key % count($fallback_icons)];
    }
}
