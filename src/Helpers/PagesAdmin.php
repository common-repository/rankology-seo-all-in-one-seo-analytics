<?php

namespace Rankology\Helpers;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

abstract class PagesAdmin {
    const DASHBOARD        = 'dashboard';

    const XML_HTML_SITEMAP = 'xml_html_sitemap';

    const SOCIAL_NETWORKS  = 'social_networks';

    const TITLE_METAS      = 'titles_metas';

    const ANALYTICS        = 'analytics';

    const ADVANCED         = 'advanced';

    const TOOLS            = 'tools';

    const INSTANT_INDEXING = 'instant_indexing';

    const PRO              = 'pro';

    const SCHEMAS          = 'schemas';

    const BOT              = 'bot';

    const LICENSE          = 'license';

    public static function getPages() {
        return apply_filters('rankology_pages_admin', [
            self::DASHBOARD,
            self::TITLE_METAS,
            self::XML_HTML_SITEMAP,
            self::SOCIAL_NETWORKS,
            self::ANALYTICS,
            self::ADVANCED,
            self::TOOLS,
            self::INSTANT_INDEXING,
            self::PRO,
            self::SCHEMAS,
            self::BOT,
            self::LICENSE,
        ]);
    }

    /**
     * 
     *
     * @param string $page
     *
     * @return string
     */
    public static function getCapabilityByPage($page) {
        switch ($page) {
            case 'rankology-titles':
                return self::TITLE_METAS;
            case 'rankology-xml-sitemap':
                return self::XML_HTML_SITEMAP;
            case 'rankology-social':
                return self::SOCIAL_NETWORKS;
            case 'rankology-google-analytics':
                return self::ANALYTICS;
            case 'rankology-import-export':
                return self::TOOLS;
            case 'rankology-instant-indexing':
                return self::INSTANT_INDEXING;
            case 'rankology-fno-page':
                return self::PRO;
            case 'rankology-advanced':
                return self::ADVANCED;
            case 'rankology-bot-batch':
                return self::BOT;
            default:
                return apply_filters('rankology_get_capability_by_page', null);
        }
    }

    /**
     * 
     *
     * @param string $capability
     *
     * @return string
     */
    public static function getPageByCapability($capability) {
        switch ($capability) {
            case self::TITLE_METAS:
                return 'rankology-titles';
            case self::XML_HTML_SITEMAP:
                return 'rankology-xml-sitemap';
            case self::SOCIAL_NETWORKS:
                return 'rankology-social';
            case self::ANALYTICS:
                return 'rankology-google-analytics';
            case self::TOOLS:
                return 'rankology-import-export';
            case self::INSTANT_INDEXING:
                return 'rankology-instant-indexing';
            case self::PRO:
                return 'rankology-fno-page';
            case self::ADVANCED:
                return 'rankology-advanced';
            case self::BOT:
                return 'rankology-bot-batch';
            default:
                return apply_filters('rankology_get_page_by_capability', null);
        }
    }

    /**
     * 
     *
     * @param string $capability
     *
     * @return string
     */
    public static function getCustomCapability($capability) {
        return sprintf('rankology_manage_%s', $capability);
    }
}
