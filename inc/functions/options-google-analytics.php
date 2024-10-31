<?php
defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Google Analytics
//=================================================================================================

function rankology_cookies_user_consent_html()
{
    if (!empty(rankology_get_service('GoogleAnalyticsOption')->getOptOutMsg())) {
        $msg = rankology_get_service('GoogleAnalyticsOption')->getOptOutMsg();
    } elseif (get_option('wp_page_for_privacy_policy')) {
        $msg = esc_html__('By visiting our site, you agree to our privacy policy regarding cookies, tracking statistics, etc.&nbsp;<a href="[rankology_privacy_page]">Read more</a>', 'wp-rankology');
    } else {
        $msg = esc_html__('By visiting our site, you agree to our privacy policy regarding cookies, tracking statistics, etc.', 'wp-rankology');
    }

    if (get_option('wp_page_for_privacy_policy') && '' != $msg) {
        $rankology_privacy_page = esc_url(get_permalink(get_option('wp_page_for_privacy_policy')));
        $msg                   = str_replace('[rankology_privacy_page]', $rankology_privacy_page, $msg);
    }

    $msg = apply_filters('rankology_rgpd_message', $msg);


    $consent_btn = rankology_get_service('GoogleAnalyticsOption')->getOptOutMessageOk();
    if (empty($consent_btn) || !$consent_btn) {
        $consent_btn = esc_html__('Accept', 'wp-rankology');
    }

    $close_btn = rankology_get_service('GoogleAnalyticsOption')->getOptOutMessageClose();
    if (empty($close_btn) || !$close_btn) {
        $close_btn = esc_html__('X', 'wp-rankology');
    }

    $user_msg = '<div data-nosnippet class="rankology-user-consent rankology-user-message rankology-user-consent-hide">
        <p>' . $msg . '</p>
        <p>
            <button id="rankology-user-consent-accept" type="button">' . $consent_btn . '</button>
            <button type="button" id="rankology-user-consent-close">' . $close_btn . '</button>
        </p>
    </div>';

    $backdrop = '<div class="rankology-user-consent-backdrop rankology-user-consent-hide"></div>';

    $user_msg = apply_filters('rankology_rgpd_full_message', $user_msg, $msg, $consent_btn, $close_btn, $backdrop);

    echo rankology_common_esc_str($user_msg . $backdrop);
}

function rankology_cookies_edit_choice_html()
{
    $optOutEditChoice = rankology_get_service('GoogleAnalyticsOption')->getOptOutEditChoice();
    if ('1' !== $optOutEditChoice) {
        return;
    }

    $edit_cookie_btn = rankology_get_service('GoogleAnalyticsOption')->getOptOutMessageEdit();
    if (empty($edit_cookie_btn) || !$edit_cookie_btn) {
        $edit_cookie_btn = esc_html__('Manage cookies', 'wp-rankology');
    }

    $user_msg = '<div data-nosnippet class="rankology-user-consent rankology-edit-choice">
        <p>
            <button id="rankology-user-consent-edit" type="button">' . $edit_cookie_btn . '</button>
        </p>
    </div>';

    $user_msg = apply_filters('rankology_rgpd_full_message', $user_msg, $edit_cookie_btn);

    echo rankology_common_esc_str($user_msg);
}

