<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

$this->options = get_option('rankology_social_option_name');
if (function_exists('rankology_admin_header')) {
    echo rankology_admin_header();
} ?>
<form method="post" action="<?php echo rankology_set_admin_esx_url('options.php'); ?>" class="rankology-option">
    <?php
        echo rankology_common_esc_str($this->rankology_feature_title('social'));
settings_fields('rankology_social_option_group'); ?>

    <div id="rankology-tabs" class="wrap">
        <?php
            $current_tab = '';
            $plugin_settings_tabs    = [
                'tab_rankology_social_accounts'  => esc_html__('Social URLs', 'wp-rankology'),
                'tab_rankology_social_knowledge' => esc_html__('Google Graph', 'wp-rankology'),
                'tab_rankology_social_facebook'  => esc_html__('Facebook Graph', 'wp-rankology'),
                'tab_rankology_social_twitter'   => esc_html__('Twitter card', 'wp-rankology'),
            ];

echo '<div class="nav-tab-wrapper">';
foreach ($plugin_settings_tabs as $tab_key => $tab_caption) {
    echo '<a id="' . $tab_key . '-tab" class="nav-tab" href="?page=rankology-social#tab=' . $tab_key . '">' . $tab_caption . '</a>';
}
echo '</div>'; ?>
                <div class="rankology-tab <?php if ('tab_rankology_social_knowledge' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_social_knowledge"><?php do_settings_sections('rankology-settings-admin-social-knowledge'); ?></div>
                <div class="rankology-tab <?php if ('tab_rankology_social_accounts' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_social_accounts"><?php do_settings_sections('rankology-settings-admin-social-accounts'); ?></div>
                <div class="rankology-tab <?php if ('tab_rankology_social_facebook' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_social_facebook"><?php do_settings_sections('rankology-settings-admin-social-facebook'); ?></div>
                <div class="rankology-tab <?php if ('tab_rankology_social_twitter' == $current_tab) {
    echo 'active';
} ?>" id="tab_rankology_social_twitter"><?php do_settings_sections('rankology-settings-admin-social-twitter'); ?></div>
        </div>

        <?php rankology_rkseo_submit_button(esc_html__('Save changes', 'wp-rankology')); ?>
    </form>
<?php
