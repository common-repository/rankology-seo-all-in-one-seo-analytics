<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

$this->options = get_option('rankology_xml_sitemap_option_name');
if (function_exists('rankology_admin_header')) {
    echo rankology_admin_header();
} ?>
<form method="post" action="<?php echo rankology_set_admin_esx_url('options.php'); ?>" class="rankology-option" name="rankology-flush">
    <?php
        echo rankology_common_esc_str($this->rankology_feature_title('xml-sitemap'));
settings_fields('rankology_xml_sitemap_option_group'); ?>

    <div id="rankology-tabs" class="wrap">
        <?php
            $current_tab = '';
$plugin_settings_tabs    = [
                'tab_rankology_xml_sitemap_post_types' => esc_html__('Post Types', 'wp-rankology'),
                'tab_rankology_xml_sitemap_taxonomies' => esc_html__('Taxonomies', 'wp-rankology'),
                'tab_rankology_html_sitemap'           => esc_html__('HTML Sitemap', 'wp-rankology'),
                'tab_rankology_xml_sitemap_general'    => esc_html__('Others', 'wp-rankology'),
            ];

echo '<div class="nav-tab-wrapper">';
foreach ($plugin_settings_tabs as $tab_key => $tab_caption) {
    echo '<a id="' . $tab_key . '-tab" class="nav-tab" href="?page=rankology-xml-sitemap#tab=' . $tab_key . '">' . $tab_caption . '</a>';
}
echo '</div>'; ?>
                <div class="rankology-tab <?php if ('tab_rankology_xml_sitemap_general' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_xml_sitemap_general"><?php do_settings_sections('rankology-settings-admin-xml-sitemap-general'); ?></div>
                <div class="rankology-tab <?php if ('tab_rankology_xml_sitemap_post_types' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_xml_sitemap_post_types"><?php do_settings_sections('rankology-settings-admin-xml-sitemap-post-types'); ?></div>
                <div class="rankology-tab <?php if ('tab_rankology_xml_sitemap_taxonomies' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_xml_sitemap_taxonomies"><?php do_settings_sections('rankology-settings-admin-xml-sitemap-taxonomies'); ?></div>
                <div class="rankology-tab <?php if ('tab_rankology_html_sitemap' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_html_sitemap"><?php do_settings_sections('rankology-settings-admin-html-sitemap'); ?></div>
        </div>

        <?php rankology_rkseo_submit_button(esc_html__('Save changes', 'wp-rankology')); ?>
    </form>
<?php
