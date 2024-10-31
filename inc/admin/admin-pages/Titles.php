<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

$this->options = get_option('rankology_titles_option_name');
if (function_exists('rankology_admin_header')) {
    echo rankology_admin_header();
} ?>
<form method="post"
    action="<?php echo rankology_set_admin_esx_url('options.php'); ?>"
    class="rankology-option">
    <?php
        echo rankology_common_esc_str($this->rankology_feature_title('titles'));
settings_fields('rankology_titles_option_group'); ?>

    <div id="rankology-tabs" class="wrap">
        <?php
            $current_tab = '';
$plugin_settings_tabs    = [
                'tab_rankology_titles_home'     => esc_html__('Home', 'wp-rankology'),
                'tab_rankology_titles_single'   => esc_html__('Post Types', 'wp-rankology'),
                'tab_rankology_titles_archives' => esc_html__('Archives', 'wp-rankology'),
                'tab_rankology_titles_tax'      => esc_html__('Taxonomies', 'wp-rankology'),
                'tab_rankology_titles_advanced' => esc_html__('Others', 'wp-rankology'),
            ];

echo '<div class="nav-tab-wrapper">';
foreach ($plugin_settings_tabs as $tab_key => $tab_caption) {
    echo '<a id="' . $tab_key . '-tab" class="nav-tab" href="?page=rankology-titles#tab=' . $tab_key . '">' . $tab_caption . '</a>';
}
echo '</div>'; ?>
        <div class="rankology-tab <?php if ('tab_rankology_titles_home' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_titles_home"><?php do_settings_sections('rankology-settings-admin-titles-home'); ?>
        </div>
        <div class="rankology-tab <?php if ('tab_rankology_titles_single' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_titles_single"><?php do_settings_sections('rankology-settings-admin-titles-single'); ?>
        </div>
        <div class="rankology-tab <?php if ('tab_rankology_titles_archives' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_titles_archives"><?php do_settings_sections('rankology-settings-admin-titles-archives'); ?>
        </div>
        <div class="rankology-tab <?php if ('tab_rankology_titles_tax' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_titles_tax"><?php do_settings_sections('rankology-settings-admin-titles-tax'); ?>
        </div>
        <div class="rankology-tab <?php if ('tab_rankology_titles_advanced' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_titles_advanced"><?php do_settings_sections('rankology-settings-admin-titles-advanced'); ?>
        </div>
    </div>

    <?php rankology_rkseo_submit_button(esc_html__('Save changes', 'wp-rankology')); ?>
</form>
<?php
