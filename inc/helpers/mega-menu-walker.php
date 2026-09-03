<?php
/**
 * Mega Menu Walker for WebJTI Theme
 * Maps standard WordPress menu hierarchy to Mega Menu HTML structure
 * 
 * Depth 0: Top level item (li)
 * Depth 1: Column (div.mega-dropdown__col) with Label
 * Depth 2: Link (li > a) OR Group (li.mega-dropdown__group)
 * Depth 3: Link inside group (a)
 *
 * @package WebJTI_Theme
 */

class WebJTI_Mega_Menu_Walker extends Walker_Nav_Menu {
    
    private $current_col = 0;
    private $current_top_menu_title = '';
    
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $n = "\n";

        if ( $depth === 0 ) {
            // Level 1: Starts a mega dropdown
            $classes = array( 'mega-dropdown' );
            $top_lower = strtolower(trim($this->current_top_menu_title));
            if ( strpos($top_lower, 'akademik') !== false || strpos($top_lower, 'academic') !== false || strpos($top_lower, 'penelitian') !== false || strpos($top_lower, 'research') !== false ) {
                $classes[] = 'mega-dropdown--wide';
            }
            $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $output .= "{$n}{$indent}<div$class_names>{$n}";
        } elseif ( $depth === 1 ) {
            // Level 2: Inside a column. List for column items.
            $classes = array( 'mega-dropdown__list' );
            $top_lower = strtolower(trim($this->current_top_menu_title));
            if ( (strpos($top_lower, 'akademik') !== false || strpos($top_lower, 'academic') !== false) && $this->current_col === 1 ) {
                // The first column in Akademik ("Program Pendidikan") has grouped items
                $classes[] = 'mega-dropdown__list--grouped';
            }
            $class_names = join( ' ', $classes );
            $output .= "{$n}{$indent}<ul class=\"{$class_names}\">{$n}";
        } elseif ( $depth === 2 ) {
            // Level 3: Inside a group. List is not needed because a group just has <a> elements inside <li>.
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $n = "\n";

        if ( $depth === 0 ) {
            // End of mega dropdown
            $output .= "{$indent}</div>{$n}";
        } elseif ( $depth === 1 ) {
            // End of column list
            $output .= "{$indent}</ul>{$n}";
            $output .= "{$indent}</div><!-- .mega-dropdown__col -->{$n}";
        } elseif ( $depth === 2 ) {
            // End of group
        }
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item = $data_object;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $n = "\n";

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
        
        if ( $depth === 0 ) {
            $this->current_top_menu_title = strtolower(trim($item->title));
            $classes[] = 'menu-item';
            if ( $args->walker->has_children ) {
                $classes[] = 'menu-item-has-dropdown';
            }
            
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names .'>';

            $atts = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
            $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
            $atts['class']  = 'menu-link';
            
            if ( $args->walker->has_children ) {
                $atts['class'] .= ' menu-link--dropdown';
            }

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $title = apply_filters( 'the_title', $item->title, $item->ID );
            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . $title . $args->link_after;
            if ( $args->walker->has_children ) {
                $item_output .= ' <i class="ph ph-caret-down caret-icon"></i>';
            }
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

        } elseif ( $depth === 1 ) {
            // Column Label
            if ( $this->current_col > 0 ) {
                $output .= $indent . '<div class="mega-dropdown__divider"></div>' . $n;
            }
            
            $col_classes = array('mega-dropdown__col');
            $col_title_lower = strtolower(trim($item->title));
            $top_title_lower = strtolower(trim($this->current_top_menu_title));
            
            // Apply column modifiers based on template design
            if (strpos($top_title_lower, 'penelitian') !== false || strpos($top_title_lower, 'research') !== false) {
                if (strpos($col_title_lower, 'laboratorium') !== false || strpos($col_title_lower, 'lab') !== false || strpos($col_title_lower, 'riset') !== false) {
                    $col_classes[] = 'mega-dropdown__col--wide';
                    $col_classes[] = 'mega-dropdown__col--labs';
                } elseif (strpos($col_title_lower, 'kegiatan') !== false || strpos($col_title_lower, 'dukungan') !== false) {
                    $col_classes[] = 'mega-dropdown__col--narrow';
                }
            } elseif (strpos($top_title_lower, 'akademik') !== false || strpos($top_title_lower, 'academic') !== false) {
                if (strpos($col_title_lower, 'studi') !== false || strpos($col_title_lower, 'pendidikan') !== false || strpos($col_title_lower, 'prodi') !== false) {
                    $col_classes[] = 'mega-dropdown__col--prodi';
                } elseif (strpos($col_title_lower, 'khusus') !== false) {
                    $col_classes[] = 'mega-dropdown__col--khusus';
                } elseif (strpos($col_title_lower, 'layanan') !== false || strpos($col_title_lower, 'aturan') !== false || strpos($col_title_lower, 'kalender') !== false) {
                    $col_classes[] = 'mega-dropdown__col--layanan';
                }
            } elseif (strpos($top_title_lower, 'kemahasiswaan') !== false || strpos($top_title_lower, 'student') !== false) {
                if (strpos($col_title_lower, 'umum') !== false || strpos($col_title_lower, 'informasi') !== false) {
                    $col_classes[] = 'mega-dropdown__col--info-umum';
                } elseif (strpos($col_title_lower, 'pengembangan') !== false) {
                    $col_classes[] = 'mega-dropdown__col--pengembangan';
                } elseif (strpos($col_title_lower, 'dukungan') !== false) {
                    $col_classes[] = 'mega-dropdown__col--dukungan';
                }
            }
            
            // Allow user to set custom classes as well via WP admin
            if (in_array('mega-dropdown__col--wide', $classes)) $col_classes[] = 'mega-dropdown__col--wide';
            if (in_array('mega-dropdown__col--narrow', $classes)) $col_classes[] = 'mega-dropdown__col--narrow';
            if (in_array('mega-dropdown__col--labs', $classes)) $col_classes[] = 'mega-dropdown__col--labs';
            
            $col_class_names = join(' ', array_unique($col_classes));

            $output .= $indent . '<div class="' . esc_attr($col_class_names) . '">' . $n;
            $output .= $indent . "\t" . '<span class="mega-dropdown__label">' . esc_html($item->title) . '</span>' . $n;
            
            $this->current_col++;
            
        } elseif ( $depth === 2 ) {
            if ( $args->walker->has_children ) {
                // Determine if it needs grouped styling
                // We add mega-dropdown__list--grouped to the parent ul in start_lvl? We can't change it easily now, so let's just make it work.
                $output .= $indent . '<li class="mega-dropdown__group">' . $n;
                $output .= $indent . "\t" . '<span class="mega-dropdown__sublabel">' . esc_html($item->title) . '</span>' . $n;
            } else {
                $classes[] = '';
                $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

                $output .= $indent . '<li' . $class_names .'>';

                $atts = array();
                $atts['href'] = ! empty( $item->url ) ? $item->url : '';

                $attributes = '';
                foreach ( $atts as $attr => $value ) {
                    if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                        $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }

                $title = apply_filters( 'the_title', $item->title, $item->ID );
                $item_output = $args->before;
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;

                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
        } elseif ( $depth === 3 ) {
            $atts = array();
            $atts['href'] = ! empty( $item->url ) ? $item->url : '';

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $title = apply_filters( 'the_title', $item->title, $item->ID );
            $item_output = $args->before;
            $item_output .= $indent . '<a'. $attributes .'>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>' . $n;
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $n = "\n";
        
        if ( $depth === 0 ) {
            $output .= "</li>{$n}";
            $this->current_col = 0; // Reset column counter
        } elseif ( $depth === 1 ) {
            // End of column label (handled)
        } elseif ( $depth === 2 ) {
            // Could be li or group
            // For both, we close </li> if it was opened
            $args = apply_filters( 'nav_menu_item_args', $args, $data_object, $depth );
            // Wait, we always opened an <li> at depth 2
            $output .= "</li>{$n}";
        } elseif ( $depth === 3 ) {
            // Just an <a> tag
        }
    }
}
