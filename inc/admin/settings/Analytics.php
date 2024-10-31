<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

add_settings_section(
    'rankology_setting_section_google_analytics_enable', // ID
    '',
    'rankology_rkseo_print_section_info_google_analytics_enable', // Callback
    'rankology-settings-admin-google-analytics-enable' // Page
);

add_settings_field(
    'rankology_google_analytics_enable', // ID
    esc_html__('Google Analytics tracking', 'wp-rankology'), // Title
    'rankology_google_analytics_enable_callback', // Callback
    'rankology-settings-admin-google-analytics-features', // Page
    'rankology_setting_section_google_analytics_features' // Section
);

add_settings_field(
    'rankology_google_analytics_ga4', // ID
    esc_html__('Enter measurement ID (GA4)', 'wp-rankology'), // Title
    'rankology_google_analytics_ga4_callback', // Callback
    'rankology-settings-admin-google-analytics-features', // Page
    'rankology_setting_section_google_analytics_features' // Section
);


add_settings_section(
    'rankology_setting_section_google_analytics_gdpr', // ID
    '',
    'rankology_rkseo_print_section_info_google_analytics_gdpr', // Callback
    'rankology-settings-admin-google-analytics-gdpr' // Page
);

add_settings_field(
    'rankology_google_analytics_hook', // ID
    esc_html__('Place for cookie bar at webpage', 'wp-rankology'), // Title
    'rankology_google_analytics_hook_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_half_disable', // ID
    '', // Title
    'rankology_google_analytics_half_disable_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_opt_out_edit_choice', // ID
    esc_html__('Allow user to change its choice', 'wp-rankology'), // Title
    'rankology_google_analytics_opt_out_edit_choice_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_disable', // ID
    esc_html__('Analytics tracking opt-in', 'wp-rankology'), // Title
    'rankology_google_analytics_disable_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_opt_out_msg', // ID
    esc_html__('Consent message for user tracking', 'wp-rankology'), // Title
    'rankology_google_analytics_opt_out_msg_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_opt_out_msg_ok', // ID
    esc_html__('Accept button for user tracking', 'wp-rankology'), // Title
    'rankology_google_analytics_opt_out_msg_ok_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_opt_out_msg_close', // ID
    esc_html__('Close button', 'wp-rankology'), // Title
    'rankology_google_analytics_opt_out_msg_close_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_opt_out_msg_edit', // ID
    esc_html__('Edit cookies button', 'wp-rankology'), // Title
    'rankology_google_analytics_opt_out_msg_edit_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_exp_date', // ID
    esc_html__('User consent cookie expiration date', 'wp-rankology'), // Title
    'rankology_google_analytics_cb_exp_date_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_pos', // ID
    esc_html__('Cookie bar position', 'wp-rankology'), // Title
    'rankology_google_analytics_cb_pos_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_txt_align', // ID
    esc_html__('Text alignment', 'wp-rankology'), // Title
    'rankology_google_analytics_cb_txt_align_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_width', // ID
    esc_html__('Cookie bar width', 'wp-rankology'), // Title
    'rankology_google_analytics_cb_width_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_backdrop', // ID
    '', // Title
    'rankology_google_analytics_cb_backdrop_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_backdrop_bg', // ID
    '', // Title
    'rankology_google_analytics_cb_backdrop_bg_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_bg', // ID
    '', // Title
    'rankology_google_analytics_cb_bg_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_txt_col', // ID
    '', // Title
    'rankology_google_analytics_cb_txt_col_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_lk_col', // ID
    '', // Title
    'rankology_google_analytics_cb_lk_col_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_bg', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_bg_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_bg_hov', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_bg_hov_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_col', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_col_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_col_hov', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_col_hov_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_sec_bg', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_sec_bg_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_sec_col', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_sec_col_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_sec_bg_hov', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_sec_bg_hov_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);

add_settings_field(
    'rankology_google_analytics_cb_btn_sec_col_hov', // ID
    '', // Title
    'rankology_google_analytics_cb_btn_sec_col_hov_callback', // Callback
    'rankology-settings-admin-google-analytics-gdpr', // Page
    'rankology_setting_section_google_analytics_gdpr' // Section
);


add_settings_section(
    'rankology_setting_section_google_analytics_features', // ID
    '',
    //__("Google Analytics","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_google_analytics_features', // Callback
    'rankology-settings-admin-google-analytics-features' // Page
);

