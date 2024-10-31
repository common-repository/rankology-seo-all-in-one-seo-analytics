<?php

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Kernel;

/**
 * Get a service.
 *
 * @param string $service
 *
 * @return object
 */
function rankology_get_service($service) {
    return Kernel::getContainer()->getServiceByName($service);
}

function rankology_common_esc_str($input) {
    $input = esc_html(sanitize_text_field($input));
    return $input;
}

function rankology_common_esc_textarea($input) {
    $input = esc_textarea($input);
    return $input;
}

function rankology_common_esc_url($input) {
    $input = esc_url($input);
    return $input;
}

function rankology_esc_extra_html($input) {
    $input = wp_kses_post($input);
    return $input;
}

/*
 * Get first key of an array if PHP < 7.3
 * @return string
 * @author Team Rankology
 */
if ( ! function_exists('rankology_array_key_first')) {
    function rankology_array_key_first(array $arr) {
        foreach ($arr as $key => $unused) {
            return $key;
        }

        return null;
    }
}

/*
 * Get last key of an array if PHP < 7.3
 * @return string
 * @author Team Rankology
 */
if ( ! function_exists('rankology_array_key_last')) {
    function rankology_array_key_last(array $arr) {
        end($arr);
        $key = key($arr);

        return $key;
    }
}

/*
 * Remove WP default meta robots (added in WP 5.7)
 */
remove_filter('wp_robots', 'wp_robots_max_image_preview_large');

/*
 * Remove WC default meta robots (added in WP 5.7)
 *
 */
function rankology_robots_wc_pages($robots) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if (is_plugin_active('woocommerce/woocommerce.php')) {
		if (function_exists('wc_get_page_id')) {
			if (is_page(wc_get_page_id('cart')) || is_page(wc_get_page_id('checkout')) || is_page(wc_get_page_id('myaccount'))) {
				if ('0' === get_option('blog_public')) {
					return $robots;
				} else {
					unset($robots);
					$robots = [];

					return $robots;
				}
			}
		}
	}
	//remove noindex on search archive pages
	if (is_search()) {
		if ('0' === get_option('blog_public')) {
			return $robots;
		} else {
			unset($robots);
			$robots = [];

			return $robots;
		}
	}

	return $robots;
}
add_filter('wp_robots', 'rankology_robots_wc_pages', 20);

/**
 * Remove default WC meta robots.
 */
function rankology_compatibility_woocommerce() {
	if (function_exists('is_plugin_active')) {
		if (is_plugin_active('woocommerce/woocommerce.php') && ! is_admin()) {
			remove_action('wp_head', 'wc_page_noindex');
		}
	}
}
add_action('wp_head', 'rankology_compatibility_woocommerce', 0);

/**
 * Remove Jetpack OpenGraph tags.
 */
function rankology_compatibility_jetpack() {
	if (function_exists('is_plugin_active')) {
		if (is_plugin_active('jetpack/jetpack.php') && ! is_admin()) {
			add_filter('jetpack_enable_open_graph', '__return_false');
			add_filter('jetpack_disable_seo_tools', '__return_true');
		}
	}
}
add_action('wp_head', 'rankology_compatibility_jetpack', 0);

/**
 * Filter the xml sitemap URL used by SiteGround Optimizer for preheating.
 *
 *
 * @param string $url URL to be preheated.
 */
if (function_exists('is_plugin_active')) {
    if (is_plugin_active('sg-cachepress/sg-cachepress.php')) {
        function rankology_rkseo_sg_file_caching_preheat_xml($url) {
            $url = get_home_url() . '/sitemaps.xml';

            return $url;
        }
        add_filter('sg_file_caching_preheat_xml', 'rankology_rkseo_sg_file_caching_preheat_xml');
    }
}

/**
 * Remove WPML home url filter.
 *
 *
 * @param mixed $home_url
 * @param mixed $url
 * @param mixed $path
 * @param mixed $orig_scheme
 * @param mixed $blog_id
 */
function rankology_remove_wpml_home_url_filter($home_url, $url, $path, $orig_scheme, $blog_id) {
	return $url;
}

