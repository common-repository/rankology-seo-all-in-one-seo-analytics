<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');
///////////////////////////////////////////////////////////////////////////////////////////////////
//RANKOLOGY Core
///////////////////////////////////////////////////////////////////////////////////////////////////
// Instant Indexing
require_once dirname(__FILE__) . '/options-instant-indexing.php';

//Import / Export tool
add_action('init', 'rankology_enable', 999);
function rankology_enable()
{
    if (is_admin()) {
        require_once dirname(__FILE__) . '/options-import-export.php'; //Import Export
    }
}

//Front END
if ('1' == rankology_get_toggle_option('titles')) {
    function rankology_titles_disable_archives()
    {
        global $wp_query;

        $url = apply_filters( 'rankology_disable_archives_redirect_url', get_home_url() );
        $status = apply_filters( 'rankology_disable_archives_redirect_status' , '301' );

        if ('1' === rankology_get_service('TitleOption')->getArchiveAuthorDisable() && $wp_query->is_author && ! is_feed()) {
            wp_redirect($url, $status);
            exit;
        }
        if ('1' === rankology_get_service('TitleOption')->getArchiveDateDisable() && $wp_query->is_date && ! is_feed()) {
            wp_redirect($url, $status);
            exit;
        }

        return false;
    }

    //SEO metaboxes
    function rankology_hide_metaboxes()
    {
        if (is_admin()) {
            global $typenow;
            global $pagenow;

            //Post type?
            if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
                function rankology_titles_single_enable_metabox($rankology_get_post_types)
                {
                    global $post;

                    if ('1' === rankology_get_service('TitleOption')->getSingleCptEnable($post->post_type) && isset($post->post_type)) {
                        unset($rankology_get_post_types[$post->post_type]);
                    }

                    return $rankology_get_post_types;
                }
                add_filter('rankology_metaboxe_seo', 'rankology_titles_single_enable_metabox');
                add_filter('rankology_metaboxe_content_analysis', 'rankology_titles_single_enable_metabox');
                add_filter('rankology_fno_metaboxe_sdt', 'rankology_titles_single_enable_metabox');
            }

            //Taxonomy?
			$rankology_get_current_tax = isset($_GET['taxonomy']) ? sanitize_title($_GET['taxonomy']) : '';

			if ('term.php' == $pagenow || 'edit-tags.php' == $pagenow) {
				if (!empty($_GET['taxonomy'])) {
					$rankology_get_current_tax = sanitize_title($_GET['taxonomy']);
				}

				function rankology_tax_single_enable_metabox($rankology_get_taxonomies)
				{
					$rankology_get_current_tax = isset($_GET['taxonomy']) ? sanitize_title($_GET['taxonomy']) : '';
					if ('1' === rankology_get_service('TitleOption')->getTaxEnable($rankology_get_current_tax) && !empty($rankology_get_current_tax)) {
						unset($rankology_get_taxonomies[$rankology_get_current_tax]);
					}

					return $rankology_get_taxonomies;
				}
				add_filter('rankology_metaboxe_term_seo', 'rankology_tax_single_enable_metabox');
			}

        }
    }
    add_action('after_setup_theme', 'rankology_hide_metaboxes');

    //Titles and metas
    add_action('template_redirect', 'rankology_titles_disable_archives', 0);
    add_action('wp_head', 'rankology_load_titles_options', 0);
    function rankology_load_titles_options()
    {
        if (! is_admin()) {
            if ((function_exists('is_wpforo_page') && is_wpforo_page()) || (class_exists('Ecwid_Store_Page') && Ecwid_Store_Page::is_store_page())) {//disable on wpForo pages to avoid conflicts
                //do nothing
            } else {
                require_once dirname(__FILE__) . '/options-titles-metas.php'; //Titles & metas
            }
        }
    }
}
if ('1' == rankology_get_toggle_option('social')) {
    add_action('init', 'rankology_load_oembed_options');
    function rankology_load_oembed_options()
    {
        if (! is_admin()) {
            require_once dirname(__FILE__) . '/options-oembed.php'; //Oembed
        }
    }

    add_action('wp_head', 'rankology_load_social_options', 0);
    function rankology_load_social_options()
    {
        if (! is_admin()) {
            //disable on wpForo, LifterLMS private area, Ecwid store pages to avoid conflicts
            if ((function_exists('is_llms_private_area') && is_llms_private_area()) || (function_exists('is_wpforo_page') && is_wpforo_page()) || (class_exists('Ecwid_Store_Page') && Ecwid_Store_Page::is_store_page())) {
                //do nothing
            } else {
                require_once dirname(__FILE__) . '/options-social.php'; //Social
            }
        }
    }
}
if ('1' == rankology_get_toggle_option('google-analytics')) {
    //User Consent JS
    function rankology_google_analytics_cookies_js()
    {
        $prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_register_script('rankology-cookies', plugins_url('assets/js/rankology-cookies' . $prefix . '.js', dirname(dirname(__FILE__))), [], RANKOLOGY_VERSION, true);
        wp_enqueue_script('rankology-cookies');

        wp_enqueue_script('rankology-cookies-ajax', plugins_url('assets/js/rankology-cookies-ajax' . $prefix . '.js', dirname(dirname(__FILE__))), ['jquery', 'rankology-cookies'], RANKOLOGY_VERSION, true);

        $days = 30;

        if (rankology_get_service('GoogleAnalyticsOption')->getCbExpDate()) {
            $days = rankology_get_service('GoogleAnalyticsOption')->getCbExpDate();
        }
        $days = apply_filters('rankology_cookies_expiration_days', $days);

        $rankology_cookies_user_consent = [
            'rankology_nonce'                   => wp_create_nonce('rankology_cookies_user_consent_nonce'),
            'rankology_cookies_user_consent'    => admin_url('admin-ajax.php'),
            'rankology_cookies_expiration_days' => $days,
        ];
        wp_localize_script('rankology-cookies-ajax', 'rankologyAjaxGAUserConsent', $rankology_cookies_user_consent);
    }

    //Triggers WooCommerce JS
    function rankology_google_analytics_ecommerce_js()
    {
        $prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_enqueue_script('rankology-analytics', plugins_url('assets/js/rankology-analytics' . $prefix . '.js', dirname(dirname(__FILE__))), [], RANKOLOGY_VERSION, true);

        $rankology_analytics = [
            'rankology_nonce'                => wp_create_nonce('rankology_analytics_nonce'),
            'rankology_analytics' 			        => admin_url('admin-ajax.php'),
        ];
        wp_localize_script('rankology-analytics', 'rankologyAjaxAnalytics', $rankology_analytics);
    }

// Ecommerce
function rankology_after_update_cart()
{
    check_ajax_referer('rankology_analytics_nonce');

    $items_purchased = [];
    $final = [];

    // Extract cart
    global $woocommerce;
    foreach ($woocommerce->cart->get_cart() as $key => $item) {
        $product = wc_get_product($item['product_id']);
        // Get current product
        if ($product) {
            // Set data
            $items_purchased['id'] = esc_js($product->get_id());
            $items_purchased['name'] = esc_js($product->get_title());
            $items_purchased['quantity'] = (float) esc_js($item['quantity']);
            $items_purchased['price'] = (float) esc_js($product->get_price());

            // Extract categories
            $categories = get_the_terms($product->get_id(), 'product_cat');
            if ($categories) {
                $categories_out = [];
                foreach ($categories as $category) {
                    $categories_out[] = $category->name;
                }
                $categories_js = esc_js(implode('/', $categories_out));
                $items_purchased['category'] = esc_js($categories_js);
            }
        }
        $final[] = $items_purchased;
    }

    // Enqueue the script and pass data to it
    add_action('wp_enqueue_scripts', function () use ($final) {
        wp_register_script('rankology-gtag-event', plugins_url('/assets/js/rankology-gtag-event.js', __FILE__), [], '1.0.0', true);
        wp_enqueue_script('rankology-gtag-event');

        wp_add_inline_script(
            'rankology-gtag-event',
            sprintf(
                "gtag('event', 'add_to_cart', {'items': %s });",
                wp_json_encode($final)
            )
        );
    });

    wp_send_json_success('Event tracked');
}
add_action('wp_ajax_rankology_after_update_cart', 'rankology_after_update_cart');
add_action('wp_ajax_nopriv_rankology_after_update_cart', 'rankology_after_update_cart');


    if ('1' === rankology_get_service('GoogleAnalyticsOption')->getDisable()) {
        if (is_user_logged_in()) {
            global $wp_roles;

            //Get current user role
            if (isset(wp_get_current_user()->roles[0])) {
                $rankology_user_role = wp_get_current_user()->roles[0];
                //If current user role matchs values from Rankology GA settings then apply
                if (!empty(rankology_get_service('GoogleAnalyticsOption')->getRoles())) {
                    if (array_key_exists($rankology_user_role, rankology_get_service('GoogleAnalyticsOption')->getRoles())) {
                        //do nothing
                    } else {
                        add_action('wp_enqueue_scripts', 'rankology_google_analytics_cookies_js', 20, 1);
                    }
                } else {
                    add_action('wp_enqueue_scripts', 'rankology_google_analytics_cookies_js', 20, 1);
                }
            } else {
                add_action('wp_enqueue_scripts', 'rankology_google_analytics_cookies_js', 20, 1);
            }
        } else {
            add_action('wp_enqueue_scripts', 'rankology_google_analytics_cookies_js', 20, 1);
        }
    }

    add_action('wp_head', 'rankology_load_google_analytics_options', 0);
    function rankology_load_google_analytics_options()
    {
        //Google Analytics
        require_once dirname(__FILE__) . '/options-google-analytics.php';

        //User Consent
        require_once dirname(__FILE__) . '/options-user-consent.php';
    }

    function rankology_cookies_user_consent() {
        if ('1' === rankology_get_service('GoogleAnalyticsOption')->getHalfDisable()) {//no user consent required
            wp_send_json_success();
        } else {
            if (is_user_logged_in()) {
                global $wp_roles;

                //Get current user role
                if (isset(wp_get_current_user()->roles[0])) {
                    $rankology_user_role = wp_get_current_user()->roles[0];
                    //If current user role matchs values from Rankology GA settings then apply
                    if (!empty(rankology_get_service('GoogleAnalyticsOption')->getRoles())) {
                        if (array_key_exists($rankology_user_role, rankology_get_service('GoogleAnalyticsOption')->getRoles())) {
                            //do nothing
                        } else {
                            include_once dirname(__FILE__) . '/options-google-analytics.php'; //Google Analytics
                            $data 					          = [];
                            $data['gtag_js'] 		  = rankology_google_analytics_js(false);
                            $data['body_js'] 		  = rankology_google_analytics_body_code(false);
                            $data['head_js'] 		  = rankology_google_analytics_head_code(false);
                            $data['footer_js'] 		= rankology_google_analytics_footer_code(false);
                            $data['custom'] 		   = '';
                            $data['custom'] 		   = apply_filters('rankology_custom_tracking', $data['custom']);
                            wp_send_json_success($data);
                        }
                    } else {
                        include_once dirname(__FILE__) . '/options-google-analytics.php'; //Google Analytics
                        $data 					          = [];
                        $data['gtag_js'] 		  = rankology_google_analytics_js(false);
                        $data['body_js'] 		  = rankology_google_analytics_body_code(false);
                        $data['head_js'] 		  = rankology_google_analytics_head_code(false);
                        $data['footer_js'] 		= rankology_google_analytics_footer_code(false);
                        $data['custom'] 		   = '';
                        $data['custom'] 		   = apply_filters('rankology_custom_tracking', $data['custom']);
                        wp_send_json_success($data);
                    }
                }
            } else {
                include_once dirname(__FILE__) . '/options-google-analytics.php'; //Google Analytics
                $data 					          = [];
                $data['gtag_js'] 		  = rankology_google_analytics_js(false);
                $data['body_js'] 		  = rankology_google_analytics_body_code(false);
                $data['head_js'] 		  = rankology_google_analytics_head_code(false);
                $data['footer_js'] 		= rankology_google_analytics_footer_code(false);
                $data['custom'] 		   = '';
                $data['custom'] 		   = apply_filters('rankology_custom_tracking', $data['custom']);
                wp_send_json_success($data);
            }
        }
    }
    add_action('wp_ajax_rankology_cookies_user_consent', 'rankology_cookies_user_consent');
    add_action('wp_ajax_nopriv_rankology_cookies_user_consent', 'rankology_cookies_user_consent');
}