add_settings_field(
    'rankology_google_analytics_ads', // ID
    esc_html__('Enable Google Ads', 'wp-rankology'), // Title
    'rankology_google_analytics_ads_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);

add_settings_field(
    'rankology_google_analytics_optimize', // ID
    esc_html__('Enable Google Optimize', 'wp-rankology'), // Title
    'rankology_google_analytics_optimize_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);


add_settings_field(
    'rankology_google_analytics_remarketing', // ID
    esc_html__('Enable remarketing', 'wp-rankology'), // Title
    'rankology_google_analytics_remarketing_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);

add_settings_field(
    'rankology_google_analytics_ip_anonymization', // ID
    esc_html__('IP Anonymization', 'wp-rankology'), // Title
    'rankology_google_analytics_ip_anonymization_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);

add_settings_field(
    'rankology_google_analytics_cross_domain_enable', // ID
    esc_html__('Cross-domain tracking', 'wp-rankology'), // Title
    'rankology_google_analytics_cross_enable_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);

add_settings_field(
    'rankology_google_analytics_link_attribution', // ID
    esc_html__('Enhanced Link Attribution', 'wp-rankology'), // Title
    'rankology_google_analytics_link_attribution_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);

add_settings_field(
    'rankology_google_analytics_cross_domain', // ID
    esc_html__('Cross domains', 'wp-rankology'), // Title
    'rankology_google_analytics_cross_domain_callback', // Callback
    'rankology-settings-admin-google-analytics-enable', // Page
    'rankology_setting_section_google_analytics_enable' // Section
);


add_settings_section(
    'rankology_setting_section_google_analytics_custom_tracking', // ID
    '',
    //__("Google Analytics","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_google_analytics_custom_tracking', // Callback
    'rankology-settings-admin-google-analytics-custom-tracking' // Page
);

add_settings_field(
    'rankology_google_analytics_other_tracking', // ID
    esc_html__('Tracking code in header', 'wp-rankology'), // Title
    'rankology_google_analytics_other_tracking_callback', // Callback
    'rankology-settings-admin-google-analytics-custom-tracking', // Page
    'rankology_setting_section_google_analytics_custom_tracking' // Section
);

add_settings_field(
    'rankology_google_analytics_other_tracking_body', // ID
    esc_html__('Tracking code in body', 'wp-rankology'), // Title
    'rankology_google_analytics_other_tracking_body_callback', // Callback
    'rankology-settings-admin-google-analytics-custom-tracking', // Page
    'rankology_setting_section_google_analytics_custom_tracking' // Section
);

add_settings_field(
    'rankology_google_analytics_other_tracking_footer', // ID
    esc_html__('Tracking code footer', 'wp-rankology'), // Title
    'rankology_google_analytics_other_tracking_footer_callback', // Callback
    'rankology-settings-admin-google-analytics-custom-tracking', // Page
    'rankology_setting_section_google_analytics_custom_tracking' // Section
);


add_settings_section(
    'rankology_setting_section_google_analytics_events', // ID
    '',
    //__("Google Analytics","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_google_analytics_events', // Callback
    'rankology-settings-admin-google-analytics-events' // Page
);

add_settings_field(
    'rankology_google_analytics_link_tracking_enable', // ID
    esc_html__('Enable external links tracking', 'wp-rankology'), // Title
    'rankology_google_analytics_link_tracking_enable_callback', // Callback
    'rankology-settings-admin-google-analytics-events', // Page
    'rankology_setting_section_google_analytics_events' // Section
);

add_settings_field(
    'rankology_google_analytics_download_tracking_enable', // ID
    esc_html__('Enable downloads tracking (e.g. DOCX, PDF, XLSX) files', 'wp-rankology'), // Title
    'rankology_google_analytics_download_tracking_enable_callback', // Callback
    'rankology-settings-admin-google-analytics-events', // Page
    'rankology_setting_section_google_analytics_events' // Section
);

add_settings_field(
    'rankology_google_analytics_download_tracking', // ID
    __("Track downloads' clicks", 'wp-rankology'), // Title
    'rankology_google_analytics_download_tracking_callback', // Callback
    'rankology-settings-admin-google-analytics-events', // Page
    'rankology_setting_section_google_analytics_events' // Section
);

add_settings_field(
    'rankology_google_analytics_affiliate_tracking_enable', // ID
    esc_html__('Enable affiliate/outbound links tracking', 'wp-rankology'), // Title
    'rankology_google_analytics_affiliate_tracking_enable_callback', // Callback
    'rankology-settings-admin-google-analytics-events', // Page
    'rankology_setting_section_google_analytics_events' // Section
);

add_settings_field(
    'rankology_google_analytics_affiliate_tracking', // ID
    esc_html__('Track affiliate/outbound links', 'wp-rankology'), // Title
    'rankology_google_analytics_affiliate_tracking_callback', // Callback
    'rankology-settings-admin-google-analytics-events', // Page
    'rankology_setting_section_google_analytics_events' // Section
);

add_settings_field(
    'rankology_google_analytics_phone_tracking', // ID
    esc_html__('Track phone links', 'wp-rankology'), // Title
    'rankology_google_analytics_phone_tracking_callback', // Callback
    'rankology-settings-admin-google-analytics-events', // Page
    'rankology_setting_section_google_analytics_events' // Section
);

add_settings_section(
    'rankology_setting_section_google_analytics_advanced', // ID
    '',
    //__("Advanced","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_google_analytics_advanced', // Callback
    'rankology-settings-admin-google-analytics-advanced' // Page
);

add_settings_field(
    'rankology_google_analytics_roles', // ID
    esc_html__('Exclude user roles from tracking (Google Analytics)', 'wp-rankology'), // Title
    'rankology_google_analytics_roles_callback', // Callback
    'rankology-settings-admin-google-analytics-advanced', // Page
    'rankology_setting_section_google_analytics_advanced' // Section
);