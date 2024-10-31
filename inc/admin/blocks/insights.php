<?php
    // To prevent calling the plugin directly
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    if (! function_exists('add_action')) {
        echo 'Please don&rsquo;t call the plugin directly. Thanks :)';
        exit;
    }

    do_action('rankology_dashboard_insights', $current_tab);
