<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//XML

//Headers
rankology_get_service('SitemapHeaders')->printHeaders();

//WPML - Home URL
if ( 2 == apply_filters( 'wpml_setting', false, 'rankology_rankology_language_negotiation_type' ) ) {
    add_filter('rankology_sitemaps_home_url', function($home_url) {
        $home_url = apply_filters( 'wpml_home_url', get_option( 'home' ));
        return trailingslashit($home_url);
    });
} else {
    add_filter('wpml_get_home_url', 'rankology_remove_wpml_home_url_filter', 20, 5);
}

add_filter('rankology_sitemaps_single_term_query', function ($args) {

    global $sitepress, $rankology_sitepress_settings;

    //If multidomain setup
    if ( 2 == apply_filters( 'wpml_setting', false, 'rankology_rankology_language_negotiation_type' ) ) {
        add_filter('terms_clauses', [$sitepress, 'terms_clauses'], 100, 4);
    }
    $rankology_sitepress_settings['auto_adjust_ids'] = 0;
    remove_filter('terms_clauses', [$sitepress, 'terms_clauses']);
    remove_filter('category_link', [$sitepress, 'category_link_adjust_id'], 1);

    return $args;
});

add_filter('rankology_sitemaps_term_single_url', function($url, $term) {
    //Exclude custom canonical from sitemaps
    if (get_term_meta($term->term_id, '_rankology_robots_canonical', true) && get_term_link( $term->term_id ) !== get_term_meta($term->term_id, '_rankology_robots_canonical', true)) {
        return null;
    }

    //Exclude noindex
    if (get_term_meta($term->term_id, '_rankology_robots_index', true)) {
        return null;
    }

    //Exclude hidden languages
    //@credits WPML compatibility team
    if (function_exists('icl_object_id') && defined('ICL_SITEPRESS_VERSION')) { //WPML
        global $sitepress, $rankology_sitepress_settings;

        // Check that at least ID is set in post object.
        if ( ! isset( $term->term_id ) ) {
            return $url;
        }

        // Get list of hidden languages.
        $hidden_languages = $sitepress->get_setting( 'hidden_languages', array() );

        // If there are no hidden languages return original URL.
        if ( empty( $hidden_languages ) ) {
            return $url;
        }

        // Get language information for post.
        $language_info = $sitepress->term_translations()->get_element_lang_code( $term->term_id );

        // If language code is one of the hidden languages return null to skip the post.
        if ( in_array( $language_info, $hidden_languages, true ) ) {
            return null;
        }
    }

    return $url;
}, 10, 2);

// Polylang: remove hidden languages
function rankology_pll_exclude_hidden_lang($args) {
    if (function_exists('get_languages_list') && is_plugin_active('polylang/polylang.php') || is_plugin_active('polylang-pro/polylang.php')) {
        $languages = PLL()->model->get_languages_list();
        if ( wp_list_filter( $languages, array( 'active' => false ) ) ) {
            $args['lang'] = wp_list_pluck( wp_list_filter( $languages, array( 'active' => false ), 'NOT' ), 'slug' );
        }
    }
    return $args;
}

function rankology_xml_sitemap_single_term() {
    // Get the custom post type from the query variable
    if ('' !== get_query_var('rankology_cpt')) {
        $path = get_query_var('rankology_cpt');
    }

    // Remove all filters on 'pre_get_posts' to allow direct database querying
    remove_all_filters('pre_get_posts');

    // Sanitize the REQUEST_URI and parse the offset
    $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
    $offset = basename(parse_url($request_uri, PHP_URL_PATH), '.xml');
    $offset = preg_match_all('/\d+/', $offset, $matches);
    $offset = end($matches[0]);

    // Max posts per paginated sitemap
    $max = 1000;
    $max = apply_filters('rankology_sitemaps_max_terms_per_sitemap', $max);

    // Validate and adjust the offset
    if (isset($offset) && absint($offset) && '' != $offset && 0 != $offset) {
        $offset = (($offset - 1) * $max);
    } else {
        $offset = 0;
    }

    // Set the home URL
    $home_url = home_url() . '/';
    if (function_exists('pll_home_url')) {
        $home_url = site_url() . '/';
    }
    $home_url = apply_filters('rankology_sitemaps_home_url', $home_url);

    // Begin XML sitemap structure
    $rankology_sitemaps = '<?xml version="1.0" encoding="UTF-8"?>';
    $rankology_sitemaps .= '<?xml-stylesheet type="text/xsl" href="' . esc_url($home_url . 'sitemaps_xsl.xsl') . '"?>';
    $rankology_sitemaps .= "\n";
    $rankology_sitemaps .= apply_filters('rankology_sitemaps_urlset', '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');

    // Define query arguments for taxonomy terms
    $args = [
        'taxonomy'   => sanitize_text_field($path), // Sanitize the taxonomy path
        'offset'     => absint($offset),
        'hide_empty' => false,
        'number'     => 1000,
        'lang'       => '', // Default value, can be changed by Polylang
    ];

    // Apply language exclusion filter for hidden languages
    $args = rankology_pll_exclude_hidden_lang($args);
    $args = apply_filters('rankology_sitemaps_single_term_query', $args, $path);

    // Query terms based on arguments
    $termslist = new WP_Term_Query($args);

    // Loop through the list of terms and generate sitemap URLs
    if (is_array($termslist->terms) && ! empty($termslist->terms)) {
        foreach ($termslist->terms as $term) {
            $rankology_sitemaps_url = '';

            // Prepare data for each sitemap entry
            $rankology_url = [
                'loc'    => esc_url(get_term_link($term)), // Escape the URL for security
                'mod'    => '', // Modification date or other metadata (can be added)
                'images' => [], // List of images (if applicable)
            ];

            // Apply filters for term-specific URL
            $rankology_url = apply_filters('rankology_sitemaps_term_single_url', $rankology_url, $term);

            // If valid location URL is found, generate XML entry
            if (!empty($rankology_url['loc'])) {
                $rankology_sitemaps_url .= "\n";
                $rankology_sitemaps_url .= '<url>';
                $rankology_sitemaps_url .= "\n";
                $rankology_sitemaps_url .= '<loc>';
                $rankology_sitemaps_url .= esc_html($rankology_url['loc']);
                $rankology_sitemaps_url .= '</loc>';
                $rankology_sitemaps_url .= "\n";
                $rankology_sitemaps_url .= '</url>';

                // Apply filters for individual URL
                $rankology_sitemaps .= apply_filters('rankology_sitemaps_url', $rankology_sitemaps_url, $rankology_url);
            }
        }
    }

    // Close the sitemap XML
    $rankology_sitemaps .= '</urlset>';
    $rankology_sitemaps .= "\n";

    // Apply final filter for the sitemap
    $rankology_sitemaps = apply_filters('rankology_sitemaps_xml_single_term', $rankology_sitemaps);

    // Output the sitemap XML
    return $rankology_sitemaps;
}

// Echo the sitemap function
echo rankology_xml_sitemap_single_term();

