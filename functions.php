<?php

/* ========================================
   THEME SETUP
======================================= */

require_once get_template_directory() . '/inc/setup/theme-support.php';
require_once get_template_directory() . '/inc/setup/enqueue.php';
require_once get_template_directory() . '/inc/setup/menus.php';
require_once get_template_directory() . '/inc/setup/customizer.php';
require_once get_template_directory() . '/inc/setup/hooks.php';
require_once get_template_directory() . '/inc/setup/post-types.php';

/* ========================================
   HELPERS
======================================== */

require_once get_template_directory() . '/inc/helpers/content.php';
require_once get_template_directory() . '/inc/helpers/formatting.php';
require_once get_template_directory() . '/inc/helpers/query.php';
require_once get_template_directory() . '/inc/helpers/stats.php';
require_once get_template_directory() . '/inc/helpers/template-tags.php';
require_once get_template_directory() . '/inc/helpers/mega-menu-walker.php';
require_once get_template_directory() . '/inc/helpers/sidebar-menu-walker.php';

/* ========================================
   INTEGRATIONS
======================================== */

require_once get_template_directory() . '/inc/integrations/acf.php';
require_once get_template_directory() . '/inc/integrations/ajax.php';
require_once get_template_directory() . '/inc/integrations/api.php';
require_once get_template_directory() . '/inc/integrations/migrations.php';
require_once get_template_directory() . '/inc/integrations/google-maps.php';

