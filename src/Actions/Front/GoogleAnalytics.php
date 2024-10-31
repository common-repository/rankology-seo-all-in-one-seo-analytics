<?php

namespace Rankology\Actions\Front;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Core\Hooks\ExecuteHooksFrontend;
use Rankology\ManualHooks\Thirds\WooCommerce\WooCommerceAnalytics;

class GoogleAnalytics implements ExecuteHooksFrontend {
    /**
     * 
     *
     * @return void
     */
    public function hooks() {
        add_action('rankology_google_analytics_html', [$this, 'analytics'], 10, 1);
    }

    public function analytics($echo) {
        if ('' !== rankology_get_service('GoogleAnalyticsOption')->getGA4() && '1' === rankology_get_service('GoogleAnalyticsOption')->getEnableOption()) {
            if (rankology_get_service('WooCommerceActivate')->isActive()) {
                $woocommerceAnalyticsHook = new WooCommerceAnalytics();
                $woocommerceAnalyticsHook->hooks();
            }
        }
    }
}
