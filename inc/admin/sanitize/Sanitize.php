<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

function rankology_sanitize_options_fields($input)
{

    $rankology_sanitize_fields = [
        'rankology_social_facebook_img_attachment_id',
        'rankology_social_facebook_img_attachment_width',
        'rankology_social_facebook_img_attachment_height',
        'rankology_titles_home_site_title',
        'rankology_titles_home_site_title_alt',
        'rankology_titles_home_site_desc',
        'rankology_titles_archives_author_title',
        'rankology_titles_archives_author_desc',
        'rankology_titles_archives_date_title',
        'rankology_titles_archives_date_desc',
        'rankology_titles_archives_search_title',
        'rankology_titles_archives_search_desc',
        'rankology_titles_archives_404_title',
        'rankology_titles_archives_404_desc',
        'rankology_xml_sitemap_html_exclude',
        'rankology_social_knowledge_name',
        'rankology_social_knowledge_img',
        'rankology_social_knowledge_phone',
        'rankology_social_accounts_facebook',
        'rankology_social_accounts_twitter',
        'rankology_social_accounts_pinterest',
        'rankology_social_accounts_instagram',
        'rankology_social_accounts_youtube',
        'rankology_social_accounts_linkedin',
        'rankology_social_accounts_extra',
        'rankology_social_facebook_link_ownership_id',
        'rankology_social_facebook_admin_id',
        'rankology_social_facebook_app_id',
        'rankology_google_analytics_ga4',
        'rankology_google_analytics_download_tracking',
        'rankology_google_analytics_opt_out_msg',
        'rankology_google_analytics_opt_out_msg_ok',
        'rankology_google_analytics_opt_out_msg_close',
        'rankology_google_analytics_opt_out_msg_edit',
        'rankology_google_analytics_other_tracking',
        'rankology_google_analytics_other_tracking_body',
        'rankology_google_analytics_optimize',
        'rankology_google_analytics_ads',
        'rankology_google_analytics_cross_domain',
        'rankology_google_analytics_cb_backdrop_bg',
        'rankology_google_analytics_cb_exp_date',
        'rankology_google_analytics_cb_bg',
        'rankology_google_analytics_cb_txt_col',
        'rankology_google_analytics_cb_lk_col',
        'rankology_google_analytics_cb_btn_bg',
        'rankology_google_analytics_cb_btn_col',
        'rankology_google_analytics_cb_btn_bg_hov',
        'rankology_google_analytics_cb_btn_col_hov',
        'rankology_google_analytics_cb_btn_sec_bg',
        'rankology_google_analytics_cb_btn_sec_col',
        'rankology_google_analytics_cb_btn_sec_bg_hov',
        'rankology_google_analytics_cb_btn_sec_col_hov',
        'rankology_google_analytics_cb_width',
        'rankology_instant_indexing_bing_api_key',
        'rankology_instant_indexing_manual_batch',
        //'rankology_instant_indexing_google_api_key',
    ];

    $rankology_esc_attr = [
        'rankology_titles_sep',
    ];

    $rankology_sanitize_site_verification = [
        'rankology_advanced_advanced_google',
        'rankology_advanced_advanced_bing',
        'rankology_advanced_advanced_pinterest',
        'rankology_advanced_advanced_yandex',
    ];

    // If nonce verification passed, process the form data
    $newOptions = ['rankology_social_facebook_img_attachment_id', 'rankology_social_facebook_img_height', 'rankology_social_facebook_img_width'];

    foreach ($newOptions as $key => $value) {
        $post_val = isset($_POST[$value]) ? rankology_esc_form_val($_POST[$value]) : '';
        if (!isset($input[$value]) && !empty($post_val)) {
            $input[$value] = $post_val;
        }
    }

    foreach ($rankology_sanitize_fields as $value) {
        if (!empty($input['rankology_google_analytics_opt_out_msg']) && 'rankology_google_analytics_opt_out_msg' == $value) {
            $args = [
                'strong' => [],
                'em'     => [],
                'br'     => [],
                'a'      => [
                    'href'   => [],
                    'target' => [],
                ],
            ];
            $input[$value] = wp_kses($input[$value], $args);
        } elseif ((!empty($input['rankology_google_analytics_other_tracking']) && 'rankology_google_analytics_other_tracking' == $value) || (!empty($input['rankology_google_analytics_other_tracking_body']) && 'rankology_google_analytics_other_tracking_body' == $value) || (!empty($input['rankology_google_analytics_other_tracking_footer']) && 'rankology_google_analytics_other_tracking_footer' == $value)) {
            $input[$value] = $input[$value]; //No sanitization for this field
        } elseif ((!empty($input['rankology_instant_indexing_manual_batch']) && 'rankology_instant_indexing_manual_batch' == $value) || (!empty($input['rankology_social_accounts_extra']) && 'rankology_social_accounts_extra' == $value)) {
            $input[$value] = sanitize_textarea_field($input[$value]);
        } elseif (!empty($input[$value])) {
            $input[$value] = sanitize_text_field($input[$value]);
        }
    }

    foreach ($rankology_esc_attr as $value) {
        if (!empty($input[$value])) {
            $input[$value] = esc_attr($input[$value]);
        }
    }

    foreach ($rankology_sanitize_site_verification as $value) {
        if (!empty($input[$value])) {
            if (preg_match('#content=\'([^"]+)\'#', $input[$value], $m)) {
                $input[$value] = esc_attr($m[1]);
            } elseif (preg_match('#content="([^"]+)"#', $input[$value], $m)) {
                $input[$value] = esc_attr($m[1]);
            } else {
                $input[$value] = esc_attr($input[$value]);
            }
        }
    }

    return $input;
}
