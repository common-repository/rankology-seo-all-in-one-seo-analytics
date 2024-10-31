<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

function rankology_google_analytics_enable_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_enable']); ?>

<label for="rankology_google_analytics_enable">
    <input id="rankology_google_analytics_enable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_enable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>

    <?php esc_html_e('Enable Google Analytics tracking - gtag.js', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_google_analytics_enable'])) {
        esc_attr($options['rankology_google_analytics_enable']);
    }
}

function rankology_google_analytics_ga4_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_ga4']) ? $options['rankology_google_analytics_ga4'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_ga4]" placeholder="' . esc_html__('Enter measurement ID (G-XXXXXXXXXX)', 'wp-rankology') . '" aria-label="' . esc_html__('Enter your measurement ID', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
); ?>

<p class="rankology-help description">
    <span class="dashicons dashicons-redo"></span>
    <a href="https://support.google.com/analytics/answer/9539598?hl=en" target="_blank">
        <?php esc_html_e('Find your measurement ID', 'wp-rankology'); ?>
    </a>
</p>
<?php
}

function rankology_google_analytics_hook_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_hook']) ? $options['rankology_google_analytics_hook'] : null; ?>

<select id="rankology_google_analytics_hook"
    name="rankology_google_analytics_option_name[rankology_google_analytics_hook]">
    <option <?php if ('wp_body_open' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="wp_body_open"><?php esc_html_e('Inside the body tag (recommended)', 'wp-rankology'); ?>
    </option>
    <option <?php if ('wp_footer' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="wp_footer"><?php esc_html_e('Footer', 'wp-rankology'); ?>
    </option>
</select>

<p class="description">
    <?php esc_html_e('Your theme must be compatible with <code>wp_body_open</code> hook introduced in WordPress 5.2 if "Inside the body tag" option selected.', 'wp-rankology'); ?>
</p>


<?php if (isset($options['rankology_google_analytics_hook'])) {
        esc_attr($options['rankology_google_analytics_hook']);
    }
}

function rankology_google_analytics_disable_callback() {

    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_disable']); ?>

<label for="rankology_google_analytics_disable">
    <input id="rankology_google_analytics_disable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_disable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Request user\'s consent for analytics tracking - GDPR', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_google_analytics_disable'])) {
        esc_attr($options['rankology_google_analytics_disable']);
    }
}

function rankology_google_analytics_half_disable_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_half_disable']); ?>

<label for="rankology_google_analytics_half_disable">
    <input id="rankology_google_analytics_half_disable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_half_disable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Display and automatically accept the user‘s consent on page load (not fully GDPR)', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('The previous option must be checked to use this.', 'wp-rankology'); ?>
</p>

<?php if (isset($options['rankology_google_analytics_half_disable'])) {
        esc_attr($options['rankology_google_analytics_half_disable']);
    }
}

function rankology_google_analytics_opt_out_edit_choice_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_opt_out_edit_choice']); ?>

<label for="rankology_google_analytics_opt_out_edit_choice">
    <input id="rankology_google_analytics_opt_out_edit_choice"
        name="rankology_google_analytics_option_name[rankology_google_analytics_opt_out_edit_choice]" type="checkbox"
        <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Allow user to change its choice about cookies', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_google_analytics_opt_out_edit_choice'])) {
        esc_attr($options['rankology_google_analytics_opt_out_edit_choice']);
    }
}

function rankology_google_analytics_opt_out_msg_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_opt_out_msg']) ? $options['rankology_google_analytics_opt_out_msg'] : null;

    printf(
'<textarea id="rankology_google_analytics_opt_out_msg" name="rankology_google_analytics_option_name[rankology_google_analytics_opt_out_msg]" rows="4" placeholder="' . esc_html__('Enter your message (HTML allowed)', 'wp-rankology') . '" aria-label="' . esc_html__('This message will only appear if request user\'s consent is enabled.', 'wp-rankology') . '">%s</textarea>',
esc_html($check)); ?>

<p class="description">
    <?php esc_html_e('HTML tags allowed: strong, em, br, a href / target', 'wp-rankology'); ?>
