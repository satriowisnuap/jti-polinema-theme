<?php

/**
 * Top Header - Contact Info, Shortcuts, Language Switcher
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

$topbar_enabled = get_theme_mod('jti_topbar_enabled', true);
if (! $topbar_enabled) {
	return;
}

$email = get_theme_mod('jti_topbar_email', 'jti@polinema.ac.id');
$phone_text = get_theme_mod('jti_topbar_phone', '(0341) 404424');
$phone_link = get_theme_mod('jti_topbar_phone_link', '+(0341) 404424');

$links = [
	[
		'label' => get_theme_mod('jti_topbar_link_label_1', 'Mahasiswa'),
		'url'   => get_theme_mod('jti_topbar_link_url_1', site_url('/mahasiswa')),
	],
	[
		'label' => get_theme_mod('jti_topbar_link_label_2', 'Lecturer'),
		'url'   => get_theme_mod('jti_topbar_link_url_2', site_url('/lecturer')),
	],
	[
		'label' => get_theme_mod('jti_topbar_link_label_3', 'Calon Mahasiswa'),
		'url'   => get_theme_mod('jti_topbar_link_url_3', 'https://spmb.polinema.ac.id/'),
	],
	[
		'label' => get_theme_mod('jti_topbar_link_label_4', 'Alumni'),
		'url'   => get_theme_mod('jti_topbar_link_url_4', 'https://alumni.polinema.ac.id/'),
	],
];

$lang_enabled = get_theme_mod('jti_topbar_lang_enabled', true);
$cookie_lang = 'id';
if (isset($_COOKIE['googtrans']) && strpos($_COOKIE['googtrans'], '/en') !== false) {
    $cookie_lang = 'en';
}
$lang_active = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : $cookie_lang;

$custom_en_url = get_theme_mod('jti_topbar_lang_en_url', '#');
$lang_en_url = ($custom_en_url === '#' || empty($custom_en_url)) ? add_query_arg('lang', 'en') : $custom_en_url;

$custom_id_url = get_theme_mod('jti_topbar_lang_id_url', '#');
$lang_id_url = ($custom_id_url === '#' || empty($custom_id_url)) ? add_query_arg('lang', 'id') : $custom_id_url;

$lang_en_icon = get_theme_mod('jti_topbar_lang_en_icon', get_template_directory_uri() . '/assets/images/icons/flag-en.svg');
$lang_id_icon = get_theme_mod('jti_topbar_lang_id_icon', get_template_directory_uri() . '/assets/images/icons/flag-id.svg');
?>

<div class="top-header b4">
	<div class="container container--wide">
		<div class="top-header-content">
			<!-- Left: Contact Info -->
			<div class="top-header-left">
				<?php if ($email) : ?>
					<span class="top-header-item">
						<i class="ph ph-envelope"></i>
						<a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
					</span>
				<?php endif; ?>
				<?php if ($phone_text) : ?>
					<span class="top-header-item">
						<i class="ph ph-phone"></i>
						<a href="tel:<?php echo esc_attr($phone_link); ?>"><?php echo esc_html($phone_text); ?></a>
					</span>
				<?php endif; ?>
			</div>
			<div class="top-header-right">
				<!-- Center: Shortcuts -->
				<div class="top-header-menu">
					<nav>
						<?php foreach ($links as $index => $link) : ?>
							<?php if (! empty($link['label']) && ! empty($link['url'])) : ?>
								<?php if ($index === 0) : // First link is Mahasiswa ?>
									<a href="#" id="mahasiswa-modal-trigger"><?php echo esc_html($link['label']); ?></a>
								<?php elseif ($index === 1) : // Second link is Lecturer ?>
									<a href="#" id="dosen-modal-trigger"><?php echo esc_html($link['label']); ?></a>
								<?php else : ?>
									<a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</nav>
				</div>
				<span>
					<!-- Separator -->
					<span class="shortcut-separator">|</span>
				</span>

				<!-- Right: Language Switcher -->
				<?php if ($lang_enabled) : ?>
					<div class="language-switcher">
						<a href="#" class="lang-btn <?php echo ($lang_active === 'en') ? 'active' : ''; ?>" title="English" onclick="event.preventDefault(); changeLanguage('en');">
							<img src="<?php echo esc_url($lang_en_icon); ?>" alt="English">
						</a>
						<a href="#" class="lang-btn <?php echo ($lang_active === 'id') ? 'active' : ''; ?>" title="Indonesia" onclick="event.preventDefault(); changeLanguage('id');">
							<img src="<?php echo esc_url($lang_id_icon); ?>" alt="Indonesia">
						</a>
					</div>
					<script>
					function changeLanguage(lang) {
						var host = window.location.hostname;
						// Clear old cookies
						document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
						document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + host;
						document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + host;
						
						// Set new cookie
						var val = "/id/" + lang;
						document.cookie = "googtrans=" + val + "; path=/";
						document.cookie = "googtrans=" + val + "; path=/; domain=" + host;
						document.cookie = "googtrans=" + val + "; path=/; domain=." + host;
						
						// Clean URL from old lang param and reload
						var url = new URL(window.location.href);
						url.searchParams.delete('lang');
						window.location.href = url.href;
					}
					</script>
				<?php endif; ?>
			</div>

		</div>
	</div>
</div>