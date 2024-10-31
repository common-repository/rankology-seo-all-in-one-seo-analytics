<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Knowledge graph SECTION======================================================================
add_settings_section(
    'rankology_setting_section_social_knowledge', // ID
    '',
    //__("Knowledge graph","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_social_knowledge', // Callback
    'rankology-settings-admin-social-knowledge' // Page
);

add_settings_field(
    'rankology_social_knowledge_name', // ID
    esc_html__('Person name/organization', 'wp-rankology'), // Title
    'rankology_social_knowledge_name_callback', // Callback
    'rankology-settings-admin-social-knowledge', // Page
    'rankology_setting_section_social_knowledge' // Section
);

add_settings_field(
    'rankology_social_knowledge_type', // ID
    esc_html__('Person or organization', 'wp-rankology'), // Title
    'rankology_social_knowledge_type_callback', // Callback
    'rankology-settings-admin-social-knowledge', // Page
    'rankology_setting_section_social_knowledge' // Section
);

add_settings_field(
    'rankology_social_knowledge_img', // ID
    esc_html__('Your photo/organization logo', 'wp-rankology'), // Title
    'rankology_social_knowledge_img_callback', // Callback
    'rankology-settings-admin-social-knowledge', // Page
    'rankology_setting_section_social_knowledge' // Section
);

add_settings_field(
    'rankology_social_knowledge_contact_option', // ID
    esc_html__('Contact option (only for Organizations)', 'wp-rankology'), // Title
    'rankology_social_knowledge_contact_option_callback', // Callback
    'rankology-settings-admin-social-knowledge', // Page
    'rankology_setting_section_social_knowledge' // Section
);

add_settings_field(
    'rankology_social_knowledge_phone', // ID
    __("Organization's phone number (only for Organizations)", 'wp-rankology'), // Title
    'rankology_social_knowledge_phone_callback', // Callback
    'rankology-settings-admin-social-knowledge', // Page
    'rankology_setting_section_social_knowledge' // Section
);

add_settings_field(
    'rankology_social_knowledge_contact_type', // ID
    esc_html__('Contact type (only for Organizations)', 'wp-rankology'), // Title
    'rankology_social_knowledge_contact_type_callback', // Callback
    'rankology-settings-admin-social-knowledge', // Page
    'rankology_setting_section_social_knowledge' // Section
);

//Social SECTION=====================================================================================
add_settings_section(
    'rankology_setting_section_social_accounts', // ID
    '',
    //__("Social","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_social_accounts', // Callback
    'rankology-settings-admin-social-accounts' // Page
);

add_settings_field(
    'rankology_social_accounts_facebook', // ID
    esc_html__('Facebook Page URL', 'wp-rankology'), // Title
    'rankology_social_accounts_facebook_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

add_settings_field(
    'rankology_social_accounts_twitter', // ID
    esc_html__('Twitter Username', 'wp-rankology'), // Title
    'rankology_social_accounts_twitter_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

add_settings_field(
    'rankology_social_accounts_pinterest', // ID
    esc_html__('Pinterest URL', 'wp-rankology'), // Title
    'rankology_social_accounts_pinterest_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

add_settings_field(
    'rankology_social_accounts_instagram', // ID
    esc_html__('Instagram URL', 'wp-rankology'), // Title
    'rankology_social_accounts_instagram_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

add_settings_field(
    'rankology_social_accounts_youtube', // ID
    esc_html__('YouTube URL', 'wp-rankology'), // Title
    'rankology_social_accounts_youtube_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

add_settings_field(
    'rankology_social_accounts_linkedin', // ID
    esc_html__('LinkedIn URL', 'wp-rankology'), // Title
    'rankology_social_accounts_linkedin_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

add_settings_field(
    'rankology_social_accounts_extra', // ID
    esc_html__('Additional accounts', 'wp-rankology'), // Title
    'rankology_social_accounts_extra_callback', // Callback
    'rankology-settings-admin-social-accounts', // Page
    'rankology_setting_section_social_accounts' // Section
);

//Facebook SECTION=========================================================================
add_settings_section(
    'rankology_setting_section_social_facebook', // ID
    '',
    //__("Facebook","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_social_facebook', // Callback
    'rankology-settings-admin-social-facebook' // Page
);

add_settings_field(
    'rankology_social_facebook_og', // ID
    esc_html__('Enable Open Graph Data', 'wp-rankology'), // Title
    'rankology_social_facebook_og_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

add_settings_field(
    'rankology_social_facebook_img', // ID
    esc_html__('Upload default image', 'wp-rankology'), // Title
    'rankology_social_facebook_img_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

add_settings_field(
    'rankology_social_facebook_img_default', // ID
    esc_html__('Apply this image to all your og:image tag', 'wp-rankology'), // Title
    'rankology_social_facebook_img_default_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

add_settings_field(
    'rankology_social_facebook_img_cpt', // ID
    esc_html__('Define custom og:image tag for post type archive pages', 'wp-rankology'), // Title
    'rankology_social_facebook_img_cpt_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

add_settings_field(
    'rankology_social_facebook_link_ownership_id', // ID
    esc_html__('Facebook Link Ownership ID', 'wp-rankology'), // Title
    'rankology_social_facebook_link_ownership_id_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

add_settings_field(
    'rankology_social_facebook_admin_id', // ID
    esc_html__('Facebook Admin ID', 'wp-rankology'), // Title
    'rankology_social_facebook_admin_id_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

add_settings_field(
    'rankology_social_facebook_app_id', // ID
    esc_html__('Facebook App ID', 'wp-rankology'), // Title
    'rankology_social_facebook_app_id_callback', // Callback
    'rankology-settings-admin-social-facebook', // Page
    'rankology_setting_section_social_facebook' // Section
);

//Twitter SECTION==========================================================================
add_settings_section(
    'rankology_setting_section_social_twitter', // ID
    '',
    //__("Twitter","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_social_twitter', // Callback
    'rankology-settings-admin-social-twitter' // Page
);

add_settings_field(
    'rankology_social_twitter_card', // ID
    esc_html__('Enable Twitter Card', 'wp-rankology'), // Title
    'rankology_social_twitter_card_callback', // Callback
    'rankology-settings-admin-social-twitter', // Page
    'rankology_setting_section_social_twitter' // Section
);

add_settings_field(
    'rankology_social_twitter_card_og', // ID
    esc_html__('Use Open Graph by default', 'wp-rankology'), // Title
    'rankology_social_twitter_card_og_callback', // Callback
    'rankology-settings-admin-social-twitter', // Page
    'rankology_setting_section_social_twitter' // Section
);

add_settings_field(
    'rankology_social_twitter_card_img', // ID
    esc_html__('Default Twitter Image', 'wp-rankology'), // Title
    'rankology_social_twitter_card_img_callback', // Callback
    'rankology-settings-admin-social-twitter', // Page
    'rankology_setting_section_social_twitter' // Section
);

add_settings_field(
    'rankology_social_twitter_card_img_size', // ID
    esc_html__('Image size for Twitter Summary card', 'wp-rankology'), // Title
    'rankology_social_twitter_card_img_size_callback', // Callback
    'rankology-settings-admin-social-twitter', // Page
    'rankology_setting_section_social_twitter' // Section
);