/*
 * Remove third-parties metaboxes on our CPT
 * @author Team Rankology 
 */
add_action('do_meta_boxes', 'rankology_remove_metaboxes', 10);
function rankology_remove_metaboxes() {
	//Oxygen Builder
	remove_meta_box('ct_views_cpt', 'rankology_404', 'normal');
	remove_meta_box('ct_views_cpt', 'rankology_schemas', 'normal');
	remove_meta_box('ct_views_cpt', 'rankology_bot', 'normal');
}

function rankology_titles_single_cpt_enable_option($cpt) {
    return rankology_get_service('TitleOption')->getSingleCptEnable($cpt);
}


function rankology_advanced_appearance_ps_col_option() {
    return rankology_get_service('AdvancedOption')->getAppearancePsCol();
}


function rankology_get_post_types() {
    return rankology_get_service('WordPressData')->getPostTypes();
}

function rankology_get_taxonomies($with_terms = false) {
    $args = [
        'show_ui' => true,
        'public'  => true,
    ];
    $args = apply_filters('rankology_get_taxonomies_args', $args);

    $output     = 'objects'; // or objects
    $operator   = 'and'; // 'and' or 'or'
    $taxonomies = get_taxonomies($args, $output, $operator);

    unset(
        $taxonomies['rankology_bl_competitors']
    );

    $taxonomies = apply_filters('rankology_get_taxonomies_list', $taxonomies);

    if ( ! $with_terms) {
        return $taxonomies;
    }

    foreach ($taxonomies as $_tax_slug => &$_tax) {
        $_tax->terms = get_terms(['taxonomy' => $_tax_slug]);
    }

    return $taxonomies;
}


/**
 * Get all custom fields (limit: 250).
 *
 * @author Team Rankology 
 *
 * @return array custom field keys
 */
