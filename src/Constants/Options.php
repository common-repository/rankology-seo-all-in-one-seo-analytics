<?php

namespace Rankology\Constants;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class Options {
    /**
     * 
     *
     * @var string
     */
    const KEY_TOGGLE_OPTION = 'rankology_toggle';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_NOTICE = 'rankology_notices';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_DASHBOARD = 'rankology_dashboard_option_name';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_TITLE = 'rankology_titles_option_name';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_SITEMAP = 'rankology_xml_sitemap_option_name';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_SOCIAL = 'rankology_social_option_name';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_GOOGLE_ANALYTICS = 'rankology_google_analytics_option_name';

    /**
     * 
     *
     * @var string
     */
    const KEY_OPTION_ADVANCED = 'rankology_advanced_option_name';
}