</p>
<p class="description">
    <?php esc_html_e('Shortcode allowed to get the privacy page set in WordPress settings: [rankology_privacy_page]', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_google_analytics_opt_out_msg_ok_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_opt_out_msg_ok']) ? $options['rankology_google_analytics_opt_out_msg_ok'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_opt_out_msg_ok]" placeholder="' . esc_html__('Accept', 'wp-rankology') . '" aria-label="' . esc_html__('Change the button value', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
);
}

function rankology_google_analytics_opt_out_msg_close_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_opt_out_msg_close']) ? $options['rankology_google_analytics_opt_out_msg_close'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_opt_out_msg_close]" placeholder="' . esc_html__('default: X', 'wp-rankology') . '" aria-label="' . esc_html__('Change the close button value', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
);
}

function rankology_google_analytics_opt_out_msg_edit_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_opt_out_msg_edit']) ? $options['rankology_google_analytics_opt_out_msg_edit'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_opt_out_msg_edit]" placeholder="' . esc_html__('default: Manage cookies', 'wp-rankology') . '" aria-label="' . esc_html__('Change the edit button value', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_exp_date_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_cb_exp_date']); ?>

<input type="number" min="1" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_exp_date]" <?php if ('1' == $check) { ?>
value="<?php echo esc_attr($options['rankology_google_analytics_cb_exp_date']); ?>"
<?php } ?>
value="30"/>

<?php if (isset($options['rankology_google_analytics_cb_exp_date'])) {
        esc_html($options['rankology_google_analytics_cb_exp_date']);
    } ?>

<p class="description">
    <?php esc_html_e('Default: 30 days before the cookie expiration.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_google_analytics_cb_pos_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cb_pos']) ? $options['rankology_google_analytics_cb_pos'] : null; ?>