function rankology_cookies_user_consent_styles() {
    // Register and enqueue a dummy style handle
    wp_register_style('rankology-inline-styles', false);
    wp_enqueue_style('rankology-inline-styles');

    // Prepare the inline styles
    $styles = '.rankology-user-consent {left: 50%;position: fixed;z-index: 8000;padding: 20px;display: inline-flex;justify-content: center;border: 1px solid #CCC;max-width:100%;';

    // Width
    $width = rankology_get_service('GoogleAnalyticsOption')->getCbWidth();
    if (!empty($width)) {
        $unit = (false !== strpos($width, '%')) ? '' : 'px';
        $styles .= 'width: ' . esc_attr($width) . $unit . ';';
    } else {
        $styles .= 'width:100%;';
    }

    // Position
    $position = rankology_get_service('GoogleAnalyticsOption')->getCbPos();
    if ('top' === $position) {
        $styles .= 'top:0;transform: translate(-50%, 0%);';
    } elseif ('center' === $position) {
        $styles .= 'top:45%;transform: translate(-50%, -50%);';
    } else {
        $styles .= 'bottom:0;transform: translate(-50%, 0);';
    }

    // Text alignment
    $txtAlign = rankology_get_service('GoogleAnalyticsOption')->getCbTxtAlign();
    if ('left' === $txtAlign) {
        $styles .= 'text-align:left;';
    } elseif ('right' === $txtAlign) { // fixed condition to check $txtAlign instead of $position
        $styles .= 'text-align:right;';
    } else {
        $styles .= 'text-align:center;';
    }

    // Background color
    $bgColor = rankology_get_service('GoogleAnalyticsOption')->getCbBg();
    $styles .= 'background:' . esc_attr(!empty($bgColor) ? $bgColor : '#F1F1F1') . ';}';

    // Media query for responsive design
    $styles .= '@media (max-width: 782px) {.rankology-user-consent {display: block;}}';

    // Additional styles
    $styles .= '.rankology-user-consent.rankology-user-message p:first-child {margin-right:20px}';
    $styles .= '.rankology-user-consent p {margin: 0;font-size: 0.8em;align-self: center;color:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbTxtCol()) . ';}';
    $styles .= '.rankology-user-consent button {vertical-align: middle;margin: 0;font-size: 14px;background:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnBg()) . ';color:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnCol()) . ';}';
    $styles .= '.rankology-user-consent button:hover{background:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnBgHov()) . ';color:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnColHov()) . ';}';
    $styles .= '#rankology-user-consent-close{margin: 0;position: relative;font-weight: bold;border: 1px solid #ccc;background:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnSecBg()) . ';color:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnSecCol()) . ';}';
    $styles .= '#rankology-user-consent-close:hover{cursor:pointer;background:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnSecBgHov()) . ';color:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbBtnSecColHov()) . ';}';
    $styles .= '.rankology-user-consent a{color:' . esc_attr(rankology_get_service('GoogleAnalyticsOption')->getCbLkCol()) . ';}';
    $styles .= '.rankology-user-consent-hide{display:none;}';

    // Backdrop
    if (rankology_get_service('GoogleAnalyticsOption')->getCbBackdrop()) {
        $bg_backdrop = rankology_get_service('GoogleAnalyticsOption')->getCbBackdropBg();
        $styles .= '.rankology-user-consent-backdrop{align-items: center;background: ' . esc_attr(!empty($bg_backdrop) ? $bg_backdrop : 'rgba(0,0,0,.65)') . ';bottom: 0;flex-direction: column;left: 0;overflow-y: auto;position: fixed;right: 0;top: 0;z-index: 100;}';
    }

    $styles .= '.rankology-edit-choice{background: none;justify-content: start;z-index: 7500;border: none;width: inherit;transform: none;left: inherit;bottom: 0;top: inherit;}';

    // Apply filter for full message styles
    $styles = apply_filters('rankology_rgpd_full_message_styles', $styles);

    // Add the inline styles
    wp_add_inline_style('rankology-inline-styles', $styles);
}
add_action('wp_enqueue_scripts', 'rankology_cookies_user_consent_styles');


function rankology_cookies_user_consent_render()
{
    $hook = rankology_get_service('GoogleAnalyticsOption')->getHook();
    if (empty($hook) || !$hook) {
        $hook = 'wp_head';
    }

    add_action($hook, 'rankology_cookies_user_consent_html');
    add_action($hook, 'rankology_cookies_edit_choice_html');
    add_action($hook, 'rankology_cookies_user_consent_styles');
}

if ('1' === rankology_get_service('GoogleAnalyticsOption')->getDisable()) {
    if (is_user_logged_in()) {
        global $wp_roles;

        //Get current user role
        if (isset(wp_get_current_user()->roles[0])) {
            $rankology_user_role = wp_get_current_user()->roles[0];
            //If current user role matchs values from Rankology GA settings then apply
            if (!empty(rankology_get_service('GoogleAnalyticsOption')->getRoles())) {
                if (array_key_exists($rankology_user_role, rankology_get_service('GoogleAnalyticsOption')->getRoles())) {
                    //do nothing
                } else {
                    rankology_cookies_user_consent_render();
                }
            } else {
                rankology_cookies_user_consent_render();
            }
        } else {
            rankology_cookies_user_consent_render();
        }
    } else {
        rankology_cookies_user_consent_render();
    }
}

