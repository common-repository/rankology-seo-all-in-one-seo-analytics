<?php
/*
Plugin Name: Rankology SEO – All in One SEO & Analytics
Plugin URI: https://rankology.io/
Description: One of the best SEO plugin for WordPress fully integrated with all page builders and themes. Rank higher in search engines, fully white label.
Author: Team Rankology
Version: 1.0
Author URI: https://rankology.io/?utm_source=Plugin&utm_campaign=WP
License: GPLv2
Text Domain: wp-rankology
Domain Path: /languages
Requires PHP: 7.2
Requires at least: 6.0
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

// To prevent calling the plugin directly
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('RANKOLOGY_PLUGIN_URL', plugin_dir_url(__FILE__));


include_once dirname(__FILE__) . '/inc/rankology-general.php';

//CRON
function rankology_cron() {
	//CRON - Ping Google for XML Sitemaps
	if ( ! wp_next_scheduled('rankology_xml_sitemaps_ping_cron')) {
		wp_schedule_event(time(), 'daily', 'rankology_xml_sitemaps_ping_cron');
	}
}

//Hooks activation
function rankology_activation() {
	add_option('rankology_activated', 'yes');
	flush_rewrite_rules(false);

	rankology_cron();

	do_action('rankology_activation');
}
register_activation_hook(__FILE__, 'rankology_activation');

function rankology_deactivation() {

	delete_option('rankology_activated');
	flush_rewrite_rules(false);

	//Remove our CRON
	wp_clear_scheduled_hook('rankology_xml_sitemaps_ping_cron');

	do_action('rankology_deactivation');
}
register_deactivation_hook(__FILE__, 'rankology_deactivation');

//Define]
define('RANKOLOGY_VERSION', '1.0');
define('RANKOLOGY_AUTHOR', 'Team Rankology');
define('RANKOLOGY_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('RANKOLOGY_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('RANKOLOGY_ASSETS_DIR', RANKOLOGY_PLUGIN_DIR_URL . 'assets');
define('RANKOLOGY_TEMPLATE_DIR', RANKOLOGY_PLUGIN_DIR_PATH . 'templates');
define('RANKOLOGY_TEMPLATE_SITEMAP_DIR', RANKOLOGY_TEMPLATE_DIR . '/sitemap');
define('RANKOLOGY_TEMPLATE_JSON_SCHEMAS', RANKOLOGY_TEMPLATE_DIR . '/json-schemas');
define('RANKOLOGY_DIRURL', plugin_dir_url(__FILE__));
define('RANKOLOGY_URL_PUBLIC', RANKOLOGY_DIRURL . 'public');
define('RANKOLOGY_URL_ASSETS', RANKOLOGY_DIRURL . 'assets');
define('RANKOLOGY_DIR_LANGUAGES', dirname(plugin_basename(__FILE__)) . '/languages/');

// Enqueue styles and scripts
function rankology_enqueue_assets() {
    // Register common CSS
    wp_register_style('rankology-common-css', RANKOLOGY_ASSETS_DIR . '/css/rankology-common.css', array(), RANKOLOGY_VERSION);
    // Enqueue common CSS
    wp_enqueue_style('rankology-common-css');

    // Register common JS
    wp_register_script('rankology-common-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-common.js', array('jquery'), RANKOLOGY_VERSION, true);
    // Enqueue common JS
    wp_enqueue_script('rankology-common-js');
}
add_action('wp_enqueue_scripts', 'rankology_enqueue_assets');

// Enqueue admin styles and scripts if needed
function rankology_enqueue_admin_assets() {
    // Register and enqueue admin CSS and JS here if necessary
    wp_register_style('rankology-admin-css', RANKOLOGY_ASSETS_DIR . '/css/rankology-common-admin.css', array(), RANKOLOGY_VERSION);
    wp_enqueue_style('rankology-admin-css');

    wp_register_script('rankology-admin-js', RANKOLOGY_ASSETS_DIR . '/js/rankology-common-admin.js', array('jquery'), RANKOLOGY_VERSION, true);
    wp_enqueue_script('rankology-admin-js');

    // Localize script to pass PHP variables to JavaScript
    wp_localize_script('rankology-admin-js', 'rankology_vars', array(
        'toggle_txt_on' => '<span class="dashicons dashicons-visibility"></span>' . esc_html__('Click to display any SEO metaboxes / columns for this post type', 'wp-rankology'),
        'toggle_txt_off' => '<span class="dashicons dashicons-visibility"></span>' . esc_html__('Click to hide any SEO metaboxes / columns for this post type', 'wp-rankology')
    ));
}
add_action('admin_enqueue_scripts', 'rankology_enqueue_admin_assets');

use Rankology\Core\Kernel;

require_once __DIR__ . '/rankology-autoload.php';

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/rankology-functions.php';
	require_once __DIR__ . '/inc/admin/cron.php';

	Kernel::execute([
		'file'      => __FILE__,
		'slug'      => 'wp-rankology',
		'main_file' => 'rankology',
		'root'      => __DIR__,
	]);
}

function rankology_init($hook) {
	//CRON
	rankology_cron();

	//
	global $pagenow;
	global $typenow;
	global $wp_version;

	if (is_admin() || is_network_admin()) {
		require_once dirname(__FILE__) . '/inc/admin/plugin-upgrader.php';
		require_once dirname(__FILE__) . '/inc/admin/admin.php';
		require_once dirname(__FILE__) . '/inc/admin/migrate/MigrationTools.php';

		if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
			if ('rankology_schemas' != $typenow) {
				require_once dirname(__FILE__) . '/inc/admin/metaboxes/admin-metaboxes.php';
			}
		}
		if ('term.php' == $pagenow || 'edit-tags.php' == $pagenow) {
			require_once dirname(__FILE__) . '/inc/admin/metaboxes/admin-term-metaboxes.php';
		}
		require_once dirname(__FILE__) . '/inc/admin/ajax.php';
		if (defined('RANKOLOGY_WL_ADMIN_HEADER') && RANKOLOGY_WL_ADMIN_HEADER === false) {
			//do not load the Rankology admin header
		} else {
			require_once dirname(__FILE__) . '/inc/admin/admin-bar/admin-header.php';
		}
	}

	require_once dirname(__FILE__) . '/inc/functions/options.php';

	remove_action('wp_head', 'rel_canonical'); //remove default WordPress Canonical

	// Block Editor
	if (version_compare($wp_version, '5.0', '>=')) {
		include_once dirname(__FILE__) . '/inc/admin/page-builders/gutenberg/blocks.php';
	}

	// Classic Editor
	if ( is_admin() ) {
		include_once dirname(__FILE__) . '/inc/admin/page-builders/classic/classic-editor.php';
	}

}
add_action('plugins_loaded', 'rankology_init', 999);

/**
 * Render dynamic variables
 * @param array $variables
 * @param object $post
 * @param boolean $is_oembed
 * @return array $variables
 */
