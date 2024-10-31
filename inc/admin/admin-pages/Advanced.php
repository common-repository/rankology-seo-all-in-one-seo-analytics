<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

$this->options = get_option('rankology_advanced_option_name');
if (function_exists('rankology_admin_header')) {
    echo rankology_admin_header();
} ?>
<form method="post"
    action="<?php echo rankology_set_admin_esx_url('options.php'); ?>"
    class="rankology-option">
    <?php
        echo rankology_common_esc_str($this->rankology_feature_title('advanced'));
settings_fields('rankology_advanced_option_group'); ?>

    <div id="rankology-tabs" class="wrap">
        <?php
            $current_tab = 'tab_rankology_metaboxes_appearance';
            $plugin_settings_tabs    = [
                'tab_rankology_metaboxes_appearance'  => esc_html__('Metaboxes / Columns', 'wp-rankology'),
                'tab_rankology_metaboxes_advanced'    => esc_html__('Meta Settings', 'wp-rankology'),
            ];
        ?>
        <div class="nav-tab-wrapper">

            <?php foreach ($plugin_settings_tabs as $tab_key => $tab_caption) { ?>
            <a id="<?php echo rankology_common_esc_str($tab_key); ?>-tab" class="nav-tab"
                href="?page=rankology-metaboxes#tab=<?php echo rankology_common_esc_str($tab_key); ?>"><?php echo rankology_common_esc_str($tab_caption); ?></a>
            <?php } ?>

        </div>
        <div class="rankology-tab<?php if ('tab_rankology_metaboxes_advanced' == $current_tab) {
    echo ' active';
} ?>" id="tab_rankology_metaboxes_advanced"><?php do_settings_sections('rankology-settings-admin-advanced-advanced'); ?>
        </div>
        <div class="rankology-tab<?php if ('tab_rankology_metaboxes_appearance' == $current_tab) {
    echo ' active';
} ?>" id="tab_rankology_metaboxes_appearance"><?php do_settings_sections('rankology-settings-admin-advanced-appearance'); ?>
        </div>
    </div>

    <?php rankology_rkseo_submit_button(esc_html__('Save changes', 'wp-rankology')); ?>
</form>
<?php
