<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Image SECTION============================================================================
add_settings_section(
    'rankology_setting_section_advanced_image', // ID
    '',
    //__("Image SEO","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_advanced_image', // Callback
    'rankology-settings-admin-advanced-image' // Page
);

add_settings_field(
    'rankology_advanced_advanced_image_auto_alt_editor', // ID
    esc_html__('Automatically set the image Alt text', 'wp-rankology'), // Title
    'rankology_advanced_advanced_image_auto_alt_editor_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_image_auto_title_editor', // ID
    esc_html__('Automatically set the image Title', 'wp-rankology'), // Title
    'rankology_advanced_advanced_image_auto_title_editor_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_attachments', // ID
    esc_html__('Redirect attachment pages to post parent', 'wp-rankology'), // Title
    'rankology_advanced_advanced_attachments_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_attachments_file', // ID
    esc_html__('Redirect attachment pages to their file URL', 'wp-rankology'), // Title
    'rankology_advanced_advanced_attachments_file_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_image_auto_alt_target_kw', // ID
    esc_html__('Automatically set the image Alt text from target keywords', 'wp-rankology'), // Title
    'rankology_advanced_advanced_image_auto_alt_target_kw_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_image_auto_caption_editor', // ID
    esc_html__('Automatically set the image Caption', 'wp-rankology'), // Title
    'rankology_advanced_advanced_image_auto_caption_editor_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_image_auto_desc_editor', // ID
    esc_html__('Automatically set the image Description', 'wp-rankology'), // Title
    'rankology_advanced_advanced_image_auto_desc_editor_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);

add_settings_field(
    'rankology_advanced_advanced_clean_filename', // ID
    esc_html__('Cleaning media filename', 'wp-rankology'), // Title
    'rankology_advanced_advanced_clean_filename_callback', // Callback
    'rankology-settings-admin-advanced-image', // Page
    'rankology_setting_section_advanced_image' // Section
);