function rankology_dyn_variables_init($variables, $post = '', $is_oembed = false) {
	include_once dirname(__FILE__) . '/inc/functions/variables/dynamic-variables.php';
	return Rankology\Helpers\CachedMemoizeFunctions::memoize('rankology_get_dynamic_variables')($variables, $post, $is_oembed);
}
add_filter('rankology_dyn_variables_fn', 'rankology_dyn_variables_init', 10, 3);

//RANKOLOGY Options page
function rankology_add_admin_options_scripts($hook) {
	$prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	wp_register_style('rankology-admin', plugins_url('assets/css/rankology.min.css', __FILE__), [], RANKOLOGY_VERSION);
	wp_enqueue_style('rankology-admin');

	if ( ! isset($_GET['page'])) {
		return;
	}

	if ('rankology-network-option' === rankology_common_esc_str($_GET['page'])) {
		wp_enqueue_script('rankology-network-tabs', plugins_url('assets/js/rankology-network-tabs' . $prefix . '.js', __FILE__), ['jquery'], RANKOLOGY_VERSION, true);
	}

	//Toggle / Notices JS
	$_pages = [
		'rankology-fno-page'             => true,
		'rankology-instant-indexing'     => true,
		'rankology-option'               => true,
		'rankology-network-option'       => true,
		'rankology-titles'               => true,
		'rankology-xml-sitemap'          => true,
		'rankology-insights-backlinks'   => true,
		'rankology-insights-competitors' => true,
		'rankology-social'               => true,
		'rankology-google-analytics'     => true,
		'rankology-import-export'        => true,
		'rankology-bot-batch'            => true,
		'rankology-bot-metaboxes'        => true,
		'rankology-license'              => true,
		'rankology-insights'             => true,
		'rankology-insights-rankings'    => true,
		'rankology-insights-trends'      => true,
		'rankology-insights-settings'    => true,
		'rankology-insights-license'     => true,
	];
	if (isset($_pages[$_GET['page']])) {
		wp_enqueue_script('rankology-toggle-ajax', plugins_url('assets/js/rankology-dashboard' . $prefix . '.js', __FILE__), ['jquery'], RANKOLOGY_VERSION, true);

		//Features
		$rankology_toggle_features = [
			'rankology_nonce'           => wp_create_nonce('rankology_toggle_features_nonce'),
			'rankology_toggle_features' => admin_url('admin-ajax.php'),
			'i18n'                     => esc_html__('has been successfully updated!', 'wp-rankology'),
		];
		wp_localize_script('rankology-toggle-ajax', 'rankologyAjaxToggleFeatures', $rankology_toggle_features);

		//Notices
		$rankology_hide_notices = [
			'rankology_nonce'        => wp_create_nonce('rankology_hide_notices_nonce'),
			'rankology_hide_notices' => admin_url('admin-ajax.php'),
		];
		wp_localize_script('rankology-toggle-ajax', 'rankologyAjaxHideNotices', $rankology_hide_notices);

		//News panel
		$rankology_news = [
			'rankology_nonce'        => wp_create_nonce('rankology_news_nonce'),
			'rankology_news'         => admin_url('admin-ajax.php'),
		];
		wp_localize_script('rankology-toggle-ajax', 'rankologyAjaxNews', $rankology_news);

		//Display panel
		$rankology_display = [
			'rankology_nonce'        => wp_create_nonce('rankology_display_nonce'),
			'rankology_display'      => admin_url('admin-ajax.php'),
		];
		wp_localize_script('rankology-toggle-ajax', 'rankologyAjaxDisplay', $rankology_display);

	}

	//Migration
	if ('rankology-option' === rankology_common_esc_str($_GET['page']) || 'rankology-import-export' === rankology_common_esc_str($_GET['page'])) {
		wp_enqueue_script('rankology-migrate-ajax', plugins_url('assets/js/rankology-migrate' . $prefix . '.js', __FILE__), ['jquery'], RANKOLOGY_VERSION, true);

		$rankology_migrate = [
			'rankology_aio_migrate'				=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_aio_migrate_nonce'),
				'rankology_aio_migration'				=> admin_url('admin-ajax.php'),
			],
			'rankology_yoast_migrate'			=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_yoast_migrate_nonce'),
				'rankology_yoast_migration'				=> admin_url('admin-ajax.php'),
			],
			'rankology_seo_framework_migrate'	=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_seo_framework_migrate_nonce'),
				'rankology_seo_framework_migration'		=> admin_url('admin-ajax.php'),
			],
			'rankology_rk_migrate'				=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_rk_migrate_nonce'),
				'rankology_rk_migration'					=> admin_url('admin-ajax.php'),
			],
			'rankology_squirrly_migrate'			=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_squirrly_migrate_nonce'),
				'rankology_squirrly_migration'			=> admin_url('admin-ajax.php'),
			],
			'rankology_seo_ultimate_migrate'		=> [
				'rankology_nonce' 						=> wp_create_nonce('rankology_seo_ultimate_migrate_nonce'),
				'rankology_seo_ultimate_migration'		=> admin_url('admin-ajax.php'),
			],
			'rankology_wp_meta_seo_migrate'		=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_meta_seo_migrate_nonce'),
				'rankology_wp_meta_seo_migration'		=> admin_url('admin-ajax.php'),
			],
			'rankology_premium_seo_pack_migrate'	=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_premium_seo_pack_migrate_nonce'),
				'rankology_premium_seo_pack_migration'	=> admin_url('admin-ajax.php'),
			],
			'rankology_wpseo_migrate'			=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_wpseo_migrate_nonce'),
				'rankology_wpseo_migration'				=> admin_url('admin-ajax.php'),
			],
			'rankology_platinum_seo_migrate'		=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_platinum_seo_migrate_nonce'),
				'rankology_platinum_seo_migration'		=> admin_url('admin-ajax.php'),
			],
			'rankology_smart_crawl_migrate'		=> [
				'rankology_nonce'						=> wp_create_nonce('rankology_smart_crawl_migrate_nonce'),
				'rankology_smart_crawl_migration'		=> admin_url('admin-ajax.php'),
			],
			'rankology_rankologyor_migrate'		=> [
				'rankology_nonce' 						=> wp_create_nonce('rankology_rankologyor_migrate_nonce'),
				'rankology_rankologyor_migration' 		=> admin_url('admin-ajax.php'),
			],
			'rankology_slim_seo_migrate'			=> [
				'rankology_nonce' 						=> wp_create_nonce('rankology_slim_seo_migrate_nonce'),
				'rankology_slim_seo_migration' 			=> admin_url('admin-ajax.php'),
			],
			'rankology_metadata_csv'				=> [
				'rankology_nonce' 						=> wp_create_nonce('rankology_export_csv_metadata_nonce'),
				'rankology_metadata_export' 				=> admin_url('admin-ajax.php'),
			],
			'i18n'								=> [
				'migration' 							=> esc_html__('Migration completed!', 'wp-rankology'),
				'video' 								=> esc_html__('Regeneration completed!', 'wp-rankology'),
				'export' 								=> esc_html__('Export completed!', 'wp-rankology'),
			],
		];
		wp_localize_script('rankology-migrate-ajax', 'rankologyAjaxMigrate', $rankology_migrate);

		//Force regenerate video xml sitemap
		$rankology_video_regenerate = [
			'rankology_nonce'        					=> wp_create_nonce('rankology_video_regenerate_nonce'),
			'rankology_video_regenerate'					=> admin_url('admin-ajax.php'),
		];
		wp_localize_script('rankology-migrate-ajax', 'rankologyAjaxVdeoRegenerate', $rankology_video_regenerate);
	}

	//Tabs
	if ('rankology-titles' === rankology_common_esc_str($_GET['page']) || 'rankology-xml-sitemap' === rankology_common_esc_str($_GET['page']) || 'rankology-social' === rankology_common_esc_str($_GET['page']) || 'rankology-google-analytics' === rankology_common_esc_str($_GET['page']) || 'rankology-metaboxes' === rankology_common_esc_str($_GET['page']) || 'rankology-import-export' === rankology_common_esc_str($_GET['page']) || 'rankology-instant-indexing' === rankology_common_esc_str($_GET['page']) || 'rankology-insights-settings' === rankology_common_esc_str($_GET['page'])) {
		wp_enqueue_script('rankology-admin-tabs-js', plugins_url('assets/js/rankology-tabs' . $prefix . '.js', __FILE__), ['jquery-ui-tabs'], RANKOLOGY_VERSION);
	}

	if ('rankology-google-analytics' === rankology_common_esc_str($_GET['page'])) {
		wp_enqueue_style('wp-color-picker');

		wp_enqueue_script('wp-color-picker-alpha', plugins_url('assets/js/wp-color-picker-alpha.min.js', __FILE__), ['wp-color-picker'], RANKOLOGY_VERSION, true);
		$color_picker_strings = [
			'clear'            => esc_html__('Clear', 'wp-rankology'),
			'clearAriaLabel'   => esc_html__('Clear color', 'wp-rankology'),
			'defaultString'    => esc_html__('Default', 'wp-rankology'),
			'defaultAriaLabel' => esc_html__('Select default color', 'wp-rankology'),
			'pick'             => esc_html__('Select Color', 'wp-rankology'),
			'defaultLabel'     => esc_html__('Color value', 'wp-rankology'),
		];
		wp_localize_script('wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings);
	}

	if ('rankology-social' === rankology_common_esc_str($_GET['page'])) {
		wp_enqueue_script('rankology-media-uploader-js', plugins_url('assets/js/rankology-media-uploader' . $prefix . '.js', __FILE__), ['jquery'], RANKOLOGY_VERSION, false);
		wp_enqueue_media();
	}

	//Instant Indexing
	if ('rankology-instant-indexing' === rankology_common_esc_str($_GET['page'])) {
		$rankology_instant_indexing_post = [
			'rankology_nonce'					=> wp_create_nonce('rankology_instant_indexing_post_nonce'),
			'rankology_instant_indexing_post'	=> admin_url('admin-ajax.php'),
		];
		wp_localize_script('rankology-admin-tabs-js', 'rankologyAjaxInstantIndexingPost', $rankology_instant_indexing_post);

		$rankology_instant_indexing_generate_api_key = [
			'rankology_nonce'								=> wp_create_nonce('rankology_instant_indexing_generate_api_key_nonce'),
			'rankology_instant_indexing_generate_api_key'	=> admin_url('admin-ajax.php'),
		];
		wp_localize_script('rankology-admin-tabs-js', 'rankologyAjaxInstantIndexingApiKey', $rankology_instant_indexing_generate_api_key);
	}

	//CSV Importer
	if ('rankology_csv_importer' === rankology_common_esc_str($_GET['page'])) {
		wp_enqueue_style('rankology-setup', plugins_url('assets/css/rankology-setup' . $prefix . '.css', __FILE__), ['dashicons'], RANKOLOGY_VERSION);
	}
}

