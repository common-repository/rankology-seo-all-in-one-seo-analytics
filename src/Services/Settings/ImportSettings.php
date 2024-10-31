<?php

namespace Rankology\Services\Settings;


class ImportSettings {
    public function handle($data = []){
        if (isset($data['rankology_activated']) &&  false !== $data['rankology_activated']) {
            update_option('rankology_activated', $data['rankology_activated'], false);
        }

        if (isset($data['rankology_titles_option_name']) &&  false !== $data['rankology_titles_option_name']) {
            update_option('rankology_titles_option_name', $data['rankology_titles_option_name'], false);
        }

        if (isset($data['rankology_social_option_name']) &&  false !== $data['rankology_social_option_name']) {
            update_option('rankology_social_option_name', $data['rankology_social_option_name'], false);
        }

        if (isset($data['rankology_google_analytics_option_name']) &&  false !== $data['rankology_google_analytics_option_name']) {
            update_option('rankology_google_analytics_option_name', $data['rankology_google_analytics_option_name'], false);
        }

        if (isset($data['rankology_advanced_option_name']) &&  false !== $data['rankology_advanced_option_name']) {
            update_option('rankology_advanced_option_name', $data['rankology_advanced_option_name'], false);
        }

        if (isset($data['rankology_xml_sitemap_option_name']) &&  false !== $data['rankology_xml_sitemap_option_name']) {
            update_option('rankology_xml_sitemap_option_name', $data['rankology_xml_sitemap_option_name'], false);
        }

        if (isset($data['rankology_fno_option_name']) &&  false !== $data['rankology_fno_option_name']) {
            update_option('rankology_fno_option_name', $data['rankology_fno_option_name'], false);
        }

        if (isset($data['rankology_fno_mu_option_name']) &&  false !== $data['rankology_fno_mu_option_name']) {
            update_option('rankology_fno_mu_option_name', $data['rankology_fno_mu_option_name'], false);
        }

        if (isset($data['rankology_bot_option_name']) &&  false !== $data['rankology_bot_option_name']) {
            update_option('rankology_bot_option_name', $data['rankology_bot_option_name'], false);
        }

        if (isset($data['rankology_toggle']) &&  false !== $data['rankology_toggle']) {
            update_option('rankology_toggle', $data['rankology_toggle'], false);
        }

        if (isset($data['rankology_google_analytics_lock_option_name']) &&  false !== $data['rankology_google_analytics_lock_option_name']) {
            update_option('rankology_google_analytics_lock_option_name', $data['rankology_google_analytics_lock_option_name'], false);
        }

        if (isset($data['rankology_tools_option_name']) &&  false !== $data['rankology_tools_option_name']) {
            update_option('rankology_tools_option_name', $data['rankology_tools_option_name'], false);
        }

        if (isset($data['rankology_instant_indexing_option_name']) &&  false !== $data['rankology_instant_indexing_option_name']) {
            update_option('rankology_instant_indexing_option_name', $data['rankology_instant_indexing_option_name'], false);
        }
    }

}
