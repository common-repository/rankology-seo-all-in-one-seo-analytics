<?php
if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * Return settings
 *
 * @return array
 */
function rankology_return_settings() {
    $settings = array();

    $settings['rankology_activated']                             = get_option('rankology_activated');
    $settings['rankology_titles_option_name']                    = get_option('rankology_titles_option_name');
    $settings['rankology_social_option_name']                    = get_option('rankology_social_option_name');
    $settings['rankology_google_analytics_option_name']          = get_option('rankology_google_analytics_option_name');
    $settings['rankology_instant_indexing_option_name']          = get_option('rankology_instant_indexing_option_name');
    $settings['rankology_advanced_option_name']                  = get_option('rankology_advanced_option_name');
    $settings['rankology_xml_sitemap_option_name']               = get_option('rankology_xml_sitemap_option_name');
    $settings['rankology_fno_option_name']                       = get_option('rankology_fno_option_name');
    $settings['rankology_fno_mu_option_name']                    = get_option('rankology_fno_mu_option_name');
    $settings['rankology_bot_option_name']                       = get_option('rankology_bot_option_name');
    $settings['rankology_toggle']                                = get_option('rankology_toggle');
    $settings['rankology_google_analytics_lock_option_name']     = get_option('rankology_google_analytics_lock_option_name');
    $settings['rankology_tools_option_name']                     = get_option('rankology_tools_option_name');
    $settings['rankology_dashboard_option_name']                 = get_option('rankology_dashboard_option_name');

    return $settings;
}

/**
 * Rankology do import settings
 *
 * @param  array $settings
 *
 * @return void
 */
function rankology_do_import_settings( $settings ) {
    if (false !== $settings['rankology_activated']) {
        update_option('rankology_activated', $settings['rankology_activated'], false);
    }
    if (false !== $settings['rankology_titles_option_name']) {
        update_option('rankology_titles_option_name', $settings['rankology_titles_option_name'], false);
    }
    if (false !== $settings['rankology_social_option_name']) {
        update_option('rankology_social_option_name', $settings['rankology_social_option_name'], false);
    }
    if (false !== $settings['rankology_google_analytics_option_name']) {
        update_option('rankology_google_analytics_option_name', $settings['rankology_google_analytics_option_name'], false);
    }
    if (false !== $settings['rankology_advanced_option_name']) {
        update_option('rankology_advanced_option_name', $settings['rankology_advanced_option_name'], false);
    }
    if (false !== $settings['rankology_xml_sitemap_option_name']) {
        update_option('rankology_xml_sitemap_option_name', $settings['rankology_xml_sitemap_option_name'], false);
    }
    if (false !== $settings['rankology_fno_option_name']) {
        update_option('rankology_fno_option_name', $settings['rankology_fno_option_name'], false);
    }
    if (false !== $settings['rankology_fno_mu_option_name']) {
        update_option('rankology_fno_mu_option_name', $settings['rankology_fno_mu_option_name'], false);
    }
    if (false !== $settings['rankology_bot_option_name']) {
        update_option('rankology_bot_option_name', $settings['rankology_bot_option_name'], false);
    }
    if (false !== $settings['rankology_toggle']) {
        update_option('rankology_toggle', $settings['rankology_toggle'], false);
    }
    if (false !== $settings['rankology_google_analytics_lock_option_name']) {
        update_option('rankology_google_analytics_lock_option_name', $settings['rankology_google_analytics_lock_option_name'], false);
    }
    if (false !== $settings['rankology_tools_option_name']) {
        update_option('rankology_tools_option_name', $settings['rankology_tools_option_name'], false);
    }
    if (false !== $settings['rankology_instant_indexing_option_name']) {
        update_option('rankology_instant_indexing_option_name', $settings['rankology_instant_indexing_option_name'], false);
    }
}

/**
 * Save settings for given option
 *
 * @param  array  $settings The settings to be saved.
 * @param  string $option The option name.
 *
 * @return void
 */
function rankology_mainwp_save_settings( $settings, $option ) {
    update_option( $option, $settings );
}

/**
 * Flush rewrite rules.
 *
 * @return void
 */
function rankology_flush_rewrite_rules() {
    flush_rewrite_rules( false );
}
