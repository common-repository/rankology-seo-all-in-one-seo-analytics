<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_migration_tool($plugin, $name) {
    $seo_title = 'Rankology';
    if (method_exists(rankology_get_service('ToggleOption'), 'getToggleWhiteLabel') && '1' === rankology_get_service('ToggleOption')->getToggleWhiteLabel()) {
        $seo_title = method_exists(rankology_fno_get_service('OptionPro'), 'getWhiteLabelListTitle') && rankology_fno_get_service('OptionPro')->getWhiteLabelListTitle() ? rankology_fno_get_service('OptionPro')->getWhiteLabelListTitle() : 'Rankology';
    }

    $html = '<div id="' . $plugin . '-migration-tool" class="postbox section-tool">
        <div class="inside">
                <h3>' . sprintf(esc_html__('Import posts and terms (if available) metadata from %s', 'wp-rankology'), $name) . '</h3>

                <p>' . esc_html__('By clicking Migrate, we\'ll import:', 'wp-rankology') . '</p>

                <ul>
                    <li>' . esc_html__('Title tags', 'wp-rankology') . '</li>
                    <li>' . esc_html__('Meta description', 'wp-rankology') . '</li>
                    <li>' . esc_html__('Facebook Open Graph tags (title, description and image thumbnail)', 'wp-rankology') . '</li>';
    if ('premium-seo-pack' != $plugin) {
        $html .= '<li>' . esc_html__('Twitter tags (title, description and image thumbnail)', 'wp-rankology') . '</li>';
    }
    if ('wp-meta-seo' != $plugin && 'seo-ultimate' != $plugin) {
        $html .= '<li>' . esc_html__('Meta Robots (noindex, nofollow...)', 'wp-rankology') . '</li>';
    }
    if ('wp-meta-seo' != $plugin && 'seo-ultimate' != $plugin && 'slim-seo' != $plugin) {
        $html .= '<li>' . esc_html__('Canonical URL', 'wp-rankology') . '</li>';
    }
    if ('wp-meta-seo' != $plugin && 'seo-ultimate' != $plugin && 'squirrly' != $plugin && 'slim-seo' != $plugin) {
        $html .= '<li>' . esc_html__('Focus / target keywords', 'wp-rankology') . '</li>';
    }
    if ('wp-meta-seo' != $plugin && 'premium-seo-pack' != $plugin && 'seo-ultimate' != $plugin && 'squirrly' != $plugin && 'aio' != $plugin && 'slim-seo' != $plugin) {
        $html .= '<li>' . esc_html__('Primary category', 'wp-rankology') . '</li>';
    }
    if ('wpseo' == $plugin || 'platinum-seo' == $plugin || 'smart-crawl' == $plugin || 'rankologyor' == $plugin || 'rk' == $plugin || 'seo-framework' == $plugin || 'aio' == $plugin) {
        $html .= '<li>' . esc_html__('Redirect URL', 'wp-rankology') . '</li>';
    }
    $html .= '</ul>

                <div class="rankology-notice is-warning">
                    <p>
                        ' . sprintf(wp_kses(__('<strong>WARNING:</strong> Migration will delete / update all <strong>%1$s posts and terms metadata</strong>. Some dynamic variables will not be interpreted. We do <strong>NOT delete any %2$s data</strong>.', 'wp-rankology'), array('strong' => array(), 'a' => array('href' => array()))), $seo_title, $name) . '
                    </p>
                </div>

                <button id="rankology-' . $plugin . '-migrate" type="button" class="btn btnSecondary">
                    ' . esc_html__('Migrate now', 'wp-rankology') . '
                </button>

                <span class="spinner"></span>

                <div class="log"></div>
            </div>
        </div>';

    return rankology_common_esc_str($html);
}