function rankology_get_custom_fields() {
    $cf_keys = wp_cache_get('rankology_get_custom_fields');

    if (false === $cf_keys) {
        global $wpdb;

        $limit   = (int) apply_filters('postmeta_form_limit', 250);
        $cf_keys = $wpdb->get_col($wpdb->prepare("
			SELECT DISTINCT meta_key
			FROM $wpdb->postmeta
			GROUP BY meta_key
			HAVING meta_key NOT LIKE '\_%%'
			ORDER BY meta_key
			LIMIT %d", $limit));

        if (is_plugin_active('types/wpcf.php')) {
            $wpcf_fields = get_option('wpcf-fields');

            if ( ! empty($wpcf_fields)) {
                foreach ($wpcf_fields as $key => $value) {
                    $cf_keys[] = $value['meta_key'];
                }
            }
        }

        $cf_keys = apply_filters('rankology_get_custom_fields', $cf_keys);

        if ($cf_keys) {
            natcasesort($cf_keys);
        }
        wp_cache_set('rankology_get_custom_fields', $cf_keys);
    }

    return $cf_keys;
}

/**
 * Check SSL for schema.org.
 *
 * @author Team Rankology 
 *
 * @return string correct protocol
 */
function rankology_check_ssl() {
    if (is_ssl()) {
        return 'https://';
    } else {
        return 'http://';
    }
}

/**
 * Check if a string is base64 encoded
 *
 * @author Team Rankology 
 *
 * @return boolean
 **/
function rankology_is_base64_string($str) {
	$decoded = base64_decode($str, true);
	if ($decoded === false) {
        return false;
	}
	return base64_encode($decoded) === $str;
}

/**
 * Get IP address.
 *
 * @author Team Rankology 
 *
 * @return (string) $ip
 **/
function rankology_get_ip_address() {
    $srv_arr = rankology_esc_serv_val();
    foreach (['HTTP_CLIENT_IP', 'HTTP_CF_CONNECTING_IP', 'HTTP_VIA', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
        if (true === array_key_exists($key, $srv_arr)) {
            foreach (explode(',', $srv_arr[$key]) as $ip) {
                $ip = trim($ip); // just to be safe

                return apply_filters('rankology_404_ip', $ip ? $ip : '');
            }
        }
    }
}

/**
 * Disable Query Monitor for CA.
 *
 * @return array
 *
 * @author Team Rankology
 *
 * @param mixed $url
 * @param mixed $allcaps
 * @param mixed $caps
 * @param mixed $args
 */
function rankology_disable_qm($allcaps, $caps, $args) {
    $allcaps['view_query_monitor'] = false;

    return $allcaps;
}
/**
 * Clear content for CA.
 *
 * @author Team Rankology
 */
function rankology_clean_content_analysis() {
    if (!is_user_logged_in()) {
        return;
    }
    if (current_user_can('edit_posts')) {
        if (isset($_GET['no_admin_bar']) && '1' === rankology_common_esc_str($_GET['no_admin_bar'])) {
            //Remove admin bar
            add_filter('show_admin_bar', '__return_false');

            //Disable Query Monitor
            add_filter('user_has_cap', 'rankology_disable_qm', 10, 3);

            //Disable wptexturize
            add_filter('run_wptexturize', '__return_false');

            //Remove Edit nofollow links from TablePress
            add_filter( 'tablepress_edit_link_below_table', '__return_false');

            //Oxygen compatibility
            if (function_exists('ct_template_output')) {
                add_action('template_redirect', 'rankology_get_oxygen_content');
            }

            //Allow user to run custom action to clean content
            do_action('rankology_content_analysis_cleaning');
        }
    }
}
add_action('plugins_loaded', 'rankology_clean_content_analysis');

/**
 * Test if a URL is in absolute.
 *
 * @return bool true if absolute
 *
 * @author Team Rankology
 *
 * @param mixed $url
 */
function rankology_is_absolute($url) {
    $pattern = "%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu";

    return (bool) preg_match($pattern, $url);
}

/**
 * Manage localized links.
 *
 * @return string locale for documentation links
 *
 * @author Team Rankology
 */
function rankology_get_locale() {
    switch (get_user_locale(get_current_user_id())) {
        case 'fr_FR':
        case 'fr_BE':
        case 'fr_CA':
        case 'fr_LU':
        case 'fr_MC':
        case 'fr_CH':
            $locale_link = 'fr';
        break;
        default:
            $locale_link = '';
        break;
    }

    return $locale_link;
}

/**
 * Returns the language code by supporting multilingual plugins
 *
 * 
 *
 * @return string language code
 *
 * @author Team Rankology
 */
function rankology_get_current_lang() {
    //Default
    $lang = get_locale();

    //Polylang
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language('locale');
    }

    //WPML
    if (defined('ICL_SITEPRESS_VERSION')) {
        $lang = apply_filters( 'wpml_current_language', NULL );
    }

    return $lang;
}

/**
 * Check empty global title template.
 *
 * 
 *
 * @param string $type
 * @param string $metadata
 * @param bool   $notice
 *
 * @return string notice with list of empty cpt titles
 *
 * @author Team Rankology
 */
function rankology_get_empty_templates($type, $metadata, $notice = true) {
    $cpt_titles_empty = [];
    $templates        = '';
    $data             = '';
    $html             = '';
    $list             = '';

    if ('cpt' === $type) {
        $templates   = $postTypes = rankology_get_service('WordPressData')->getPostTypes();
        $notice_i18n = esc_html__('Custom Post Types', 'wp-rankology');
    }
    if ('tax' === $type) {
        $templates   = rankology_get_service('WordPressData')->getTaxonomies();
        $notice_i18n = esc_html__('Custom Taxonomies', 'wp-rankology');
    }
    foreach ($templates as $key => $value) {
        $options            = get_option('rankology_titles_option_name');

        if (!empty($options)) {
            if ('cpt' === $type) {
                if (!empty($options['rankology_titles_single_titles'])) {
                    if (!array_key_exists($key, $options['rankology_titles_single_titles'])) {
                        $cpt_titles_empty[] = $key;
                    } else {
                        $data = isset($options['rankology_titles_single_titles'][$key][$metadata]) ? $options['rankology_titles_single_titles'][$key][$metadata] : '';
                    }
                }
            }
            if ('tax' === $type) {
                if (!empty($options['rankology_titles_tax_titles'])) {
                    if (!array_key_exists($key, $options['rankology_titles_tax_titles'])) {
                        $cpt_titles_empty[] = $key;
                    } else {
                        $data = isset($options['rankology_titles_tax_titles'][$key][$metadata]) ? $options['rankology_titles_tax_titles'][$key][$metadata] : '';
                    }
                }
            }
        }

        if (empty($data)) {
            $cpt_titles_empty[] = $key;
        }
    }

    if ( ! empty($cpt_titles_empty)) {
        $list .= '<ul>';
        foreach ($cpt_titles_empty as $cpt) {
            $list .= '<li>' . $cpt . '</li>';
        }
        $list .= '</ul>';

        if (false === $notice) {
            return $list;
        } else {

            $html .= $list;
            $html .= '</div>';

            return rankology_common_esc_str($html);
        }
    }
}

/**
 * Generate Permalink notice to prevent users change the permastructure on a live site.
 *
 * 
 *
 * @return string $message
 *
 * @author Team Rankology
 */
function rankology_notice_permalinks() {
    global $pagenow;
    if (isset($pagenow) && 'options-permalink.php' !== $pagenow) {
        return;
    }

    $class   = 'notice notice-warning';
    $message = '<strong>' . esc_html__('WARNING', 'wp-rankology') . '</strong>';
    $message .= '<p>' . esc_html__('Do NOT change your permalink structure on a production site. Changing URLs can severely damage your SEO.', 'wp-rankology') . '</p>';

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
}
add_action('admin_notices', 'rankology_notice_permalinks');

/**
 * Generate a notice on permalink settings sreen if URL rewriting is disabled.
 *
 * 
 *
 * @return string $message
 *
 * @author Team Rankology
 */
function rankology_notice_no_rewrite_url() {
    //Check we are on the Permalink settings page
    global $pagenow;
    if (isset($pagenow) && 'options-permalink.php' !== $pagenow) {
        return;
    }

    //Check permalink structure
    if ('' !== get_option('permalink_structure')) {
        return;
    }

    //Display the notice
    $class   = 'notice notice-warning';
    $message = '<strong>' . esc_html__('WARNING', 'wp-rankology') . '</strong>';
    $message .= '<p>' . esc_html__('URL rewriting is NOT enabled on your site. Select a permalink structure that is optimized for SEO (NOT Plain).', 'wp-rankology') . '</p>';

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
}
add_action('admin_notices', 'rankology_notice_no_rewrite_url');

/**
 * Generate Tooltip.
 *
 * 
 *
 * @param string $tooltip_title, $tooltip_desc, $tooltip_code
 * @param mixed  $tooltip_desc
 * @param mixed  $tooltip_code
 *
 * @return string tooltip title, tooltip description, tooltip url
 *
 * @author Team Rankology
 */
function rankology_tooltip($tooltip_title, $tooltip_desc, $tooltip_code) {
    $html =
    '<button type="button" class="rkseo-tooltip"><span class="dashicons dashicons-editor-help"></span>
	<span class="rkseo-tooltiptext" role="tooltip" tabindex="0">
		<span class="rkseo-tooltip-headings">' . $tooltip_title . '</span>
		<span class="rkseo-tooltip-desc">' . $tooltip_desc . '</span>
		<span class="rkseo-tooltip-code">' . $tooltip_code . '</span>
	</span></button>';

    return rankology_common_esc_str($html);
}

/**
 * Generate Tooltip (alternative version).
 *
 * 
 *
 * @param string $tooltip_title, $tooltip_desc, $tooltip_code
 * @param mixed  $tooltip_anchor
 * @param mixed  $tooltip_desc
 *
 * @return string tooltip title, tooltip description, tooltip url
 *
 * @author Team Rankology
 */
function rankology_tooltip_alt($tooltip_anchor, $tooltip_desc) {
    $html =
    '<button type="button" class="rkseo-tooltip alt">' . $tooltip_anchor . '
	<span class="rkseo-tooltiptext" role="tooltip" tabindex="0">
		<span class="rkseo-tooltip-desc">' . $tooltip_desc . '</span>
	</span>
	</button>';

    return rankology_common_esc_str($html);
}

/**
 * Generate Tooltip link.
 *
 * 
 *
 * @param string $tooltip_title, $tooltip_desc, $tooltip_code
 * @param mixed  $tooltip_anchor
 * @param mixed  $tooltip_desc
 *
 * @return string tooltip title, tooltip description, tooltip url
 *
 * @author Team Rankology
 */
function rankology_tooltip_link($tooltip_anchor, $tooltip_desc) {
    $html = '<a href="' . $tooltip_anchor . '"
    target="_blank" class="rankology-doc">
    <span class="dashicons dashicons-editor-help"></span>
    <span class="screen-reader-text">
        ' . $tooltip_desc . '
    </span>
</a>';

    return rankology_common_esc_str($html);
}

/**
 * Remove BOM.
 *
 * 
 *
 * @param mixed $text
 *
 * @return mixed $text
 *
 * @author Team Rankology
 */
function rankology_remove_utf8_bom($text) {
    $bom  = pack('H*', 'EFBBBF');
    $text = preg_replace("/^$bom/", '', $text);

    return $text;
}

/**
 * Generate notification (Notifications Center).
 *
 * 
 *
 * @param array $args
 *
 * @return string HTML notification
 *
 * @author Team Rankology
 */

 function rankology_notification($args) {
    remove_all_actions( 'rankology_notifications_center_item' );
    return;
}

/**
 * Filter the capability to allow other roles to use the plugin.
 *
 * 
 *
 * 
 *
 * @return string
 *
 * @param mixed $cap
 * @param mixed $context
 */
function rankology_capability($cap, $context = '') {
    $newcap = apply_filters('rankology_capability', $cap, $context);

    if ( ! current_user_can($newcap)) {
        return $cap;
    }

    return $newcap;
}

/**
 * Check if the page is one of ours.
 *
 * 
 *
 * 
 *
 * @return bool
 */
function rankology_is_rankology_page() {
    if ( ! is_admin() && ( ! isset($_REQUEST['page']) || ! isset($_REQUEST['post_type']))) {
        return false;
    }

    if (isset($_REQUEST['page'])) {
        return 0 === strpos($_REQUEST['page'], 'rankology');
    } elseif (isset($_REQUEST['post_type'])) {
        if (is_array($_REQUEST['post_type']) && !empty($_REQUEST['post_type'])) {
            return 0 === strpos($_REQUEST['post_type'][0], 'rankology');
        } else {
            return 0 === strpos($_REQUEST['post_type'], 'rankology');
        }
    }
}

/**
 * Only add our notices on our pages.
 *
 * 
 *
 * 
 *
 * @return bool
 */
function rankology_remove_other_notices() {
    if (rankology_is_rankology_page()) {
        remove_all_actions('network_admin_notices');
        remove_all_actions('admin_notices');
        remove_all_actions('user_admin_notices');
        remove_all_actions('all_admin_notices');
        add_action('admin_notices', 'rankology_admin_notices');
        
    }
}
add_action('in_admin_header', 'rankology_remove_other_notices', 1000);//keep this value high to remove other notices

/**
 * We replace the WP action by ours.
 *
 * 
 *
 * 
 *
 * @return bool
 */
function rankology_admin_notices() {
    do_action('rankology_admin_notices');
}

/**
 * Return the 7 days in correct order.
 *
 * 
 *
 * 
 *
 * @return bool
 */
function rankology_get_days() {
    $start_of_week = (int) get_option('start_of_week');

    return array_map(
        function () use ($start_of_week) {
            static $start_of_week;

            return ucfirst(date_i18n('l', strtotime($start_of_week++ - date('w', 0) . ' day', 0)));
        },
        array_combine(
            array_merge(
                array_slice(range(0, 6), $start_of_week, 7),
                array_slice(range(0, 6), 0, $start_of_week)
            ),
            range(0, 6)
        )
    );
}

/**
 * Check if a key exists in a multidimensional array.
 *
 * 
 *
 * @author Team Rankology 
 *
 * @return bool
 *
 * @param mixed $key
 */
function rankology_if_key_exists(array $arr, $key) {
    // is in base array?
    if (array_key_exists($key, $arr)) {
        return true;
    }

    // check arrays contained in this array
    foreach ($arr as $element) {
        if (is_array($element)) {
            if (rankology_if_key_exists($element, $key)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Get Oxygen Content for version 4.0
 *
 * 
 *
 * 
 *
 * @return null
 */
function rankology_get_oygen_content_v4($data, $content = ""){
    if(!is_array($data)){
        return $content;
    }

    if(isset($data['children'])){
        foreach($data['children'] as $child){
            $content = rankology_get_oygen_content_v4($child, $content);
        }
    }

    if(isset($data['options']['ct_content'])){
        $content .= $data['options']['ct_content'];
    }

    return $content . " ";

}

/**
 * Get Oxygen Content.
 *
 * 
 *
 * @author Team Rankology 
 *
 * @return null
 */
function rankology_get_oxygen_content() {
    $oxygen_metabox_enabled = get_option('oxygen_vsb_ignore_post_type_'.get_post_type(get_the_ID())) ? false : true;

    if (is_plugin_active('oxygen/functions.php') && function_exists('ct_template_output') && $oxygen_metabox_enabled === true) {
        if (!empty(get_post_meta(get_the_ID(), 'ct_builder_json', true))) {
            $oxygen_content = get_post_meta(get_the_ID(), 'ct_builder_json', true);
            $rankology_get_the_content = rankology_get_oygen_content_v4(json_decode($oxygen_content, true));
        } else {
            $rankology_get_the_content = ct_template_output(true); //shortcodes?
        }

        //Get post content
        if ( ! $rankology_get_the_content) {
            $rankology_get_the_content = apply_filters('the_content', get_post_field('post_content', get_the_ID()));
            $rankology_get_the_content = normalize_whitespace(wp_strip_all_tags($rankology_get_the_content));
        }

        if ($rankology_get_the_content) {
            //Get Target Keywords
            if (get_post_meta(get_the_ID(), '_rankology_analysis_target_kw', true)) {
                $rankology_analysis_target_kw = array_filter(explode(',', strtolower(esc_attr(get_post_meta(get_the_ID(), '_rankology_analysis_target_kw', true)))));

                $rankology_analysis_target_kw = apply_filters( 'rankology_content_analysis_target_keywords', $rankology_analysis_target_kw, get_the_ID() );

                //Keywords density
                foreach ($rankology_analysis_target_kw as $kw) {
                    if (preg_match_all('#\b(' . $kw . ')\b#iu', $rankology_get_the_content, $m)) {
                        $data['kws_density']['matches'][$kw][] = $m[0];
                    }
                }
            }

            //Words Counter
            $data['words_counter'] = preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", $rankology_get_the_content, $matches);

            if ( ! empty($matches[0])) {
                $words_counter_unique = count(array_unique($matches[0]));
            } else {
                $words_counter_unique = '0';
            }
            $data['words_counter_unique'] = $words_counter_unique;

            //Update analysis
            update_post_meta(get_the_ID(), '_rankology_analysis_data_oxygen', $data);
        }
    }
}

/**
 * Output submit button.
 *
 * 
 *
 * @author Team Rankology 
 *
 * @param mixed $value
 * @param mixed $classes
 * @param mixed $type
 */
function rankology_rkseo_submit_button($value ='', $classes = 'btn btnPrimary', $type = 'submit') {
    if ('' === $value) {
        $value = esc_html__('Save changes', 'wp-rankology');
    }

    $html = '<p class="submit"><input id="submit" name="submit" type="' . $type . '" class="' . $classes . '" value="' . $value . '"/></p>';

    echo rankology_common_esc_str($html);
}

/**
 * Generate HTML buttons classes
 *
 * 
 *
 * @author Team Rankology 
 * @return
 */
function rankology_btn_secondary_classes() {
    //Classic Editor compatibility
    global $pagenow;
    if (function_exists('get_current_screen') && method_exists(get_current_screen(), 'is_block_editor') && true === get_current_screen()->is_block_editor()) {
        $btn_classes_secondary = 'components-button is-secondary';
    } elseif (isset($pagenow) && ($pagenow === 'term.php' || $pagenow === 'post.php' || $pagenow === 'post-new.php') ) {
        $btn_classes_secondary = 'button button-secondary';
    } else {
        $btn_classes_secondary = 'btn btnSecondary';
    }

    return $btn_classes_secondary;
}

/**
 * Global check.
 *
 * 
 *
 * @param string $feature
 *
 * @return string 1 if true
 *
 * @author Team Rankology
 */
function rankology_get_toggle_option($feature) {
	$rankology_get_toggle_option = get_option('rankology_toggle');
	if ( ! empty($rankology_get_toggle_option)) {
		foreach ($rankology_get_toggle_option as $key => $rankology_get_toggle_value) {
			$options[$key] = $rankology_get_toggle_value;
			if (isset($rankology_get_toggle_option['toggle-' . $feature])) {
				return $rankology_get_toggle_option['toggle-' . $feature];
			}
		}
	}
}

/*
 * Global trailingslash option from SEO, Advanced, Advanced tab (useful for backwards compatibility with Rankology < 5.9)
 * 
 * @return string 1 if true
 * @author Team Rankology
 */
if ( ! function_exists('rankology_advanced_advanced_trailingslash_option')) {
    function rankology_advanced_advanced_trailingslash_option()
    {
        $rankology_advanced_advanced_trailingslash_option = get_option('rankology_advanced_option_name');
        if (! empty($rankology_advanced_advanced_trailingslash_option)) {
            foreach ($rankology_advanced_advanced_trailingslash_option as $key => $rankology_advanced_advanced_trailingslash_value) {
                $options[$key] = $rankology_advanced_advanced_trailingslash_value;
            }
            if (isset($rankology_advanced_advanced_trailingslash_option['rankology_advanced_advanced_trailingslash'])) {
                return $rankology_advanced_advanced_trailingslash_option['rankology_advanced_advanced_trailingslash'];
            }
        }
    }
}


/*
 * Disable Add to cart GA tracking code on archive page / related products for Elementor PRO to avoid a JS conflict
 * 
 * @return empty string
 * @author Team Rankology
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('elementor-pro/elementor-pro.php')) {
    add_filter('rankology_gtag_ec_add_to_cart_archive_ev', 'rankology_rkseo_elementor_gtag_ec_add_to_cart_archive_ev');
    function rankology_rkseo_elementor_gtag_ec_add_to_cart_archive_ev($js) {
        return '';
    }
}



/**
 * Helper function needed for PHP 8.1 compatibility with "current" function
 * Get mangled object vars
 * 
 */
function rankology_maybe_mangled_object_vars($data){
    if(!function_exists('get_mangled_object_vars')){
        return $data;
    }

    if(!is_object($data)){
        return $data;
    }

    return get_mangled_object_vars($data);

}

/**
 * Automatically flush permalinks after saving XML sitemaps global settings
 * 
 *
 * @param string $option
 * @param string $old_value
 * @param string $value
 *
 * @return void
 */
add_action('update_option', function( $option, $old_value, $value ) {
    if ($option ==='rankology_xml_sitemap_option_name') {
        set_transient('rankology_flush_rewrite_rules', 1);
    }
}, 10, 3);

add_action('admin_init', 'rankology_auto_flush_rewrite_rules');
function rankology_auto_flush_rewrite_rules() {
    if (get_transient('rankology_flush_rewrite_rules')) {
        flush_rewrite_rules(false);
        delete_transient('rankology_flush_rewrite_rules');
    }
}