//Build Custom GA
// Build Custom GA
function rankology_google_analytics_js($echo)
{
    if ('' !== rankology_get_service('GoogleAnalyticsOption')->getGA4() && '1' === rankology_get_service('GoogleAnalyticsOption')->getEnableOption()) {
        // Init
        $tracking_id = rankology_get_service('GoogleAnalyticsOption')->getGA4();
        $rankology_google_analytics_config = [];
        $rankology_google_analytics_event  = [];

        // Enqueue Google Analytics script
        wp_enqueue_script('rankology-google-analytics', 'https://www.googletagmanager.com/gtag/js?id=' . $tracking_id, array(), null, true);

        // Additional configurations
        $rankology_google_analytics_config_script = "window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{$tracking_id}');";

        // Cross domains
        $crossDomains = rankology_get_service('GoogleAnalyticsOption')->getCrossDomain();
        if ('1' == rankology_get_service('GoogleAnalyticsOption')->getCrossEnable() && $crossDomains) {
            $domains = array_map('trim', array_filter(explode(',', $crossDomains)));
            if (!empty($domains)) {
                $link_domains = implode("','", $domains);
                $rankology_google_analytics_config[] = "'linker': {'domains': ['{$link_domains}']}";
            }
        }

        // Remarketing
        $remarketingOption = rankology_get_service('GoogleAnalyticsOption')->getRemarketing();
        if ('1' != $remarketingOption) {
            $rankology_google_analytics_config[] = "'allow_display_features': false";
        }

        // Link attribution
        if ('1' == rankology_get_service('GoogleAnalyticsOption')->getLinkAttribution()) {
            $rankology_google_analytics_config[] = "'link_attribution': true";
        }

        // Dimensions
        if (!empty($rankology_google_analytics_config)) {
            $custom_map = implode(',', $rankology_google_analytics_config);
            $rankology_google_analytics_config_script .= "gtag('config', '{$tracking_id}', {custom_map: {{$custom_map}}});";
        } else {
            $rankology_google_analytics_config_script .= "gtag('config', '{$tracking_id}');";
        }

        // Event tracking scripts
        $events = '';
        if (!empty($rankology_google_analytics_event)) {
            foreach ($rankology_google_analytics_event as $event) {
                $events .= $event . "\n";
            }
        }

        // Affiliate tracking
        if (!empty(rankology_get_service('GoogleAnalyticsOption')->getAffiliateTrackingEnable())) {
            $affiliateTrackingOption = rankology_get_service('GoogleAnalyticsOption')->getAffiliateTracking();
            if (!empty($affiliateTrackingOption)) {
                $events .= "window.addEventListener('load', function () {
                    var outbound_links = document.querySelectorAll('a');
                    for (let k = 0; k < outbound_links.length; k++) {
                        outbound_links[k].addEventListener('click', function(e) {
                            var out = this.href.match(/(?:\/" . $affiliateTrackingOption . "\/)/gi);
                            if (out != null) {
                                gtag('event', 'click', {'event_category': 'outbound/affiliate','event_label' : this.href});
                            }
                        });
                    }
                });";
            }
        }

        // Phone tracking
        if (!empty(rankology_get_service('GoogleAnalyticsOption')->getPhoneTracking())) {
            $events .= "window.addEventListener('load', function () {
                var links = document.querySelectorAll('a');
                for (let i = 0; i < links.length; i++) {
                    links[i].addEventListener('click', function(e) {
                        var n = this.href.includes('tel:');
                        if (n === true) {
                            gtag('event', 'click', {'event_category': 'phone','event_label' : this.href.slice(4)});
                        }
                    });
                }
            });";
        }

        // Enqueue the inline script
        wp_add_inline_script('rankology-google-analytics', $rankology_google_analytics_config_script);
        wp_add_inline_script('rankology-google-analytics', $events);

        // Google Optimize
        $optimizeOption = rankology_get_service('GoogleAnalyticsOption')->getOptimize();
        if (!empty($optimizeOption)) {
            wp_add_inline_script('rankology-google-analytics', "gtag('config', 'optimize_id', '" . esc_js($optimizeOption) . "');");
        }

        // Anonymize IP
        if ('1' == rankology_get_service('GoogleAnalyticsOption')->getIpAnonymization()) {
            wp_add_inline_script('rankology-google-analytics', "gtag('config', '{$tracking_id}', {'anonymize_ip': true});");
        }
    }
}