add_action('admin_enqueue_scripts', 'rankology_add_admin_options_scripts', 10, 1);

//RANKOLOGY Admin bar
function rankology_admin_bar_css() {
	$prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	if (is_user_logged_in() && '1' !== rankology_get_service('AdvancedOption')->getAppearanceAdminBar()) {
		if (is_admin_bar_showing()) {
			wp_register_style('rankology-admin-bar', plugins_url('assets/css/rankology-admin-bar' . $prefix . '.css', __FILE__), [], RANKOLOGY_VERSION);
			wp_enqueue_style('rankology-admin-bar');
		}
	}
}
add_action('init', 'rankology_admin_bar_css', 12, 1);

//Quick Edit
function rankology_add_admin_options_scripts_quick_edit() {
	$prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script('rankology-quick-edit', plugins_url('assets/js/rankology-quick-edit' . $prefix . '.js', __FILE__), ['jquery', 'inline-edit-post'], RANKOLOGY_VERSION, true);
}
add_action('admin_print_scripts-edit.php', 'rankology_add_admin_options_scripts_quick_edit');

function rankology_esc_form_val($value) {
	return $value;
}

//Admin Body Class
add_filter('admin_body_class', 'rankology_admin_body_class', 100);
function rankology_admin_body_class($classes) {
	if ( ! isset($_GET['page'])) {
		return $classes;
	}
	$_pages = [
		'rankology_csv_importer'             => true,
		'rankology-option'                   => true,
		'rankology-network-option'           => true,
		'rankology-titles'                   => true,
		'rankology-xml-sitemap'              => true,
		'rankology-social'                   => true,
		'rankology-imageseo'                 => true,
		'rankology-google-analytics'         => true,
		'rankology-import-export'            => true,
		'rankology-fno-page'                 => true,
		'rankology-metaboxes'                => true,
		'rankology-instant-indexing'         => true,
		'rankology-bot-batch'                => true,
		'rankology-license'                  => true
	];
	if (isset($_pages[$_GET['page']])) {
		$classes .= ' rankology-styles ';
	}
    if (isset($_pages[$_GET['page']]) && 'rankology-option' === rankology_common_esc_str($_GET['page'])) {
		$classes .= ' rankology-dashboard ';
	}
	if (isset($_pages[$_GET['page']]) && 'rankology_csv_importer' === rankology_common_esc_str($_GET['page'])) {
		$classes .= ' rankology-setup ';
	}

	return $classes;
}

