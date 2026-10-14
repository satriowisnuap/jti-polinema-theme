<?php
/**
 * Universal Sidebar Menu Walker for WebJTI Theme
 * Supports:
 * 1. Nested menus (Depth 0 = Heading, Depth 1 = Sub-items)
 * 2. Flat menus with '#' Custom Link headers as section dividers
 * 3. Standard flat menus with auto-group wrapping
 * 4. Automatic Phosphor icon detection and manual CSS class override
 *
 * @package WebJTI_Theme
 */

class WebJTI_Sidebar_Menu_Walker extends Walker_Nav_Menu {
    
    protected $group_open = false;
    protected $list_open  = false;

    public function walk( $elements, $max_depth, ...$args ) {
        $this->group_open = false;
        $this->list_open  = false;

        $output = parent::walk( $elements, $max_depth, ...$args );

        if ($this->list_open) {
            $output .= '</ul>';
            $this->list_open = false;
        }
        if ($this->group_open) {
            $output .= '</div>';
            $this->group_open = false;
        }

        return $output;
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if (!$this->list_open) {
            $output .= '<ul class="sidebar-menu-list">';
            $this->list_open = true;
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ($this->list_open) {
            $output .= '</ul>';
            $this->list_open = false;
        }
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item = $data_object;
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        $has_children   = !empty($this->has_children);
        $url            = trim($item->url ?? '');
        $is_hash_header = (empty($url) || $url === '#' || strpos($url, '#') === 0);
        $is_header      = ($depth === 0 && ($has_children || $is_hash_header));

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        if ( $is_header ) {
            // Close any previous section before starting new header
            if ($this->list_open) {
                $output .= '</ul>';
                $this->list_open = false;
            }
            if ($this->group_open) {
                $output .= '</div>';
                $this->group_open = false;
            }

            $output .= '<div class="sidebar-group">';
            $output .= '<h4 class="sidebar-group-title">' . esc_html( $title ) . '</h4>';
            $this->group_open = true;

            // If flat divider (no child in WP hierarchy), open <ul> for subsequent sibling items
            if (!$has_children) {
                $output .= '<ul class="sidebar-menu-list">';
                $this->list_open = true;
            }
        } else {
            // Ensure wrapper group and list exist
            if (!$this->group_open) {
                $output .= '<div class="sidebar-group">';
                $this->group_open = true;
            }
            if (!$this->list_open) {
                $output .= '<ul class="sidebar-menu-list">';
                $this->list_open = true;
            }

            // Find explicit icon class (e.g. ph-buildings, ph-laptop)
            $icon = '';
            $item_classes = [];
            foreach ($classes as $class) {
                if (strpos($class, 'ph-') === 0 && $class !== 'ph-fill') {
                    $icon = str_replace('ph-', '', $class);
                } else {
                    $item_classes[] = $class;
                }
            }
            
            // Smart auto-detection of icon based on keywords
            if (empty($icon)) {
                $url_path = trim(parse_url($item->url ?? '', PHP_URL_PATH), '/');
                $url_path = preg_replace('#^(student-affairs|kemahasiswaan|about-us|tentang-kami|research|penelitian|program-khusus|program_khusus|akademik|program-studi|study_program)/#', '', $url_path);
                $url_bare = basename($url_path);
                $haystack = strtolower($item->title . ' ' . $url_path . ' ' . $url_bare);

                if (preg_match('/(sejarah|history)/iu', $haystack)) {
                    $icon = 'buildings';
                } elseif (preg_match('/(visi|misi|target)/iu', $haystack)) {
                    $icon = 'target';
                } elseif (preg_match('/(organisasi|struktur|organization|tree)/iu', $haystack)) {
                    $icon = 'tree-structure';
                } elseif (preg_match('/(dosen|pengajar|lecturer|guru)/iu', $haystack)) {
                    $icon = 'chalkboard-teacher';
                } elseif (preg_match('/(kependidikan|staff|staf|pegawai|admin)/iu', $haystack)) {
                    $icon = 'user';
                } elseif (preg_match('/(sarana|prasarana|fasilitas|chair)/iu', $haystack)) {
                    $icon = 'chair';
                } elseif (preg_match('/(kerjasama|mitra|partner|cooperation|handshake)/iu', $haystack)) {
                    $icon = 'handshake';
                } elseif (preg_match('/(piranti|perangkat lunak situs|d2)/iu', $haystack)) {
                    $icon = 'code';
                } elseif (preg_match('/(d3.*kediri|mi.*kediri|d-iii.*kediri)/iu', $haystack)) {
                    $icon = 'buildings';
                } elseif (preg_match('/(d3.*lumajang|mi.*lumajang|d-iii.*lumajang)/iu', $haystack)) {
                    $icon = 'buildings';
                } elseif (preg_match('/(d4.*informatika|teknik informatika|\bti\b|sarjana terapan.*teknik)/iu', $haystack)) {
                    $icon = 'laptop';
                } elseif (preg_match('/(sistem informasi|bisnis|\bsib\b|sarjana terapan.*sistem)/iu', $haystack)) {
                    $icon = 'database';
                } elseif (preg_match('/(s2|magister|rekayasa teknologi informasi)/iu', $haystack)) {
                    $icon = 'graduation-cap';
                } elseif (preg_match('/(internasional|international|global)/iu', $haystack)) {
                    $icon = 'globe';
                } elseif (preg_match('/(double degree|gelar ganda)/iu', $haystack)) {
                    $icon = 'identification-card';
                } elseif (preg_match('/(alih jenjang|transfer)/iu', $haystack)) {
                    $icon = 'arrows-clockwise';
                } elseif (preg_match('/(rpl|rekognisi)/iu', $haystack)) {
                    $icon = 'certificate';
                } elseif (preg_match('/(aturan|panduan|pedoman|peraturan)/iu', $haystack)) {
                    $icon = 'file-text';
                } elseif (preg_match('/(kalender|calendar|jadwal)/iu', $haystack)) {
                    $icon = 'calendar';
                } elseif (preg_match('/(tata tertib|tertib|peraturan tata tertib)/iu', $haystack)) {
                    $icon = 'shield-warning';
                } elseif (preg_match('/(magang|pkl|praktik kerja)/iu', $haystack)) {
                    $icon = 'briefcase';
                } elseif (preg_match('/(ormawa|organisasi kemahasiswaan|himpunan|bem)/iu', $haystack)) {
                    $icon = 'users';
                } elseif (preg_match('/(prestasi|juara|award|achievement)/iu', $haystack)) {
                    $icon = 'trophy';
                } elseif (preg_match('/(karir|career|pengembangan karir)/iu', $haystack)) {
                    $icon = 'trend-up';
                } elseif (preg_match('/(beasiswa|scholarship)/iu', $haystack)) {
                    $icon = 'hand-coins';
                } elseif (preg_match('/(galeri|gallery|foto|dokumentasi)/iu', $haystack)) {
                    $icon = 'image';
                } elseif (preg_match('/(jurnal|journal|publikasi)/iu', $haystack)) {
                    $icon = 'book-open';
                } elseif (preg_match('/(penelitian|research)/iu', $haystack)) {
                    $icon = 'microscope';
                } elseif (preg_match('/(pengabdian|dedication)/iu', $haystack)) {
                    $icon = 'globe-hemisphere-east';
                } elseif (preg_match('/(siber|keamanan|nsc|cyber|jaringan dan keamanan)/iu', $haystack)) {
                    $icon = 'shield-check';
                } elseif (preg_match('/(rekayasa perangkat lunak|rpl)/iu', $haystack)) {
                    $icon = 'code-block';
                } elseif (preg_match('/(visi cerdas|sistem cerdas|ivss|ai)/iu', $haystack)) {
                    $icon = 'eye';
                } elseif (preg_match('/(learning|inlet|pembelajaran)/iu', $haystack)) {
                    $icon = 'graduation-cap';
                } elseif (preg_match('/(analisa bisnis|\bba\b)/iu', $haystack)) {
                    $icon = 'chart-line-up';
                } elseif (preg_match('/(teknologi data|data|\bdt\b)/iu', $haystack)) {
                    $icon = 'database';
                } elseif (preg_match('/(multimedia|perangkat bergerak|\bmmt\b)/iu', $haystack)) {
                    $icon = 'device-mobile';
                } elseif (preg_match('/(informatika terapan|\bis\b)/iu', $haystack)) {
                    $icon = 'code';
                } else {
                    $icon = 'list';
                }
            }

            $item_classes[] = 'sidebar-menu-item';
            
            $current_url_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
            $item_url_path    = trim(parse_url($item->url ?? '', PHP_URL_PATH), '/');
            $current_bare     = basename($current_url_path);
            $item_bare        = basename($item_url_path);

            $is_active = in_array('current-menu-item', $classes) || 
                         in_array('current-menu-ancestor', $classes) ||
                         in_array('current_page_item', $classes) ||
                         ($current_url_path !== '' && $current_url_path === $item_url_path) ||
                         ($current_bare !== '' && $current_bare === $item_bare) ||
                         (strpos($current_url_path, 'program-khusus') !== false && $current_bare && strpos($item_url_path, $current_bare) !== false) ||
                         (strpos($current_url_path, 'study_program') !== false && $current_bare && strpos($item_url_path, $current_bare) !== false) ||
                         (strpos($current_url_path, 'laboratory') !== false && $current_bare && strpos($item_url_path, $current_bare) !== false);

            if ($is_active) {
                $item_classes[] = 'active';
                $item_classes[] = 'current-menu-item';
            }

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $item_classes ), $item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= '<li' . $id . $class_names .'>';

            $atts = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
            $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
            $atts['class']  = 'sidebar-menu-link';

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $icon_class = $is_active ? 'ph-fill ph-' . $icon : 'ph ph-' . $icon;

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= '<span class="sidebar-menu-icon"><i class="' . esc_attr($icon_class) . '"></i></span>';
            $item_output .= '<span class="sidebar-menu-text">' . $args->link_before . $title . $args->link_after . '</span>';
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $item = $data_object;
        $has_children   = !empty($this->has_children);
        $url            = trim($item->url ?? '');
        $is_hash_header = (empty($url) || $url === '#' || strpos($url, '#') === 0);
        $is_header      = ($depth === 0 && ($has_children || $is_hash_header));

        if ( $is_header ) {
            if ($has_children) {
                if ($this->group_open) {
                    $output .= '</div>';
                    $this->group_open = false;
                }
            }
            // Flat divider leaves list and group open for subsequent items
        } else {
            $output .= '</li>';
        }
    }
}

