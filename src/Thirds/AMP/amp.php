<?php

if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * AMP Compatibility - wp action hook
 *
 * 
 *
 * @return void
 */
add_action('wp', 'rankology_amp_compatibility_wp', 0);
function rankology_amp_compatibility_wp() {
    if ( function_exists( 'amp_is_request' ) && amp_is_request() ) {
        wp_dequeue_script( 'rankology-accordion' );

        remove_filter( 'rankology_google_analytics_html', 'rankology_google_analytics_js', 10);

        remove_action('wp_enqueue_scripts', 'rankology_google_analytics_ecommerce_js', 20, 1);

        remove_action('wp_enqueue_scripts', 'rankology_google_analytics_cookies_js', 20, 1);

        remove_action( 'wp_head', 'rankology_load_google_analytics_options', 0 );
    }
}

/**
 * AMP Compatibility - wp_head action hook
 *
 * 
 *
 * @return void
 */
add_action('wp_head', 'rankology_amp_compatibility_wp_head', 0);
function rankology_amp_compatibility_wp_head() {
    if ( function_exists( 'amp_is_request' ) && amp_is_request() ) {
        wp_dequeue_script( 'rankology-accordion' );
    }
}
