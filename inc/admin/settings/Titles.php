<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

add_settings_section(
    'rankology_setting_section_titles_home', // ID
    '',
    //__("Home","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_titles', // Callback
    'rankology-settings-admin-titles-home' // Page
);

add_settings_field(
    'rankology_titles_home_site_title', // ID
    esc_html__('Site title', 'wp-rankology'), // Title
    'rankology_titles_home_site_title_callback', // Callback
    'rankology-settings-admin-titles-home', // Page
    'rankology_setting_section_titles_home' // Section
);

add_settings_field(
    'rankology_titles_home_site_title_alt', // ID
    esc_html__('Alternative site title', 'wp-rankology'), // Title
    'rankology_titles_home_site_title_alt_callback', // Callback
    'rankology-settings-admin-titles-home', // Page
    'rankology_setting_section_titles_home' // Section
);

add_settings_field(
    'rankology_titles_sep', // ID
    esc_html__('Separator', 'wp-rankology'), // Title
    'rankology_titles_sep_callback', // Callback
    'rankology-settings-admin-titles-home', // Page
    'rankology_setting_section_titles_home' // Section
);

add_settings_field(
    'rankology_titles_home_site_desc', // ID
    esc_html__('Meta description', 'wp-rankology'), // Title
    'rankology_titles_home_site_desc_callback', // Callback
    'rankology-settings-admin-titles-home', // Page
    'rankology_setting_section_titles_home' // Section
);

add_settings_section(
    'rankology_setting_section_titles_single', // ID
    '',
    //__("Post Types","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_single', // Callback
    'rankology-settings-admin-titles-single' // Page
);

add_settings_field(
    'rankology_titles_single_titles', // ID
    '',
    'rankology_titles_single_titles_callback', // Callback
    'rankology-settings-admin-titles-single', // Page
    'rankology_setting_section_titles_single' // Section
);

if (is_plugin_active('buddypress/bp-loader.php') || is_plugin_active('buddyboss-platform/bp-loader.php')) {
    add_settings_field(
        'rankology_titles_bp_groups_title', // ID
        '',
        'rankology_titles_bp_groups_title_callback', // Callback
        'rankology-settings-admin-titles-single', // Page
        'rankology_setting_section_titles_single' // Section
    );

    add_settings_field(
        'rankology_titles_bp_groups_desc', // ID
        '',
        'rankology_titles_bp_groups_desc_callback', // Callback
        'rankology-settings-admin-titles-single', // Page
        'rankology_setting_section_titles_single' // Section
    );

    add_settings_field(
        'rankology_titles_bp_groups_noindex', // ID
        '',
        'rankology_titles_bp_groups_noindex_callback', // Callback
        'rankology-settings-admin-titles-single', // Page
        'rankology_setting_section_titles_single' // Section
    );
}

add_settings_section(
    'rankology_setting_section_titles_archives', // ID
    '',
    //__("Archives","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_archives', // Callback
    'rankology-settings-admin-titles-archives' // Page
);

add_settings_field(
    'rankology_titles_archives_titles', // ID
    '',
    'rankology_titles_archives_titles_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_author_title', // ID
    '',
    //__('Title template','wp-rankology'),
    'rankology_titles_archives_author_title_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_author_desc', // ID
    '',
    //__('Meta description template','wp-rankology'),
    'rankology_titles_archives_author_desc_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_author_noindex', // ID
    '',
    //__("noindex","wp-rankology"), // Title
    'rankology_titles_archives_author_noindex_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_author_disable', // ID
    '',
    //__("disable","wp-rankology"), // Title
    'rankology_titles_archives_author_disable_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_date_title', // ID
    '',
    //__('Title template','wp-rankology'),
    'rankology_titles_archives_date_title_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_date_desc', // ID
    '',
    //__('Meta description template','wp-rankology'),
    'rankology_titles_archives_date_desc_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_date_noindex', // ID
    '',
    //__("noindex","wp-rankology"), // Title
    'rankology_titles_archives_date_noindex_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_date_disable', // ID
    '',
    //__("disable","wp-rankology"), // Title
    'rankology_titles_archives_date_disable_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_search_title', // ID
    '',
    //__('Title template','wp-rankology'),
    'rankology_titles_archives_search_title_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_search_desc', // ID
    '',
    //__('Meta description template','wp-rankology'),
    'rankology_titles_archives_search_desc_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_search_title_noindex', // ID
    '',
    //__('noindex','wp-rankology'),
    'rankology_titles_archives_search_title_noindex_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_404_title', // ID
    '',
    //__('Title template','wp-rankology'),
    'rankology_titles_archives_404_title_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

add_settings_field(
    'rankology_titles_archives_404_desc', // ID
    '',
    //__('Meta description template','wp-rankology'),
    'rankology_titles_archives_404_desc_callback', // Callback
    'rankology-settings-admin-titles-archives', // Page
    'rankology_setting_section_titles_archives' // Section
);

//Taxonomies SECTION=======================================================================
add_settings_section(
    'rankology_setting_section_titles_tax', // ID
    '',
    //__("Taxonomies","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_tax', // Callback
    'rankology-settings-admin-titles-tax' // Page
);

add_settings_field(
    'rankology_titles_tax_titles', // ID
    '',
    'rankology_titles_tax_titles_callback', // Callback
    'rankology-settings-admin-titles-tax', // Page
    'rankology_setting_section_titles_tax' // Section
);

//Advanced SECTION=========================================================================
add_settings_section(
    'rankology_setting_section_titles_advanced', // ID
    '',
    //__("Advanced","wp-rankology"), // Title
    'rankology_rkseo_print_section_info_advanced', // Callback
    'rankology-settings-admin-titles-advanced' // Page
);

add_settings_field(
    'rankology_titles_nofollow', // ID
    esc_html__('nofollow', 'wp-rankology'), // Title
    'rankology_titles_nofollow_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_paged_rel', // ID
    esc_html__('Indicate paginated content to Google', 'wp-rankology'), // Title
    'rankology_titles_paged_rel_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_paged_noindex', // ID
    esc_html__('noindex on paged archives', 'wp-rankology'), // Title
    'rankology_titles_paged_noindex_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);
add_settings_field(
    'rankology_titles_attachments_noindex', // ID
    esc_html__('noindex on attachment pages', 'wp-rankology'), // Title
    'rankology_titles_attachments_noindex_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_noindex', // ID
    esc_html__('noindex', 'wp-rankology'), // Title
    'rankology_titles_noindex_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_nosnippet', // ID
    esc_html__('nosnippet', 'wp-rankology'), // Title
    'rankology_titles_nosnippet_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_nositelinkssearchbox', // ID
    esc_html__('nositelinkssearchbox', 'wp-rankology'), // Title
    'rankology_titles_nositelinkssearchbox_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_noimageindex', // ID
    esc_html__('noimageindex', 'wp-rankology'), // Title
    'rankology_titles_noimageindex_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);

add_settings_field(
    'rankology_titles_noarchive', // ID
    esc_html__('noarchive', 'wp-rankology'), // Title
    'rankology_titles_noarchive_callback', // Callback
    'rankology-settings-admin-titles-advanced', // Page
    'rankology_setting_section_titles_advanced' // Section
);
