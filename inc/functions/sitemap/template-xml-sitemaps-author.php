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

function rankology_xml_sitemap_author() {
    if ('' !== get_query_var('rankology_cpt')) {
        $path = get_query_var('rankology_cpt');
    }

    $home_url = home_url() . '/';

    if (function_exists('pll_home_url')) {
        $home_url = site_url() . '/';
    }

    $home_url = apply_filters('rankology_sitemaps_home_url', $home_url);

    $rankology_sitemaps = '<?xml version="1.0" encoding="UTF-8"?>';
    $rankology_sitemaps .= '<?xml-stylesheet type="text/xsl" href="' . $home_url . 'sitemaps_xsl.xsl"?>';
    $rankology_sitemaps .= "\n";
    $rankology_sitemaps .= apply_filters('rankology_sitemaps_urlset', '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
    $args = [
        'fields'              => 'ID',
        'orderby'             => 'nicename',
        'order'               => 'ASC',
        'has_published_posts' => ['post'],
            'blog_id'         => absint(get_current_blog_id()),
            'lang'            => '',
    ];
    $args = apply_filters('rankology_sitemaps_author_query', $args);

    $authorslist = get_users($args);

    foreach ($authorslist as $author) {
        $rankology_sitemaps_url = '';
        // array with all the information needed for a sitemap url
        $rankology_url = [
            'loc'    => htmlspecialchars(urldecode(esc_url(get_author_posts_url($author)))),
            'mod'    => '',
            'images' => [],
        ];
        $rankology_sitemaps_url .= "\n";
        $rankology_sitemaps_url .= '<url>';
        $rankology_sitemaps_url .= "\n";
        $rankology_sitemaps_url .= '<loc>';
        $rankology_sitemaps_url .= $rankology_url['loc'];
        $rankology_sitemaps_url .= '</loc>';
        $rankology_sitemaps_url .= "\n";
        $rankology_sitemaps_url .= '</url>';

        $rankology_sitemaps .= apply_filters('rankology_sitemaps_url', $rankology_sitemaps_url, $rankology_url);
    }
    $rankology_sitemaps .= '</urlset>';
    $rankology_sitemaps .= "\n";

    $rankology_sitemaps = apply_filters('rankology_sitemaps_xml_author', $rankology_sitemaps);

    return $rankology_sitemaps;
}
echo rankology_xml_sitemap_author();
