<?php

namespace Rankology\Actions\Sitemap;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Core\Hooks\ExecuteHooks;

class Router implements ExecuteHooks {
    /**
     * 
     *
     * @return void
     */
    public function hooks() {
        add_action('init', [$this, 'init']);
        add_filter('query_vars', [$this, 'queryVars']);
    }

    /**
     * 
     * @see init
     *
     * @return void
     */
    public function init() {
        if ('1' !== rankology_get_service('SitemapOption')->isEnabled() || '1' !== rankology_get_toggle_option('xml-sitemap')) {
            return;
        }

        //XML Index
        add_rewrite_rule('^sitemaps.xml$', 'index.php?rankology_sitemap=1', 'top');

        //XSL Sitemap
        add_rewrite_rule('^sitemaps_xsl.xsl$', 'index.php?rankology_sitemap_xsl=1', 'top');

        //XSL Video Sitemap
        add_rewrite_rule('^sitemaps_video_xsl.xsl$', 'index.php?rankology_sitemap_video_xsl=1', 'top');

        add_rewrite_rule('([^/]+?)-sitemap([0-9]+)?\.xml$', 'index.php?rankology_cpt=$matches[1]&rankology_paged=$matches[2]', 'top');

        //XML Author
        if ('1' === rankology_get_service('SitemapOption')->authorIsEnable()) {
            add_rewrite_rule('author.xml?$', 'index.php?rankology_author=1', 'top');
        }
    }

    /**
     * 
     * @see query_vars
     *
     * @param array $vars
     *
     * @return array
     */
    public function queryVars($vars) {
        $vars[] = 'rankology_sitemap';
        $vars[] = 'rankology_sitemap_xsl';
        $vars[] = 'rankology_sitemap_video_xsl';
        $vars[] = 'rankology_cpt';
        $vars[] = 'rankology_paged';
        $vars[] = 'rankology_author';

        return $vars;
    }
}
