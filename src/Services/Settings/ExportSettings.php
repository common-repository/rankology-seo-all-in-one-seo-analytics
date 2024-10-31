<?php

namespace Rankology\Services\Settings;


class ExportSettings {
    public function handle(){
        $data = [];
        $data['rankology_activated']                             = get_option('rankology_activated');
        $data['rankology_titles_option_name']                    = get_option('rankology_titles_option_name');
        $data['rankology_social_option_name']                    = get_option('rankology_social_option_name');
        $data['rankology_google_analytics_option_name']          = get_option('rankology_google_analytics_option_name');
        $data['rankology_advanced_option_name']                  = get_option('rankology_advanced_option_name');
        $data['rankology_xml_sitemap_option_name']               = get_option('rankology_xml_sitemap_option_name');
        $data['rankology_fno_option_name']                       = get_option('rankology_fno_option_name');
        $data['rankology_fno_mu_option_name']                    = get_option('rankology_fno_mu_option_name');
        $data['rankology_bot_option_name']                       = get_option('rankology_bot_option_name');
        $data['rankology_toggle']                                = get_option('rankology_toggle');
        $data['rankology_google_analytics_lock_option_name']     = get_option('rankology_google_analytics_lock_option_name');
        $data['rankology_tools_option_name']                     = get_option('rankology_tools_option_name');
        $data['rankology_dashboard_option_name']                 = get_option('rankology_dashboard_option_name');
        $data['rankology_instant_indexing_option_name']          = get_option('rankology_instant_indexing_option_name');

         return $data;
    }
}
