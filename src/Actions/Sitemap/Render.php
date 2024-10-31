<?php

namespace Rankology\Actions\Sitemap;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Core\Hooks\ExecuteHooksFrontend;

class Render implements ExecuteHooksFrontend {
    /**
     * 
     *
     * @return void
     */
    public function hooks() {
        add_action('pre_get_posts', [$this, 'render'], 1);
        add_action('template_redirect', [$this, 'sitemapShortcut'], 1);
    }

    /**
     * 
     * @see @pre_get_posts
     *
     * @param Query $query
     *
     * @return void
     */
    public function render($query) {
        if ( ! $query->is_main_query()) {
            return;
        }

        if ('1' !== rankology_get_service('SitemapOption')->isEnabled() || '1' !== rankology_get_toggle_option('xml-sitemap')) {
            return;
        }

        $filename = null;
        if ('1' === get_query_var('rankology_sitemap')) {
            $filename = 'template-xml-sitemaps.php';
        } elseif ('1' === get_query_var('rankology_sitemap_xsl')) {
            $filename = 'template-xml-sitemaps-xsl.php';
        } elseif ('1' === get_query_var('rankology_sitemap_video_xsl')) {
            $filename = 'template-xml-sitemaps-video-xsl.php';
        } elseif ('1' === get_query_var('rankology_author')) {
            $filename = 'template-xml-sitemaps-author.php';
        } elseif ('' !== get_query_var('rankology_cpt')) {
            if (!empty(rankology_get_service('SitemapOption')->getPostTypesList())
                && array_key_exists(get_query_var('rankology_cpt'), rankology_get_service('SitemapOption')->getPostTypesList())) {
                /*
                 * 
                 */
                rankology_get_service('SitemapRenderSingle')->render();
                exit();
            } elseif (!empty(rankology_get_service('SitemapOption')->getTaxonomiesList())
                && array_key_exists(get_query_var('rankology_cpt'), rankology_get_service('SitemapOption')->getTaxonomiesList())) {
                $filename = 'template-xml-sitemaps-single-term.php';
            }
            else{
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                return;
            }
        }


        if ($filename === 'template-xml-sitemaps-video-xsl.php') {
            include RANKOLOGY_FNO_PLUGIN_DIR_PATH . 'inc/functions/video-sitemap/' . $filename;
            exit();
        } elseif (null !== $filename && file_exists(RANKOLOGY_PLUGIN_DIR_PATH . 'inc/functions/sitemap/' . $filename)) {
            include RANKOLOGY_PLUGIN_DIR_PATH . 'inc/functions/sitemap/' . $filename;
            exit();
        }

    }

    /**
     * 
     * @see @template_redirect
     *
     * @return void
     */
    public function sitemapShortcut() {
        if ('1' !== rankology_get_toggle_option('xml-sitemap')) {
            return;
        }
        //Redirect sitemap.xml to sitemaps.xml
        $get_current_url = get_home_url() . rankology_common_esc_url($_SERVER['REQUEST_URI']);
        if (in_array($get_current_url, [
                get_home_url() . '/sitemap.xml/',
                get_home_url() . '/sitemap.xml',
                get_home_url() . '/wp-sitemap.xml/',
                get_home_url() . '/wp-sitemap.xml',
                get_home_url() . '/sitemap_index.xml/',
                get_home_url() . '/sitemap_index.xml',
            ])) {
            wp_safe_redirect(get_home_url() . '/sitemaps.xml', 301);
            exit();
        }
    }
}