<select id="rankology_google_analytics_cb_pos"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cb_pos]">
    <option <?php if ('bottom' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="bottom"><?php esc_html_e('Bottom (default)', 'wp-rankology'); ?>
    </option>
    <option <?php if ('center' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="center"><?php esc_html_e('Middle', 'wp-rankology'); ?>
    </option>
    <option <?php if ('top' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="top"><?php esc_html_e('Top', 'wp-rankology'); ?>
    </option>
</select>

<?php if (isset($options['rankology_google_analytics_cb_pos'])) {
        esc_attr($options['rankology_google_analytics_cb_pos']);
    }
}

function rankology_google_analytics_cb_txt_align_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cb_txt_align']) ? $options['rankology_google_analytics_cb_txt_align'] : 'center'; ?>

<select id="rankology_google_analytics_cb_txt_align"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cb_txt_align]">
    <option <?php if ('left' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="left"><?php esc_html_e('Left', 'wp-rankology'); ?>
    </option>
    <option <?php if ('center' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="center"><?php esc_html_e('Center (default)', 'wp-rankology'); ?>
    </option>
    <option <?php if ('right' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="right"><?php esc_html_e('Right', 'wp-rankology'); ?>
    </option>
</select>

<?php
    if (isset($options['rankology_google_analytics_cb_txt_align'])) {
        esc_attr($options['rankology_google_analytics_cb_txt_align']);
    }
}

function rankology_google_analytics_cb_width_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_width']) ? $options['rankology_google_analytics_cb_width'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_width]" aria-label="' . esc_html__('Change the cookie bar width', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
); ?>
<p class="description">
    <?php esc_html_e('Default unit is Pixels. Add % just after your custom value to use percentages (e.g. 80%).', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_google_analytics_cb_backdrop_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_cb_backdrop']); ?>

<hr>

<h2>
    <?php esc_html_e('Backdrop', 'wp-rankology'); ?>
</h2>

<p>
    <?php esc_html_e('Customize the cookie bar <strong>backdrop</strong>.', 'wp-rankology'); ?>
</p>

<label for="rankology_google_analytics_cb_backdrop">
    <input id="rankology_google_analytics_cb_backdrop"
        name="rankology_google_analytics_option_name[rankology_google_analytics_cb_backdrop]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Display a backdrop with the cookie bar', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_google_analytics_cb_backdrop'])) {
        esc_attr($options['rankology_google_analytics_cb_backdrop']);
    }
}

function rankology_google_analytics_cb_backdrop_bg_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_backdrop_bg']) ? $options['rankology_google_analytics_cb_backdrop_bg'] : null; ?>

<p class="description">
    <?php esc_html_e('Background color: ', 'wp-rankology'); ?>
</p>

<?php printf(
'<input type="text" data-default-color="rgba(255,255,255,0.8)" data-alpha="true" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_backdrop_bg]" aria-label="' . esc_html__('Change the background color of the backdrop', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_bg_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_bg']) ? $options['rankology_google_analytics_cb_bg'] : null; ?>
<hr>

<h2><?php esc_html_e('Main settings', 'wp-rankology'); ?>
</h2>

<p>
    <?php esc_html_e('Customize the general settings of the <strong>cookie bar</strong>.', 'wp-rankology'); ?>
</p>

<p class="description">
    <?php esc_html_e('Background color: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" data-alpha="true" data-default-color="#F1F1F1" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_bg]" aria-label="' . esc_html__('Change the color of the cookie bar background', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_txt_col_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_txt_col']) ? $options['rankology_google_analytics_cb_txt_col'] : null; ?>

<p class="description">
    <?php esc_html_e('Text color: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_txt_col]" aria-label="' . esc_html__('Change the color of the cookie bar text', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_lk_col_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_lk_col']) ? $options['rankology_google_analytics_cb_lk_col'] : null; ?>

<p class="description">
    <?php esc_html_e('Link color: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_lk_col]" aria-label="' . esc_html__('Change the color of the cookie bar link', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_bg_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_bg']) ? $options['rankology_google_analytics_cb_btn_bg'] : null; ?>

<hr>

<h2>
    <?php esc_html_e('Primary button', 'wp-rankology'); ?>
</h2>

<p>
    <?php esc_html_e('Customize the <strong>Accept button</strong>.', 'wp-rankology'); ?>
</p>

<p class="description">
    <?php esc_html_e('Background color: ', 'wp-rankology'); ?>
</p>

<?php printf(
'<input type="text" data-alpha="true" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_bg]" aria-label="' . esc_html__('Change the color of the cookie bar button background', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_bg_hov_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_bg_hov']) ? $options['rankology_google_analytics_cb_btn_bg_hov'] : null; ?>

<p class="description">
    <?php esc_html_e('Background color on hover: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" data-alpha="true" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_bg_hov]" aria-label="' . esc_html__('Change the color of the cookie bar button hover background', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_col_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_col']) ? $options['rankology_google_analytics_cb_btn_col'] : null; ?>

<p class="description">
    <?php esc_html_e('Text color: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_col]" aria-label="' . esc_html__('Change the color of the cookie bar button', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_col_hov_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_col_hov']) ? $options['rankology_google_analytics_cb_btn_col_hov'] : null; ?>

<p class="description">
    <?php esc_html_e('Text color on hover: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_col_hov]" aria-label="' . esc_html__('Change the color of the cookie bar button hover', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_sec_bg_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_sec_bg']) ? $options['rankology_google_analytics_cb_btn_sec_bg'] : null; ?>

<hr>

<h2>
    <?php esc_html_e('Secondary button', 'wp-rankology'); ?>
</h2>

<p>
    <?php esc_html_e('Customize the <strong>Close button</strong>.', 'wp-rankology'); ?>
</p>

<p class="description">
    <?php esc_html_e('Background color: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" data-alpha="true" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_sec_bg]" aria-label="' . esc_html__('Change the color of the cookie bar secondary button background', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_sec_col_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_sec_col']) ? $options['rankology_google_analytics_cb_btn_sec_col'] : null; ?>

<p class="description">
    <?php esc_html_e('Text color: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_sec_col]" aria-label="' . esc_html__('Change the color of the cookie bar secondary button hover background', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_sec_bg_hov_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_sec_bg_hov']) ? $options['rankology_google_analytics_cb_btn_sec_bg_hov'] : null; ?>

<p class="description">
    <?php esc_html_e('Background color on hover: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" data-alpha="true" data-default-color="#222222" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_sec_bg_hov]" aria-label="' . esc_html__('Change the color of the cookie bar secondary button', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_cb_btn_sec_col_hov_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cb_btn_sec_col_hov']) ? $options['rankology_google_analytics_cb_btn_sec_col_hov'] : null; ?>

<p class="description">
    <?php esc_html_e('Text color on hover: ', 'wp-rankology'); ?>
</p>

<?php
    printf(
'<input type="text" data-default-color="#FFFFFF" name="rankology_google_analytics_option_name[rankology_google_analytics_cb_btn_sec_col_hov]" aria-label="' . esc_html__('Change the color of the cookie bar secondary button hover', 'wp-rankology') . '" value="%s" class="color-picker"/>',
esc_html($check)
);
}

function rankology_google_analytics_roles_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    global $wp_roles;

    if ( ! isset($wp_roles)) {
        $wp_roles = new WP_Roles();
    }

    foreach ($wp_roles->get_names() as $key => $value) {
        $check = isset($options['rankology_google_analytics_roles'][$key]); ?>

<p>
    <label for="rankology_google_analytics_roles_<?php echo rankology_common_esc_str($key); ?>">
        <input
            id="rankology_google_analytics_roles_<?php echo rankology_common_esc_str($key); ?>"
            name="rankology_google_analytics_option_name[rankology_google_analytics_roles][<?php echo rankology_common_esc_str($key); ?>]"
            type="checkbox" <?php if ('1' == $check) { ?>
        checked="yes"
        <?php } ?>
        value="1"/>
        <strong><?php echo esc_html($value); ?></strong> (<em><?php echo esc_html(translate_user_role($value,  'default')); ?></em>)
    </label>
</p>

<?php
        if (isset($options['rankology_google_analytics_roles'][$key])) {
            esc_attr($options['rankology_google_analytics_roles'][$key]);
        }
    }
}

function rankology_google_analytics_optimize_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_optimize']) ? $options['rankology_google_analytics_optimize'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_optimize]" placeholder="' . esc_html__('Enter your Google Optimize container ID', 'wp-rankology') . '" value="%s" aria-label="' . esc_html__('GTM-XXXXXXX', 'wp-rankology') . '"/>',
esc_html($check)); ?>

<p class="description">
    <?php esc_html_e('Google Optimize offers A/B testing, website testing & personalization tools.', 'wp-rankology'); ?>

    <a class="rankology-help" href="https://marketingplatform.google.com/about/optimize/" target="_blank">
        <?php esc_html_e('Learn more', 'wp-rankology'); ?>
    </a>
    <span class="rankology-help dashicons dashicons-redo"></span>
</p>

<?php
}

function rankology_google_analytics_ads_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_ads']) ? $options['rankology_google_analytics_ads'] : null; ?>

<?php
    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_ads]" placeholder="' . esc_html__('Enter your Google Ads conversion ID (e.g. AW-123456789)', 'wp-rankology') . '" value="%s" aria-label="' . esc_html__('AW-XXXXXXXXX', 'wp-rankology') . '"/>',
esc_html($check)); ?>

<?php
}

function rankology_google_analytics_other_tracking_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_other_tracking']) ? esc_textarea($options['rankology_google_analytics_other_tracking']) : null;

    printf(
'<textarea id="rankology_google_analytics_other_tracking" name="rankology_google_analytics_option_name[rankology_google_analytics_other_tracking]" rows="16" placeholder="' . esc_html__('Paste your tracking code here like Google Tag Manager (head). Do NOT paste GA4 or Universal Analytics codes here. They are automatically added to your source code.', 'wp-rankology') . '" aria-label="' . esc_html__('Additional tracking code field', 'wp-rankology') . '">%s</textarea>',
$check); ?>
<p class="description">
    <?php esc_html_e('This code will be added in the head section of your page.', 'wp-rankology'); ?>
</p>
<?php
}

function rankology_google_analytics_other_tracking_body_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_other_tracking_body']) ? esc_textarea($options['rankology_google_analytics_other_tracking_body']) : null;

    printf(
'<textarea id="rankology_google_analytics_other_tracking_body" name="rankology_google_analytics_option_name[rankology_google_analytics_other_tracking_body]" rows="16" placeholder="' . esc_html__('Paste your tracking code here like Google Tag Manager (body)', 'wp-rankology') . '" aria-label="' . esc_html__('Additional tracking code field added to body', 'wp-rankology') . '">%s</textarea>',
$check); ?>
<p class="description"><?php esc_html_e('This code will be added just after the opening body tag of your page.', 'wp-rankology'); ?>
</p>

<p class="description"><?php esc_html_e('You don‘t see your code? Make sure to call <strong>wp_body_open();</strong> just after the opening body tag in your theme.', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_google_analytics_other_tracking_footer_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_other_tracking_footer']) ? esc_textarea($options['rankology_google_analytics_other_tracking_footer']) : null;

    printf(
'<textarea id="rankology_google_analytics_other_tracking_footer" name="rankology_google_analytics_option_name[rankology_google_analytics_other_tracking_footer]" rows="16" placeholder="' . esc_html__('Paste your tracking code here (footer)', 'wp-rankology') . '" aria-label="' . esc_html__('Additional tracking code field added to footer', 'wp-rankology') . '">%s</textarea>',
$check); ?>

<p class="description">
    <?php esc_html_e('This code will be added just after the closing body tag of your page.', 'wp-rankology'); ?>
</p>
<?php
}

function rankology_google_analytics_remarketing_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_remarketing']); ?>

<label for="rankology_google_analytics_remarketing">
    <input id="rankology_google_analytics_remarketing"
        name="rankology_google_analytics_option_name[rankology_google_analytics_remarketing]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable remarketing, demographics, and interests reporting', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('A remarketing audience consists of a collection of cookies or mobile-advertising IDs, serving as a representation of users whom you aim to re-engage due to their high potential for conversion.', 'wp-rankology'); ?>
    <a class="rankology-help" href="https://support.google.com/analytics/answer/2611268?hl=en" target="_blank">
        <?php esc_html_e('Learn more', 'wp-rankology'); ?>
    </a>
    <span class="rankology-help dashicons dashicons-redo"></span>
</p>

<?php if (isset($options['rankology_google_analytics_remarketing'])) {
        esc_attr($options['rankology_google_analytics_remarketing']);
    }
}

function rankology_google_analytics_ip_anonymization_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_ip_anonymization']); ?>

<label for="rankology_google_analytics_ip_anonymization">
    <input id="rankology_google_analytics_ip_anonymization"
        name="rankology_google_analytics_option_name[rankology_google_analytics_ip_anonymization]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable IP Anonymization', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('When an Analytics user requests IP address anonymization, Analytics promptly anonymizes the address at the earliest possible stage within the data collection network, following technical feasibility.', 'wp-rankology'); ?>
    <a class="rankology-help" href="https://developers.google.com/analytics/devguides/collection/gtagjs/ip-anonymization"
        target="_blank">
        <?php esc_html_e('Learn more', 'wp-rankology'); ?>
    </a>
    <span class="rankology-help dashicons dashicons-redo"></span>
</p>

<?php if (isset($options['rankology_google_analytics_ip_anonymization'])) {
        esc_attr($options['rankology_google_analytics_ip_anonymization']);
    }
}

function rankology_google_analytics_link_attribution_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_link_attribution']); ?>

<label for="rankology_google_analytics_link_attribution">
    <input id="rankology_google_analytics_link_attribution"
        name="rankology_google_analytics_option_name[rankology_google_analytics_link_attribution]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enhanced Link Attribution', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('Enhanced Link Attribution enhances the precision of your In-Page Analytics report by automatically distinguishing between multiple links leading to the same URL on a single page, achieved through the utilization of link element IDs.', 'wp-rankology'); ?>
    <a class="rankology-help"
        href="https://developers.google.com/analytics/devguides/collection/gtagjs/enhanced-link-attribution"
        target="_blank">
        <?php esc_html_e('Learn more', 'wp-rankology'); ?>
    </a>
    <span class="rankology-help dashicons dashicons-redo"></span>
</p>

<?php if (isset($options['rankology_google_analytics_link_attribution'])) {
        esc_attr($options['rankology_google_analytics_link_attribution']);
    }
}

function rankology_google_analytics_cross_enable_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_cross_enable']); ?>

<label for="rankology_google_analytics_cross_enable">
    <input id="rankology_google_analytics_cross_enable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_cross_enable]" type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable cross-domain tracking', 'wp-rankology'); ?>
</label>

<p class="description">
    <?php esc_html_e('Cross-domain tracking enables Analytics to consolidate sessions across two interconnected websites, like an e-commerce site and a distinct shopping cart site, treating them as a unified session.', 'wp-rankology'); ?>
    <a class="rankology-help" href="https://developers.google.com/analytics/devguides/collection/gtagjs/cross-domain"
        target="_blank">
        <?php esc_html_e('Learn more', 'wp-rankology'); ?>
    </a>
    <span class="rankology-help dashicons dashicons-redo"></span>
</p>

<?php if (isset($options['rankology_google_analytics_cross_enable'])) {
        esc_attr($options['rankology_google_analytics_cross_enable']);
    }
}

function rankology_google_analytics_cross_domain_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_cross_domain']) ? $options['rankology_google_analytics_cross_domain'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_cross_domain]" placeholder="' . esc_html__('Enter your domains: rankology.com,sub.rankology.com,sub2.rankology.com', 'wp-rankology') . '" value="%s" aria-label="' . esc_html__('Cross domains', 'wp-rankology') . '"/>',
esc_html($check)
);
}

function rankology_google_analytics_link_tracking_enable_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_link_tracking_enable']); ?>

<label for="rankology_google_analytics_link_tracking_enable">
    <input id="rankology_google_analytics_link_tracking_enable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_link_tracking_enable]" type="checkbox"
        <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable external links tracking', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_google_analytics_link_tracking_enable'])) {
        esc_attr($options['rankology_google_analytics_link_tracking_enable']);
    }
}

function rankology_google_analytics_download_tracking_enable_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_download_tracking_enable']); ?>

<label for="rankology_google_analytics_download_tracking_enable">
    <input id="rankology_google_analytics_download_tracking_enable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_download_tracking_enable]" type="checkbox"
        <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable download tracking', 'wp-rankology'); ?>
</label>

<?php if (isset($options['rankology_google_analytics_download_tracking_enable'])) {
        esc_attr($options['rankology_google_analytics_download_tracking_enable']);
    }
}

function rankology_google_analytics_download_tracking_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_download_tracking']) ? $options['rankology_google_analytics_download_tracking'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_download_tracking]" placeholder="' . esc_html__('docx|pdf|pptx|zip', 'wp-rankology') . '" aria-label="' . esc_html__('Track downloads\' clicks', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
); ?>
<p class="description">
    <?php esc_html_e('Separate each file type extensions with a pipe "|"', 'wp-rankology'); ?>
</p>

<?php
}

function rankology_google_analytics_affiliate_tracking_enable_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_affiliate_tracking_enable']); ?>

<label for="rankology_google_analytics_affiliate_tracking_enable">
    <input id="rankology_google_analytics_affiliate_tracking_enable"
        name="rankology_google_analytics_option_name[rankology_google_analytics_affiliate_tracking_enable]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable affiliate/outbound tracking', 'wp-rankology'); ?>
</label>

<?php
    if (isset($options['rankology_google_analytics_affiliate_tracking_enable'])) {
        esc_attr($options['rankology_google_analytics_affiliate_tracking_enable']);
    }
}

function rankology_google_analytics_affiliate_tracking_callback() {
    $options = get_option('rankology_google_analytics_option_name');
    $check   = isset($options['rankology_google_analytics_affiliate_tracking']) ? $options['rankology_google_analytics_affiliate_tracking'] : null;

    printf(
'<input type="text" name="rankology_google_analytics_option_name[rankology_google_analytics_affiliate_tracking]" placeholder="' . esc_html__('aff|go|out', 'wp-rankology') . '" aria-label="' . esc_html__('Track affiliate/outbound links', 'wp-rankology') . '" value="%s"/>',
esc_html($check)
); ?>
<p class="description">
    <?php esc_html_e('Separate each keyword with a pipe "|"', 'wp-rankology'); ?>
</p>
<?php
}

function rankology_google_analytics_phone_tracking_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $check = isset($options['rankology_google_analytics_phone_tracking']); ?>

<label for="rankology_google_analytics_phone_tracking">
    <input id="rankology_google_analytics_phone_tracking"
        name="rankology_google_analytics_option_name[rankology_google_analytics_phone_tracking]"
        type="checkbox" <?php if ('1' == $check) { ?>
    checked="yes"
    <?php } ?>
    value="1"/>
    <?php esc_html_e('Enable tracking of "tel:" links', 'wp-rankology'); ?>
</label>

<p class="description">
    <pre>&lt;a href="tel:+44123456789"&gt;</pre>
</p>

<?php
    if (isset($options['rankology_google_analytics_phone_tracking'])) {
        esc_attr($options['rankology_google_analytics_phone_tracking']);
    }
}

function rankology_google_analytics_cd_author_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cd_author']) ? $options['rankology_google_analytics_cd_author'] : null; ?>
<select id="rankology_google_analytics_cd_author"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cd_author]">
    <option <?php if ('none' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="none"><?php esc_html_e('None', 'wp-rankology'); ?>
    </option>

    <?php for ($i=1; $i <= 20; ++$i) { ?>
    <option <?php if ('dimension' . $i . '' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="dimension<?php echo rankology_common_esc_str($i); ?>"><?php printf(esc_html__('Custom Dimension #%d', 'wp-rankology'), $i); ?>
    </option>
    <?php } ?>
</select>

<?php if (isset($options['rankology_google_analytics_cd_author'])) {
        esc_attr($options['rankology_google_analytics_cd_author']);
    }
}

function rankology_google_analytics_cd_category_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cd_category']) ? $options['rankology_google_analytics_cd_category'] : null; ?>
<select id="rankology_google_analytics_cd_category"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cd_category]">
    <option <?php if ('none' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="none"><?php esc_html_e('None', 'wp-rankology'); ?>
    </option>

    <?php for ($i=1; $i <= 20; ++$i) { ?>
    <option <?php if ('dimension' . $i . '' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="dimension<?php echo rankology_common_esc_str($i); ?>"><?php printf(esc_html__('Custom Dimension #%d', 'wp-rankology'), $i); ?>
    </option>
    <?php } ?>
</select>

<?php if (isset($options['rankology_google_analytics_cd_category'])) {
        esc_attr($options['rankology_google_analytics_cd_category']);
    }
}

function rankology_google_analytics_cd_tag_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cd_tag']) ? $options['rankology_google_analytics_cd_tag'] : null; ?>

<select id="rankology_google_analytics_cd_tag"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cd_tag]">
    <option <?php if ('none' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="none"><?php esc_html_e('None', 'wp-rankology'); ?>
    </option>

    <?php for ($i=1; $i <= 20; ++$i) { ?>
    <option <?php if ('dimension' . $i . '' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="dimension<?php echo rankology_common_esc_str($i); ?>"><?php printf(esc_html__('Custom Dimension #%d', 'wp-rankology'), $i); ?>
    </option>
    <?php } ?>
</select>

<?php if (isset($options['rankology_google_analytics_cd_tag'])) {
        esc_attr($options['rankology_google_analytics_cd_tag']);
    }
}

function rankology_google_analytics_cd_post_type_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cd_post_type']) ? $options['rankology_google_analytics_cd_post_type'] : null; ?>

<select id="rankology_google_analytics_cd_post_type"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cd_post_type]">
    <option <?php if ('none' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="none"><?php esc_html_e('None', 'wp-rankology'); ?>
    </option>

    <?php for ($i=1; $i <= 20; ++$i) { ?>
    <option <?php if ('dimension' . $i . '' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="dimension<?php echo rankology_common_esc_str($i); ?>"><?php printf(esc_html__('Custom Dimension #%d', 'wp-rankology'), $i); ?>
    </option>
    <?php } ?>
</select>
<?php
if (isset($options['rankology_google_analytics_cd_post_type'])) {
        esc_attr($options['rankology_google_analytics_cd_post_type']);
    }
}

function rankology_google_analytics_cd_logged_in_user_callback() {
    $options = get_option('rankology_google_analytics_option_name');

    $selected = isset($options['rankology_google_analytics_cd_logged_in_user']) ?
    $options['rankology_google_analytics_cd_logged_in_user'] : null; ?>

<select id="rankology_google_analytics_cd_logged_in_user"
    name="rankology_google_analytics_option_name[rankology_google_analytics_cd_logged_in_user]">
    <option <?php if (' none' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="none"><?php esc_html_e('None', 'wp-rankology'); ?>
    </option>
    <?php for ($i=1; $i <= 20; ++$i) { ?>
    <option <?php if ('dimension' . $i . '' == $selected) { ?>
        selected="selected"
        <?php } ?>
        value="dimension<?php echo rankology_common_esc_str($i); ?>"><?php printf(esc_html__('Custom Dimension #%d', 'wp-rankology'), $i); ?>
    </option>
    <?php } ?>
</select>
<?php if (isset($options['rankology_google_analytics_cd_logged_in_user'])) {
        esc_attr($options['rankology_google_analytics_cd_logged_in_user']);
    }
}
