<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

$this->options = get_option('rankology_import_export_option_name');

    if (function_exists('rankology_admin_header')) {
        echo rankology_admin_header();
    } ?>
<div class="rankology-option">
    <?php
        echo rankology_common_esc_str($this->rankology_feature_title(null));
        $current_tab = '';
    ?>
    <div id="rankology-tabs" class="wrap">
        <?php
                $plugin_settings_tabs = [
                    'tab_rankology_tool_settings'       => esc_html__('Settings', 'wp-rankology'),
                    'tab_rankology_tool_reset'          => esc_html__('Reset', 'wp-rankology'),
                ];

                $plugin_settings_tabs = apply_filters('rankology_tools_tabs', $plugin_settings_tabs);
    echo '<div class="nav-tab-wrapper">';
    foreach ($plugin_settings_tabs as $tab_key => $tab_caption) {
        echo '<a id="' . $tab_key . '-tab" class="nav-tab" href="?page=rankology-import-export#tab=' . $tab_key . '">' . $tab_caption . '</a>';
    }
    echo '</div>';

        do_action('rankology_tools_before', $current_tab, '');
    ?>
        <div class="rankology-tab <?php if ('tab_rankology_tool_settings' == $current_tab) {
        echo 'active';
    } ?>" id="tab_rankology_tool_settings">
            <div class="postbox section-tool">
                <div class="rkseo-section-header">
                    <h2>
                        <?php esc_html_e('Settings', 'wp-rankology'); ?>
                    </h2>
                </div>
                <div class="inside">
                    <h3><span><?php esc_html_e('Export plugin settings', 'wp-rankology'); ?></span>
                    </h3>

                    <p><?php esc_html_e('Export the plugin settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'wp-rankology'); ?>
                    </p>

                    <form method="post">
                        <input type="hidden" name="rankology_action" value="export_settings" />
                        <?php wp_nonce_field('rankology_export_nonce', 'rankology_export_nonce'); ?>

                        <button id="rankology-export" type="submit" class="btn btnTertiary">
                            <?php esc_html_e('Export', 'wp-rankology'); ?>
                        </button>
                    </form>
                </div><!-- .inside -->
            </div><!-- .postbox -->

            <div class="postbox section-tool">
                <div class="inside">
                    <h3><span><?php esc_html_e('Import plugin settings', 'wp-rankology'); ?></span>
                    </h3>

                    <p><?php esc_html_e('Import the plugin settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'wp-rankology'); ?>
                    </p>

                    <form method="post" enctype="multipart/form-data">
                        <p>
                            <input type="file" name="import_file" />
                        </p>
                        <input type="hidden" name="rankology_action" value="import_settings" />

                        <?php wp_nonce_field('rankology_import_nonce', 'rankology_import_nonce'); ?>

                        <button id="rankology-import-settings" type="submit" class="btn btnTertiary">
                            <?php esc_html_e('Import', 'wp-rankology'); ?>
                        </button>

                        <?php 
                        $success = isset($_GET['success']) ? sanitize_text_field(wp_unslash($_GET['success'])) : '';

                        if (!empty($success) && 'true' === $success) {
                            echo '<div class="log" style="display:block"><div class="rankology-notice is-success"><p>' . esc_html__('Import completed!', 'wp-rankology') . '</p></div></div>';
                        }
                        ?>
                    </form>
                </div><!-- .inside -->
            </div><!-- .postbox -->
            <div class="postbox section-tool" style="display: none;">
                <div class="inside">
                    <h3>
                        <span><?php esc_html_e('Import Settings', 'wp-rankology'); ?></span>
                    </h3>

                    <?php
                    $plugins = [
                        'yoast'            => 'Yoast SEO',
                        'aio'              => 'All In One SEO',
                        'seo-framework'    => 'The SEO Framework',
                        'rk'               => 'Rank Math',
                        'squirrly'         => 'Squirrly SEO',
                        'seo-ultimate'     => 'SEO Ultimate',
                        'wp-meta-seo'      => 'WP Meta SEO',
                        'premium-seo-pack' => 'Premium SEO Pack',
                        'wpseo'            => 'wpSEO',
                        'platinum-seo'     => 'Platinum SEO Pack',
                        'smart-crawl'      => 'SmartCrawl',
                        'rankologyor'       => 'Rankologyor',
                        'slim-seo'         => 'Slim SEO'
                    ];

                    echo '<p>
                    <select id="select-wizard-import" name="select-wizard-import">
                        <option value="none">' . esc_html__('Select an option', 'wp-rankology') . '</option>';

                    foreach ($plugins as $plugin => $name) {
                        echo '<option value="' . $plugin . '-migration-tool">' . $name . '</option>';
                    }
                    echo '</select>
                        </p>

                    <p class="description">' . esc_html__('You don\'t have to enable the selected SEO plugin to run the import.', 'wp-rankology') . '</p>';

                    foreach ($plugins as $plugin => $name) {
                        echo rankology_migration_tool($plugin, $name);
                    } ?>
                </div>
            </div>
        </div>
        
       <?php do_action('rankology_tools_migration', $current_tab); ?>
        <div class="rankology-tab <?php if ('tab_rankology_tool_reset' == $current_tab) {
        echo 'active';
    } ?>" id="tab_rankology_tool_reset">
            <div class="postbox section-tool">
                <div class="rkseo-section-header">
                    <h2>
                        <?php esc_html_e('Cleaning', 'wp-rankology'); ?>
                    </h2>
                </div>
                <div class="inside">
                    <h3>
                        <span><?php esc_html_e('Clean content scans', 'wp-rankology'); ?></span>
                    </h3>

                    <p><?php esc_html_e('By clicking Delete content scans, all content analysis will be deleted from your database.', 'wp-rankology'); ?></p>

                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="rankology_action" value="clean_content_scans" />
                        <?php wp_nonce_field('rankology_clean_content_scans_nonce', 'rankology_clean_content_scans_nonce'); ?>
                        <?php rankology_rkseo_submit_button(esc_html__('Delete content scans', 'wp-rankology'), 'btn btnTertiary'); ?>
                    </form>
                </div><!-- .inside -->
            </div><!-- .postbox -->

            <div class="postbox section-tool">
                <div class="rkseo-section-header">
                    <h2>
                        <?php esc_html_e('Reset', 'wp-rankology'); ?>
                    </h2>
                </div>
                <div class="inside">
                    <h3>
                        <span><?php esc_html_e('Reset All Notices From Notifications Center', 'wp-rankology'); ?></span>
                    </h3>

                    <p><?php esc_html_e('By clicking Reset Notices, all notices in the notifications center will be set to their initial status.', 'wp-rankology'); ?></p>

                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="rankology_action" value="reset_notices_settings" />
                        <?php wp_nonce_field('rankology_reset_notices_nonce', 'rankology_reset_notices_nonce'); ?>
                        <?php rankology_rkseo_submit_button(esc_html__('Reset notices', 'wp-rankology'), 'btn btnTertiary'); ?>
                    </form>
                </div><!-- .inside -->
            </div><!-- .postbox -->

            <div class="postbox section-tool">
                <div class="inside">
                    <h3><?php esc_html_e('Reset All Settings', 'wp-rankology'); ?></h3>

                    <div class="rankology-notice is-warning">
                        <p><?php esc_html_e('<strong>WARNING:</strong> Delete all options related to this plugin in your database.', 'wp-rankology'); ?></p>
                    </div>

                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="rankology_action" value="reset_settings" />
                        <?php wp_nonce_field('rankology_reset_nonce', 'rankology_reset_nonce'); ?>
                        <?php rankology_rkseo_submit_button(esc_html__('Reset settings', 'wp-rankology'), 'btn btnTertiary is-deletable'); ?>
                    </form>
                </div><!-- .inside -->
            </div><!-- .postbox -->
        </div>
    </div>
</div>
<?php
