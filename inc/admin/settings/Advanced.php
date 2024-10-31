<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Advanced SECTION=========================================================================
add_settings_section(
    'rankology_setting_section_advanced_advanced', // ID
    '',
    //__("Advanced","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_advanced_advanced', // Callback
    'rankology-settings-admin-advanced-advanced' // Page
);

add_settings_field(
    'rankology_advanced_advanced_wp_generator', // ID
    esc_html__('Remove WordPress generator meta tag', 'wp-rankology'), // Title
    'rankology_advanced_advanced_wp_generator_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_wp_shortlink', // ID
    esc_html__('Remove WordPress shortlink meta tag', 'wp-rankology'), // Title
    'rankology_advanced_advanced_wp_shortlink_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_wp_rsd', // ID
    esc_html__('Remove RSD meta tag', 'wp-rankology'), // Title
    'rankology_advanced_advanced_wp_rsd_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_wp_wlw', // ID
    esc_html__('Remove Windows Live Writer meta tag', 'wp-rankology'), // Title
    'rankology_advanced_advanced_wp_wlw_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_tax_desc_editor', // ID
    esc_html__('Add Editor to taxonomy textarea', 'wp-rankology'), // Title
    'rankology_advanced_advanced_tax_desc_editor_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_category_url', // ID
    esc_html__('Remove /category/ in URL', 'wp-rankology'), // Title
    'rankology_advanced_advanced_category_url_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_product_cat_url', // ID
    esc_html__('Remove /product-category/ in URL', 'wp-rankology'), // Title
    'rankology_advanced_advanced_product_cat_url_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_replytocom', // ID
    esc_html__('Remove ?replytocom link to avoid duplicate content', 'wp-rankology'), // Title
    'rankology_advanced_advanced_replytocom_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_noreferrer', // ID
    esc_html__('Remove noreferrer link attribute in post content', 'wp-rankology'), // Title
    'rankology_advanced_advanced_noreferrer_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_hentry', // ID
    esc_html__('Remove hentry post class', 'wp-rankology'), // Title
    'rankology_advanced_advanced_hentry_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_comments_author_url', // ID
    esc_html__('Remove author URL', 'wp-rankology'), // Title
    'rankology_advanced_advanced_comments_author_url_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_comments_website', // ID
    esc_html__('Remove website field in comment form', 'wp-rankology'), // Title
    'rankology_advanced_advanced_comments_website_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_comments_form_link', // ID
    esc_html__('Add "nofollow noopener noreferrer" in comments form link', 'wp-rankology'), // Title
    'rankology_advanced_advanced_comments_form_link_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_wp_oembed', // ID
    esc_html__('Remove oEmbed links', 'wp-rankology'), // Title
    'rankology_advanced_advanced_wp_oembed_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_google', // ID
    esc_html__('Google site verification', 'wp-rankology'), // Title
    'rankology_advanced_advanced_google_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_bing', // ID
    esc_html__('Bing site verification', 'wp-rankology'), // Title
    'rankology_advanced_advanced_bing_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_yandex', // ID
    esc_html__('Yandex site verification', 'wp-rankology'), // Title
    'rankology_advanced_advanced_yandex_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

add_settings_field(
    'rankology_advanced_advanced_pinterest', // ID
    esc_html__('Pinterest site verification', 'wp-rankology'), // Title
    'rankology_advanced_advanced_pinterest_callback', // Callback
    'rankology-settings-admin-advanced-advanced', // Page
    'rankology_setting_section_advanced_advanced' // Section
);

//Appearance SECTION=======================================================================
add_settings_section(
    'rankology_setting_section_advanced_appearance', // ID
    '',
    //__("Appearance","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_advanced_appearance', // Callback
    'rankology-settings-admin-advanced-appearance' // Page
);

//Metaboxes
add_settings_section(
    'rankology_setting_section_advanced_appearance_metabox', // ID
    '',
    //__("Metaboxes","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_advanced_appearance_metabox', // Callback
    'rankology-settings-admin-advanced-appearance' // Page
);

add_settings_field(
    'rankology_advanced_appearance_universal_metabox', // ID
    esc_html__('Universal Metabox (Gutenberg)', 'wp-rankology'), // Title
    'rankology_advanced_appearance_universal_metabox_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_metabox' // Section
);
add_settings_field(
    'rankology_advanced_appearance_universal_metabox_disable', // ID
    esc_html__('Disable Universal Metabox', 'wp-rankology'), // Title
    'rankology_advanced_appearance_universal_metabox_disable_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_metabox' // Section
);

add_settings_field(
    'rankology_advanced_appearance_metabox_position', // ID
    __("Move SEO metabox's position", 'wp-rankology'), // Title
    'rankology_advanced_appearance_metaboxe_position_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_metabox' // Section
);

add_settings_field(
    'rankology_advanced_appearance_ca_metaboxe', // ID
    esc_html__('Remove Content Analysis Metabox', 'wp-rankology'), // Title
    'rankology_advanced_appearance_ca_metaboxe_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_metabox' // Section
);

//Columns
add_settings_section(
    'rankology_setting_section_advanced_appearance_col', // ID
    '',
    //__("Columns","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_advanced_appearance_col', // Callback
    'rankology-settings-admin-advanced-appearance' // Page
);

add_settings_field(
    'rankology_advanced_appearance_title_col', // ID
    esc_html__('Show Title tag column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_title_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_meta_desc_col', // ID
    esc_html__('Show Meta description column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_meta_desc_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_redirect_enable_col', // ID
    esc_html__('Show Redirection Enable column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_redirect_enable_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_redirect_url_col', // ID
    esc_html__('Show Redirect URL column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_redirect_url_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_canonical', // ID
    esc_html__('Show canonical URL column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_canonical_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_target_kw_col', // ID
    esc_html__('Show Target Keyword column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_target_kw_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_noindex_col', // ID
    esc_html__('Show noindex column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_noindex_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_nofollow_col', // ID
    esc_html__('Show nofollow column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_nofollow_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_words_col', // ID
    esc_html__('Show total number of words column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_words_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_appearance_score_col', // ID
    esc_html__('Show content analysis score column in post types', 'wp-rankology'), // Title
    'rankology_advanced_appearance_score_col_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_col' // Section
);

add_settings_field(
    'rankology_advanced_security_metaboxe_role', // ID
    esc_html__('Disable SEO metabox for user roles', 'wp-rankology'), // Title
    'rankology_advanced_security_metaboxe_role_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_metabox' // Section
);

add_settings_field(
    'rankology_advanced_security_metaboxe_ca_role', // ID
    esc_html__('Disable Content overview metabox for user roles', 'wp-rankology'), // Title
    'rankology_advanced_security_metaboxe_ca_role_callback', // Callback
    'rankology-settings-admin-advanced-appearance', // Page
    'rankology_setting_section_advanced_appearance_metabox' // Section
);

// add_settings_field(
//     'rankology_advanced_security_metaboxe_sdt_role', // ID
//     esc_html__('Disable Structured Data Types metabox for user roles', 'wp-rankology'), // Title
//     'rankology_advanced_security_metaboxe_sdt_role_callback', // Callback
//     'rankology-settings-admin-advanced-appearance', // Page
//     'rankology_setting_section_advanced_appearance_metabox' // Section
// );

do_action('rankology_settings_advanced_after');