add_action('wp', 'rankology_load_redirections_options', 0);
function rankology_load_redirections_options()
{
    if (function_exists('is_plugin_active') && is_plugin_active('thrive-visual-editor/thrive-visual-editor.php') && is_admin()) {
        return;
    }
    if (! is_admin()) {
        require_once dirname(__FILE__) . '/options-redirections.php'; //Redirections
    }
}

if ('1' == rankology_get_toggle_option('xml-sitemap')) {
    add_action('init', 'rankology_load_sitemap', 999);
    function rankology_load_sitemap() {
        require_once dirname(__FILE__) . '/options-sitemap.php'; //XML / HTML Sitemap
    }
}
if ('1' === rankology_get_toggle_option('advanced')) {
    //Remove comment author url
    if ('1' === rankology_get_service('AdvancedOption')->getAdvancedCommentsAuthorURLDisable()) {
        add_filter('get_comment_author_url', '__return_empty_string');
    }

    //Remove website field in comments
    if ('1' === rankology_get_service('AdvancedOption')->getAdvancedCommentsAuthorURLDisable()) {
        function rankology_advanced_advanced_comments_website_hook($fields)
        {
            unset($fields['url']);

            return $fields;
        }
        add_filter('comment_form_default_fields', 'rankology_advanced_advanced_comments_website_hook', 40);
    }

    add_action('init', 'rankology_load_advanced_options', 0);
    function rankology_load_advanced_options()
    {
        if (! is_admin()) {
            require_once dirname(__FILE__) . '/options-advanced.php'; //Advanced
        }
    }
    add_action('init', 'rankology_load_advanced_admin_options', 11);
    function rankology_load_advanced_admin_options()
    {
        require_once dirname(__FILE__) . '/options-advanced-admin.php'; //Advanced (admin)
        //Admin bar
        if ('1' === rankology_get_service('AdvancedOption')->getAppearanceAdminBar()) {
            add_action('admin_bar_menu', 'rankology_advanced_appearance_adminbar_hook', 999);

            function rankology_advanced_appearance_adminbar_hook($wp_admin_bar)
            {
                $wp_admin_bar->remove_node('rankology');
            }
        }
    }

    //Add nofollow noopener noreferrer to comments form link
    if ('1' === rankology_get_service('AdvancedOption')->getAdvancedCommentsFormLinkDisable()) {
        /* Custom attributes on comment link */
        add_filter('comments_popup_link_attributes', 'rankology_comments_popup_link_attributes');
        function rankology_comments_popup_link_attributes($attr) {
            $attr = 'rel="nofollow noopener noreferrer"';
            return $attr;
        }
    }

    //primary category
    function rankology_titles_primary_cat_hook($cats_0, $cats, $post)
    {
        $primary_cat	= null;

        if ($post) {
            $_rankology_robots_primary_cat = get_post_meta($post->ID, '_rankology_robots_primary_cat', true);
            if (isset($_rankology_robots_primary_cat) && '' != $_rankology_robots_primary_cat && 'none' != $_rankology_robots_primary_cat) {
                if (null != $post->post_type && 'post' == $post->post_type) {
                    $primary_cat = get_category($_rankology_robots_primary_cat);
                }
                if (! is_wp_error($primary_cat) && null != $primary_cat) {
                    return $primary_cat;
                }
            } else {
                //no primary cat
                return $cats_0;
            }
        } else {
            return $cats_0;
        }
    }
    add_filter('post_link_category', 'rankology_titles_primary_cat_hook', 10, 3);

    function rankology_titles_primary_wc_cat_hook($terms_0, $terms, $post)
    {
        $primary_cat	= null;

        if ($post) {
            $_rankology_robots_primary_cat = get_post_meta($post->ID, '_rankology_robots_primary_cat', true);

            if (isset($_rankology_robots_primary_cat) && '' != $_rankology_robots_primary_cat && 'none' != $_rankology_robots_primary_cat) {
                if (null != $post->post_type && 'product' == $post->post_type) {
                    $primary_cat = get_term($_rankology_robots_primary_cat, 'product_cat');
                }
                if (! is_wp_error($primary_cat) && null != $primary_cat) {
                    return $primary_cat;
                }
            } else {
                //no primary cat
                return $terms_0;
            }
        } else {
            return $terms_0;
        }
    }
    add_filter('wc_product_post_type_link_product_cat', 'rankology_titles_primary_wc_cat_hook', 10, 3);

    //No /category/ in URL
    if (!empty(rankology_get_service('AdvancedOption')->getAdvancedRemoveCategoryURL())) {
        //Flush permalinks when creating/editing/deleting post categories
        add_action('created_category', 'flush_rewrite_rules');
        add_action('delete_category', 'flush_rewrite_rules');
        add_action('edited_category', 'flush_rewrite_rules');

        //@credits : WordPress VIP
        add_filter('category_rewrite_rules', 'rankology_filter_category_rewrite_rules');
        function rankology_filter_category_rewrite_rules($rules)
        {
            if (class_exists('Sitepress')) {
                global $sitepress;
                remove_filter('terms_clauses', [$sitepress, 'terms_clauses']);
                $categories = get_categories(['hide_empty' => false]);
                add_filter('terms_clauses', [$sitepress, 'terms_clauses'], 10, 4);
            } else {
                $categories = get_categories(['hide_empty' => false]);
            }
            if (is_array($categories) && ! empty($categories)) {
                $slugs = [];

                foreach ($categories as $category) {
                    if (is_object($category) && ! is_wp_error($category)) {
                        if (0 == $category->category_parent) {
                            $slugs[] = $category->slug;
                        } else {
                            $slugs[] = trim(get_category_parents($category->term_id, false, '/', true), '/');
                        }
                    }
                }

                if (! empty($slugs)) {
                    $rules = [];

                    foreach ($slugs as $slug) {
                        $rules['(' . $slug . ')/feed/(feed|rdf|rss|rss2|atom)?/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
                        $rules['(' . $slug . ')/(feed|rdf|rss|rss2|atom)/?$']       = 'index.php?category_name=$matches[1]&feed=$matches[2]';
                        $rules['(' . $slug . ')(/page/(\d+))?/?$']                  = 'index.php?category_name=$matches[1]&paged=$matches[3]';
                    }
                }
            }
            $rules = apply_filters('rankology_category_rewrite_rules', $rules);

            return $rules;
        }

        function rankology_remove_category_base($termlink, $term, $taxonomy)
        {
            if ('category' == $taxonomy) {
                $category_base = get_option('category_base');

                if (class_exists('Sitepress') && defined('ICL_LANGUAGE_CODE')) {
                    $category_base = apply_filters('wpml_translate_single_string', $category_base, 'WordPress', 'URL category tax slug', ICL_LANGUAGE_CODE);
                }

                if ('' == $category_base) {
                    $category_base = 'category';
                }

                $category_base = apply_filters('rankology_remove_category_base', $category_base);

                if ('/' == substr($category_base, 0, 1)) {
                    $category_base = substr($category_base, 1);
                }
                $category_base .= '/';

                return preg_replace('`' . preg_quote($category_base, '`') . '`u', '', $termlink, 1);
            } else {
                return $termlink;
            }
        }
        add_filter('term_link', 'rankology_remove_category_base', 10, 3);

        add_action('template_redirect', 'rankology_category_redirect', 1);
        function rankology_category_redirect()
        {
            if (!is_category()) {
                return;
            }
            global $wp;

            $current_url = user_trailingslashit(home_url(add_query_arg([], $wp->request)));

            $category_base = get_option('category_base');

            if (class_exists('Sitepress') && defined('ICL_LANGUAGE_CODE')) {
                $category_base = apply_filters('wpml_translate_single_string', $category_base, 'WordPress', 'URL category tax slug', ICL_LANGUAGE_CODE);
            }

            $category_base = apply_filters('rankology_remove_category_base', $category_base);

            if ('' != $category_base) {
                $regex = sprintf('/\/%s\//', str_replace('/', '\/', $category_base));
                if (preg_match($regex, $current_url)) {
                    $new_url = str_replace('/' . $category_base, '', $current_url);
                    wp_redirect($new_url, 301);
                    exit();
                }
            } else {
                $category_base = 'category';
                $regex         = sprintf('/\/%s\//', str_replace('/', '\/', $category_base));
                if (preg_match($regex, $current_url)) {
                    $new_url = str_replace('/' . $category_base, '', $current_url);
                    wp_redirect($new_url, 301);
                    exit();
                }
            }
        }
    }

    //No /product-category/ in URL
    if (!empty(rankology_get_service('AdvancedOption')->getAdvancedRemoveProductCategoryURL())) {
        //Flush permalinks when creating/editing/deleting product categories
        add_action('created_product_cat', 'flush_rewrite_rules');
        add_action('delete_product_cat', 'flush_rewrite_rules');
        add_action('edited_product_cat', 'flush_rewrite_rules');

        add_filter('product_cat_rewrite_rules', 'rankology_filter_product_category_rewrite_rules');
        function rankology_filter_product_category_rewrite_rules($rules)
        {
            if (class_exists('Sitepress')) {
                global $sitepress;
                remove_filter('terms_clauses', [$sitepress, 'terms_clauses']);
                $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
                add_filter('terms_clauses', [$sitepress, 'terms_clauses'], 10, 4);
            } else {
                $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
            }
            if (is_array($categories) && ! empty($categories)) {
                $slugs = [];

                foreach ($categories as $category) {
                    if (is_object($category) && ! is_wp_error($category)) {
                        if (0 == $category->parent) {
                            $slugs[] = $category->slug;
                        } else {
                            $slugs[] = trim(get_term_parents_list($category->term_id, 'product_cat', ['separator' => '/', 'link' => false]), '/');
                        }
                    }
                }

                if (! empty($slugs)) {
                    $rules = [];
                    foreach ($slugs as $slug) {
                        $rules['(' . $slug . ')(/page/(\d+))?/?$']                  = 'index.php?product_cat=$matches[1]&paged=$matches[3]';
                        $rules[$slug . '/(.+?)/page/?([0-9]{1,})/?$']                = 'index.php?product_cat=$matches[1]&paged=$matches[2]';
                        $rules[$slug . '/(.+?)/?$']                                  = 'index.php?product_cat=$matches[1]';

                        $rules[$slug . '/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?product_cat=$matches[1]&feed=$matches[2]';
                        $rules[$slug . '/(.+?)/(feed|rdf|rss|rss2|atom)/?$']      = 'index.php?product_cat=$matches[1]&feed=$matches[2]';
                        $rules[$slug . '/(.+?)/embed/?$']                         = 'index.php?product_cat=$matches[1]&embed=true';
                    }
                }
            }
            $rules = apply_filters('rankology_fnoduct_category_rewrite_rules', $rules);

            return $rules;
        }

        function rankology_remove_product_category_base($termlink, $term, $taxonomy)
        {
            if ('product_cat' == $taxonomy) {
                $category_base = get_option('woocommerce_permalinks');
                $category_base = $category_base['category_base'];

                if (class_exists('Sitepress') && defined('ICL_LANGUAGE_CODE')) {
                    $category_base = apply_filters('wpml_translate_single_string', $category_base, 'WordPress', 'URL product_cat tax slug', ICL_LANGUAGE_CODE);
                }

                if ('' == $category_base) {
                    $category_base = 'product-category';
                }

                $category_base = apply_filters('rankology_remove_product_category_base', $category_base);

                if ('/' == substr($category_base, 0, 1)) {
                    $category_base = substr($category_base, 1);
                }
                $category_base .= '/';

                return preg_replace('`' . preg_quote($category_base, '`') . '`u', '', $termlink, 1);
            } else {
                return $termlink;
            }
        }
        add_filter('term_link', 'rankology_remove_product_category_base', 10, 3);

        add_action('template_redirect', 'rankology_fnoduct_category_redirect', 1);
        function rankology_fnoduct_category_redirect()
        {
            global $wp;

            $current_url = user_trailingslashit(home_url(add_query_arg([], $wp->request)));

            $category_base = get_option('woocommerce_permalinks');
            $category_base = $category_base['category_base'];

            if (class_exists('Sitepress') && defined('ICL_LANGUAGE_CODE')) {
                $category_base = apply_filters('wpml_translate_single_string', $category_base, 'WordPress', 'URL product_cat tax slug', ICL_LANGUAGE_CODE);
            }

            $category_base = apply_filters('rankology_remove_product_category_base', $category_base);

            if ('' != $category_base) {
                if (preg_match('/\/' . $category_base . '\//', $current_url)) {
                    $new_url = str_replace('/' . $category_base, '', $current_url);
                    wp_redirect($new_url, 301);
                    exit();
                }
            } else {
                $category_base = 'product-category';

                if (preg_match('/\/' . $category_base . '\//', $current_url)) {
                    $new_url = str_replace('/' . $category_base, '', $current_url);
                    wp_redirect($new_url, 301);
                    exit();
                }
            }
        }
    }
}