// Hook into wp_enqueue_scripts to load the Google Analytics script
add_action('wp_enqueue_scripts', 'rankology_google_analytics_js');

add_action('rankology_google_analytics_html', 'rankology_google_analytics_js', 10, 1);

function rankology_google_analytics_js_arguments()
{
    $echo = true;
    do_action('rankology_google_analytics_html', $echo);
}

function rankology_custom_tracking_hook()
{
    $data['custom'] = '';
    $data['custom'] = apply_filters('rankology_custom_tracking', $data['custom']);
    echo rankology_common_esc_str($data['custom']);
}

//Build custom code after body tag opening
function rankology_google_analytics_body_code($echo)
{
    $rankology_html_body = rankology_get_service('GoogleAnalyticsOption')->getOtherTrackingBody();
    if (empty($rankology_html_body) || !$rankology_html_body) {
        return;
    }

    $rankology_html_body = apply_filters('rankology_custom_body_tracking', $rankology_html_body);
    if (true == $echo) {

        $rankology_html_body_ = '\n' . $rankology_html_body;
        echo wp_kses_post($rankology_html_body_);
    } else {
        $rankology_html_body_ = '\n' . $rankology_html_body;
        return wp_kses_post($rankology_html_body_);
    }
}
add_action('rankology_custom_body_tracking_html', 'rankology_google_analytics_body_code', 10, 1);

function rankology_custom_tracking_body_hook()
{
    $echo = true;
    do_action('rankology_custom_body_tracking_html', $echo);
}

//Build custom code before body tag closing
function rankology_google_analytics_footer_code($echo)
{
    $rankology_html_footer = rankology_get_service('GoogleAnalyticsOption')->getOtherTrackingFooter();
    if (empty($rankology_html_footer) || !$rankology_html_footer) {
        return;
    }

    $rankology_html_footer = apply_filters('rankology_custom_footer_tracking', $rankology_html_footer);
    if (true == $echo) {

        $rankology_html_footer_ = "\n" . $rankology_html_footer;
        echo wp_kses_post($rankology_html_footer_);
    } else {

        $rankology_html_footer_ = "\n" . $rankology_html_footer;
        return wp_kses_post($rankology_html_footer_);
    }
}
add_action('rankology_custom_footer_tracking_html', 'rankology_google_analytics_footer_code', 10, 1);

function rankology_custom_tracking_footer_hook()
{
    $echo = true;
    do_action('rankology_custom_footer_tracking_html', $echo);
}

//Build custom code in head
function rankology_google_analytics_head_code($echo)
{
    $rankology_html_head = rankology_get_service('GoogleAnalyticsOption')->getOtherTracking();
    if (empty($rankology_html_head) || !$rankology_html_head) {
        return;
    }

    $rankology_html_head = apply_filters('rankology_gtag_after_additional_tracking_html', $rankology_html_head);

    if (true == $echo) {

        $rankology_html_head_ = "\n" . $rankology_html_head;
        echo wp_kses_post($rankology_html_head_);

    } else {

        $rankology_html_head_ = "\n" . $rankology_html_head;
        return wp_kses_post($rankology_html_head_);

    }
}
add_action('rankology_custom_head_tracking_html', 'rankology_google_analytics_head_code', 10, 1);

function rankology_custom_tracking_head_hook()
{
    $echo = true;
    do_action('rankology_custom_head_tracking_html', $echo);
}
