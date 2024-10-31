<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//XML Sitemap SECTION======================================================================
add_settings_section(
    'rankology_setting_section_xml_sitemap_general', // ID
    '',
    //__("General","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_xml_sitemap_general', // Callback
    'rankology-settings-admin-xml-sitemap-general' // Page
);

add_settings_field(
    'rankology_xml_sitemap_general_enable', // ID
    esc_html__('XML Sitemap', 'wp-rankology'), // Title
    'rankology_xml_sitemap_general_enable_callback', // Callback
    'rankology-settings-admin-xml-sitemap-general', // Page
    'rankology_setting_section_xml_sitemap_general' // Section
);

add_settings_field(
    'rankology_xml_sitemap_img_enable', // ID
    esc_html__('XML Image Sitemap', 'wp-rankology'), // Title
    'rankology_xml_sitemap_img_enable_callback', // Callback
    'rankology-settings-admin-xml-sitemap-general', // Page
    'rankology_setting_section_xml_sitemap_general' // Section
);

//do_action('rankology_settings_sitemaps_image_after');
if (function_exists('rankology_fno_activation')) {
    add_settings_field(
        'rankology_xml_sitemap_video_enable', // ID
        esc_html__('XML Video Sitemap', 'wp-rankology'), // Title
        'rankology_fno_xml_sitemap_video_enable_callback', // Callback
        'rankology-settings-admin-xml-sitemap-general', // Page
        'rankology_setting_section_xml_sitemap_general' // Section
    );
}

add_settings_field(
    'rankology_xml_sitemap_author_enable', // ID
    esc_html__('Author Sitemap', 'wp-rankology'), // Title
    'rankology_xml_sitemap_author_enable_callback', // Callback
    'rankology-settings-admin-xml-sitemap-general', // Page
    'rankology_setting_section_xml_sitemap_general' // Section
);

add_settings_field(
    'rankology_xml_sitemap_html_enable', // ID
    esc_html__('HTML Sitemap', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_enable_callback', // Callback
    'rankology-settings-admin-xml-sitemap-general', // Page
    'rankology_setting_section_xml_sitemap_general' // Section
);

add_settings_section(
    'rankology_setting_section_xml_sitemap_post_types', // ID
    '',
    //__("Post Types","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_xml_sitemap_post_types', // Callback
    'rankology-settings-admin-xml-sitemap-post-types' // Page
);

add_settings_field(
    'rankology_xml_sitemap_post_types_list', // ID
    esc_html__('Check to INCLUDE Post Types', 'wp-rankology'), // Title
    'rankology_xml_sitemap_post_types_list_callback', // Callback
    'rankology-settings-admin-xml-sitemap-post-types', // Page
    'rankology_setting_section_xml_sitemap_post_types' // Section
);

add_settings_section(
    'rankology_setting_section_xml_sitemap_taxonomies', // ID
    '',
    //__("Taxonomies","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_xml_sitemap_taxonomies', // Callback
    'rankology-settings-admin-xml-sitemap-taxonomies' // Page
);

add_settings_field(
    'rankology_xml_sitemap_taxonomies_list', // ID
    esc_html__('Check to INCLUDE Taxonomies', 'wp-rankology'), // Title
    'rankology_xml_sitemap_taxonomies_list_callback', // Callback
    'rankology-settings-admin-xml-sitemap-taxonomies', // Page
    'rankology_setting_section_xml_sitemap_taxonomies' // Section
);

add_settings_section(
    'rankology_setting_section_html_sitemap', // ID
    '',
    //__("HTML Sitemap","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_html_sitemap', // Callback
    'rankology-settings-admin-html-sitemap' // Page
);

add_settings_field(
    'rankology_xml_sitemap_html_order', // ID
    esc_html__('Sort order', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_order_callback', // Callback
    'rankology-settings-admin-html-sitemap', // Page
    'rankology_setting_section_html_sitemap' // Section
);

add_settings_field(
    'rankology_xml_sitemap_html_orderby', // ID
    esc_html__('Order posts by', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_orderby_callback', // Callback
    'rankology-settings-admin-html-sitemap', // Page
    'rankology_setting_section_html_sitemap' // Section
);

add_settings_field(
    'rankology_xml_sitemap_html_mapping', // ID
    esc_html__('Inlude post, pages ID(s) to sitemap (comma separated)', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_mapping_callback', // Callback
    'rankology-settings-admin-html-sitemap', // Page
    'rankology_setting_section_html_sitemap' // Section
);

add_settings_field(
    'rankology_xml_sitemap_html_exclude', // ID
    esc_html__('Exclude posts, pages ID(s) (comma separated)', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_exclude_callback', // Callback
    'rankology-settings-admin-html-sitemap', // Page
    'rankology_setting_section_html_sitemap' // Section
);

add_settings_field(
    'rankology_xml_sitemap_html_date', // ID
    esc_html__('Disable the display of the publication date', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_date_callback', // Callback
    'rankology-settings-admin-html-sitemap', // Page
    'rankology_setting_section_html_sitemap' // Section
);

add_settings_field(
    'rankology_xml_sitemap_html_archive_links', // ID
    esc_html__('Remove links from archive pages', 'wp-rankology'), // Title
    'rankology_xml_sitemap_html_archive_links_callback', // Callback
    'rankology-settings-admin-html-sitemap', // Page
    'rankology_setting_section_html_sitemap' // Section
);
