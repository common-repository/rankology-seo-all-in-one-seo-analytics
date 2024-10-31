<?php

namespace Rankology\Services\Settings\Roles;

if ( ! defined('ABSPATH')) {
    exit;
}

class SectionPagesRankology {
    /**
     * 
     *
     * @param string $keySettings
     *
     * @return void
     */
    public function render($keySettings) {
        $options = rankology_get_service('AdvancedOption')->getOption();

        global $wp_roles;

        if ( ! isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        foreach ($wp_roles->get_names() as $key => $value) {
            if ('administrator' === $key) {
                continue;
            }
            $uniqueKey   = sprintf('%s_%s', $keySettings, $key);
            $nameKey     = \sprintf('%s_%s', 'rankology_advanced_security_metaboxe', $keySettings);
            $dataOptions = isset($options[$nameKey]) ? $options[$nameKey] : [];

            if ('titles-metas_editor' === $uniqueKey) { ?>
    <p class="description">
        <?php esc_html_e('Check a user role to authorized it to edit a specific SEO page.', 'wp-rankology'); ?>
    </p>
    <?php } ?>

    <p>
        <label
            for="rankology_advanced_security_metaboxe_role_pages_<?php echo rankology_common_esc_str($uniqueKey); ?>">
            <input type="checkbox"
                id="rankology_advanced_security_metaboxe_role_pages_<?php echo rankology_common_esc_str($uniqueKey); ?>"
                value="1"
                name="rankology_advanced_option_name[<?php echo rankology_common_esc_str($nameKey); ?>][<?php echo rankology_common_esc_str($key); ?>]"
                <?php if (isset($dataOptions[$key])) {
                checked($dataOptions[$key], '1');
            } ?>
            />
            <strong><?php echo esc_html($value); ?></strong> (<em><?php echo esc_html(translate_user_role($value,  'default')); ?></em>)
        </label>
    </p>
    <?php
        }
    }

    /**
     * 
     *
     * @param string $name
     * @param array  $params
     *
     * @return void
     */
    public function __call($name, $params) {
        $functionWithKey = explode('_', $name);
        if ( ! isset($functionWithKey[1])) {
            return;
        }

        $this->render($functionWithKey[1]);
    }

    /**
     * 
     *
     * @return void
     */
    public function printSectionPages() {
        global $submenu;
        if ( ! isset($submenu['rankology-option'])) {
            return;
        }
        $menus = $submenu['rankology-option'];

        foreach ($menus as $key => $item) {
            $keyClean = $item[2];
            if (in_array($item[2], [
                'rankology-option', // dashboard
                'rankology-license',
                'edit.php?post_type=rankology_schemas',
                'edit.php?post_type=rankology_404',
                'edit.php?post_type=rankology_bot', ])) {
                continue;
            }

            add_settings_field(
                'rankology_advanced_security_metaboxe_' . $keyClean,
                $item[0],
                [$this, sprintf('render_%s', $keyClean)],
                'rankology-settings-admin-advanced-security',
                'rankology_setting_section_advanced_security_roles'
            );
        }

        do_action('rankology_add_settings_field_advanced_security');
    }
}