/**
 * Handle WPML compatibility for XML sitemaps
 * @todo to be moved to render.php
 */
if ('1' == rankology_get_service('SitemapOption')->isEnabled() && '1' == rankology_get_toggle_option('xml-sitemap')) {
	//WPML compatibility
	if (defined('ICL_SITEPRESS_VERSION')) {
		//Check if WPML is not setup as multidomain
		if ( 2 != apply_filters( 'wpml_setting', false, 'rankology_rankology_language_negotiation_type' ) ) {
			add_filter('request', 'rankology_wpml_block_secondary_languages');
		}
	}

	function rankology_wpml_block_secondary_languages($q) {
		$current_language = apply_filters('wpml_current_language', false);
		$default_language = apply_filters('wpml_default_language', false);
		if ($current_language !== $default_language) {
			unset($q['rankology_sitemap']);
			unset($q['rankology_cpt']);
			unset($q['rankology_paged']);
			unset($q['rankology_author']);
			unset($q['rankology_sitemap_xsl']);
			unset($q['rankology_sitemap_video_xsl']);
		}

		return $q;
	}
}

add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'rankology_admin_menu_order', 9);

function rankology_admin_menu_order($menu_order)
{

	$rankology_posts_arr = array(
		'rankology-option',
		'rankology_rkns_overview_page'
	);

	$rankology_posts_arr = apply_filters('rankology_main_wp_menu_list', $rankology_posts_arr);

	$rankology_menu_order = array();

	$cus_menu_order = array();

	foreach ($menu_order as $index => $item) {

		if ('rankology-option' === $item) {
			$cus_menu_order[] = $item;
			$cus_menu_order[] = 'rankology_rkns_overview_page';
			//
			$cus_menu_order = apply_filters('rankology_main_wp_menu_order', $cus_menu_order);
			$rankology_menu_order = array_merge($rankology_menu_order, $cus_menu_order);
			//
		} elseif (!in_array($item, $rankology_posts_arr, true)) {
			$rankology_menu_order[] = $item;
		}
	}

	return $rankology_menu_order;
}
