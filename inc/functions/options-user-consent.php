<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

if ('1' === rankology_get_service('GoogleAnalyticsOption')->getHalfDisable() || (((isset($_COOKIE['rankology-user-consent-accept']) && '1' == $_COOKIE['rankology-user-consent-accept']) && '1' === rankology_get_service('GoogleAnalyticsOption')->getDisable()) || ('1' !== rankology_get_service('GoogleAnalyticsOption')->getDisable()))) { //User consent cookie OK

    $addToCartOption = rankology_get_service('GoogleAnalyticsOption')->getAddToCart();
    $removeFromCartOption = rankology_get_service('GoogleAnalyticsOption')->getRemoveFromCart();

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
                    if ('1' === rankology_get_service('GoogleAnalyticsOption')->getEnableOption() && '' !== rankology_get_service('GoogleAnalyticsOption')->getGA4()) {
                        add_action('wp_head', 'rankology_google_analytics_js_arguments', 929, 1);
                        add_action('wp_head', 'rankology_custom_tracking_hook', 900, 1);
                    }
                    add_action('wp_head', 'rankology_custom_tracking_head_hook', 980, 1);
                    add_action('wp_body_open', 'rankology_custom_tracking_body_hook', 1020, 1);
                    add_action('wp_footer', 'rankology_custom_tracking_footer_hook', 1030, 1);

                    //ecommerce
                    $purchasesOptions = rankology_get_service('GoogleAnalyticsOption')->getPurchases();
                    if ('1' == $purchasesOptions || '1' == $addToCartOption || '1' == $removeFromCartOption) {
                        add_action('wp_enqueue_scripts', 'rankology_google_analytics_ecommerce_js', 20, 1);
                    }
                }
            } else {
                if ('1' === rankology_get_service('GoogleAnalyticsOption')->getEnableOption() && '' !== rankology_get_service('GoogleAnalyticsOption')->getGA4()) {
                    add_action('wp_head', 'rankology_google_analytics_js_arguments', 929, 1);
                    add_action('wp_head', 'rankology_custom_tracking_hook', 900, 1);
                }
                add_action('wp_head', 'rankology_custom_tracking_head_hook', 980, 1); //Oxygen: if prioriry >= 990, nothing will be outputed
                add_action('wp_body_open', 'rankology_custom_tracking_body_hook', 1020, 1);
                add_action('wp_footer', 'rankology_custom_tracking_footer_hook', 1030, 1);

                //ecommerce
                $purchasesOptions = rankology_get_service('GoogleAnalyticsOption')->getPurchases();
                if ('1' == $purchasesOptions || '1' == $addToCartOption || '1' == $removeFromCartOption) {
                    add_action('wp_enqueue_scripts', 'rankology_google_analytics_ecommerce_js', 20, 1);
                }
            }
        }
    } else {
        if ('1' === rankology_get_service('GoogleAnalyticsOption')->getEnableOption() && '' !== rankology_get_service('GoogleAnalyticsOption')->getGA4()) {
            add_action('wp_head', 'rankology_google_analytics_js_arguments', 929, 1);
            add_action('wp_head', 'rankology_custom_tracking_hook', 900, 1);
        }
        add_action('wp_head', 'rankology_custom_tracking_head_hook', 980, 1);
        add_action('wp_body_open', 'rankology_custom_tracking_body_hook', 1020, 1);
        add_action('wp_footer', 'rankology_custom_tracking_footer_hook', 1030, 1);

        //ecommerce
        $purchasesOptions = rankology_get_service('GoogleAnalyticsOption')->getPurchases();
        if ('1' == $purchasesOptions || '1' == $addToCartOption || '1' == $removeFromCartOption) {
            add_action('wp_enqueue_scripts', 'rankology_google_analytics_ecommerce_js', 20, 1);
        }
    }
}
