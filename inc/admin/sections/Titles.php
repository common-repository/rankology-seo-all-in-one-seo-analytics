<?php

defined('ABSPATH') or exit('Please don’t call the plugin directly. Thanks :)');

function rankology_rkseo_print_section_info_titles()
{
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Meta for Home Page', 'wp-rankology'); ?>
        </h2>
    </div>

    <p>
        <?php esc_html_e('Customize your header meta description for homepage.', 'wp-rankology'); ?>
    </p>
    <?php

    // Enqueue the inline script
    add_action('admin_enqueue_scripts', 'rankology_enqueue_admin_scripts_titles');
}

function rankology_enqueue_admin_scripts_titles()
{
    // Register an empty script handle to attach the inline script to
    wp_register_script('rankology-admin-titles', '', [], '', true);
    wp_enqueue_script('rankology-admin-titles');

    // Add the inline script
    wp_add_inline_script(
        'rankology-admin-titles',
        "function rankology_rkseo_get_field_length(e) {
            if (e.val().length > 0) {
                meta = e.val() + ' ';
            } else {
                meta = e.val();
            }
            return meta;
        }"
    );
}

function rankology_rkseo_print_section_info_single()
{
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Meta for all Post Types', 'wp-rankology'); ?>
        </h2>
    </div>
    <p>
        <?php esc_html_e('Customize your metas for all Single Post Types.', 'wp-rankology'); ?>
    </p>
    <?php
}

function rankology_rkseo_print_section_info_advanced()
{
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Other Settings', 'wp-rankology'); ?>
        </h2>
    </div>
    <p>
        <?php esc_html_e('Customize your metas for all pages.', 'wp-rankology'); ?>
    </p>
    <?php
}

function rankology_rkseo_print_section_info_tax()
{
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Meta for Taxonomies Pages', 'wp-rankology'); ?>
        </h2>
    </div>
    <p>
        <?php esc_html_e('Customize your metas for all taxonomies archives.', 'wp-rankology'); ?>
    </p>
    <?php
}

function rankology_rkseo_print_section_info_archives()
{
    ?>
    <div class="rkseo-section-header">
        <h2>
            <?php esc_html_e('Meta for Archives Pages', 'wp-rankology'); ?>
        </h2>
    </div>
    <p>
        <?php esc_html_e('Customize your metas for all archives.', 'wp-rankology'); ?>
    </p>
    <?php
}
