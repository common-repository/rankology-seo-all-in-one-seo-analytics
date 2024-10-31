<?php

namespace Rankology\Actions\Sitemap;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Core\Hooks\ExecuteHooks;

class DefaultWPSitemap implements ExecuteHooks {
    /**
     * 
     *
     * @return void
     */
    public function hooks() {
        /*
         * Remove default WP XML sitemaps
         */
        if ('1' == rankology_get_toggle_option('xml-sitemap')) {
            remove_action('init', 'wp_sitemaps_get_server');
        }
    }
}
