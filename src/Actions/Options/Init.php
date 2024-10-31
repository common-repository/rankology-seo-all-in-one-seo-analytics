<?php

namespace Rankology\Actions\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Core\Hooks\ActivationHook;
use Rankology\Helpers\TagCompose;
use Rankology\Tags\PostTitle;
use Rankology\Tags\SiteTagline;
use Rankology\Tags\SiteTitle;

class Init implements ActivationHook
{
    /**
     * 
     *
     * @return void
     */
    public function activate() {
        //Enable features==========================================================================
        $this->setToggleOptions();

        //Titles & metas===========================================================================
        $this->setTitleOptions();

        //XML Sitemap==============================================================================
        $this->setSitemapOptions();

        //Social===================================================================================
        $this->setSocialOptions();

        //Advanced=================================================================================
        $this->setAdvancedOptions();
    }

    /**
     * 
     *
     * @return void
     */
    protected function setAdvancedOptions() {
        $advancedOptions = get_option('rankology_advanced_option_name');

        //Init if option doesn't exist
        if (false === $advancedOptions) {
            $advancedOptions = [];
        }

        $advancedOptions = [
            'rankology_advanced_advanced_attachments'       => '1',
            'rankology_advanced_advanced_tax_desc_editor'   => '1',
            'rankology_advanced_appearance_title_col'       => '1',
            'rankology_advanced_appearance_meta_desc_col'   => '1',
            'rankology_advanced_appearance_score_col'       => '1',
            'rankology_advanced_appearance_noindex_col'     => '1',
            'rankology_advanced_appearance_nofollow_col'    => '1',
            'rankology_advanced_appearance_universal_metabox_disable'    => '1',
        ];

        //Check if the value is an array (important!)
        if (is_array($advancedOptions)) {
            add_option('rankology_advanced_option_name', $advancedOptions);
        }
    }

    /**
     * 
     *
     * @return void
     */
    protected function setSocialOptions() {
        $socialOptions = get_option('rankology_social_option_name');

        //Init if option doesn't exist
        if (false === $socialOptions) {
            $socialOptions = [];
        }

        $socialOptions = [
            'rankology_social_facebook_og'  => '1',
            'rankology_social_twitter_card' => '1',
        ];

        //Check if the value is an array (important!)
        if (is_array($socialOptions)) {
            add_option('rankology_social_option_name', $socialOptions);
        }
    }

    /**
     * 
     *
     * @return void
     */
    protected function setSitemapOptions() {
        $sitemapOptions = get_option('rankology_xml_sitemap_option_name');

        //Init if option doesn't exist
        if (false === $sitemapOptions) {
            $sitemapOptions = [];
        }

        $sitemapOptions = [
            'rankology_xml_sitemap_general_enable' => '1',
            'rankology_xml_sitemap_img_enable'     => '1',
        ];

        global $wp_post_types;

        $args = [
            'show_ui' => true,
        ];

        $post_types = get_post_types($args, 'objects', 'and');

        foreach ($post_types as $rankology_cpt_key => $rankology_cpt_value) {
            if ('post' == $rankology_cpt_key || 'page' == $rankology_cpt_key || 'product' == $rankology_cpt_key) {
                $sitemapOptions['rankology_xml_sitemap_post_types_list'][$rankology_cpt_key]['include'] = '1';
            }
        }

        $args = [
            'show_ui' => true,
            'public'  => true,
        ];

        $taxonomies = get_taxonomies($args, 'objects', 'and');

        foreach ($taxonomies as $rankology_tax_key => $rankology_tax_value) {
            if ('category' == $rankology_tax_key || 'post_tag' == $rankology_tax_key) {
                $sitemapOptions['rankology_xml_sitemap_taxonomies_list'][$rankology_tax_key]['include'] = '1';
            }
        }

        //Check if the value is an array (important!)
        if (is_array($sitemapOptions)) {
            add_option('rankology_xml_sitemap_option_name', $sitemapOptions);
        }
    }

    /**
     * 
     *
     * @return void
     */
    protected function setToggleOptions() {
        $toggleOptions = get_option('rankology_toggle');

        //Init if option doesn't exist
        if (false === $toggleOptions) {
            $toggleOptions = [];
        }

        $toggleOptions = [
            'toggle-titles'           => '1',
            'toggle-xml-sitemap'      => '1',
            'toggle-social'           => '1',
            'toggle-google-analytics' => '1',
            'toggle-instant-indexing' => '1',
            'toggle-advanced'         => '1',
            'toggle-dublin-core'      => '1',
            'toggle-local-business'   => '1',
            'toggle-rich-snippets'    => '1',
            'toggle-breadcrumbs'      => '1',
            'toggle-robots'           => '1',
            'toggle-404'              => '1',
            'toggle-bot'              => '1',
            'toggle-inspect-url'      => '1',
            'toggle-ai'               => '1',
        ];

        if (is_plugin_active('woocommerce/woocommerce.php')) {
            $toggleOptions['toggle-woocommerce'] = '1';
        }

        //Check if the value is an array (important!)
        if (is_array($toggleOptions)) {
            add_option('rankology_toggle', $toggleOptions);
        }
    }

    /**
     * 
     *
     * @return void
     */
    protected function setTitleOptions() {
        $titleOptions = get_option('rankology_titles_option_name');

        //Init if option doesn't exist
        if (false === $titleOptions) {
            $titleOptions = [];
        }

        //Site Title
        $titleOptions = [
            'rankology_titles_home_site_title' => TagCompose::getValueWithTag(SiteTitle::NAME),
            'rankology_titles_home_site_desc'  => TagCompose::getValueWithTag(SiteTagline::NAME),
            'rankology_titles_sep'             => '-',
        ];

        //Post Types
        $postTypes = rankology_get_service('WordPressData')->getPostTypes();
        if ( ! empty($postTypes)) {
            foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
                $titleOptions['rankology_titles_single_titles'][$rankology_cpt_key] = [
                    'title' => sprintf(
                        '%s %s %s',
                        TagCompose::getValueWithTag(PostTitle::NAME),
                        '%%sep%%',
                        TagCompose::getValueWithTag(SiteTitle::NAME)
                    ),
                    'description' => TagCompose::getValueWithTag('post_excerpt'),
                ];
            }
        }

        //Taxonomies
        $taxonomies = rankology_get_service('WordPressData')->getTaxonomies();
        if (empty($taxonomies)) {
            foreach ($taxonomies as $rankology_tax_key => $rankology_tax_value) {
                //Title
                if ('category' == $rankology_tax_key) {
                    $titleOptions['rankology_titles_tax_titles'][$rankology_tax_key]['title'] = '%%_category_title%% %%current_pagination%% %%sep%% %%sitetitle%%';
                } elseif ('post_tag' == $rankology_tax_key) {
                    $titleOptions['rankology_titles_tax_titles'][$rankology_tax_key]['title'] = '%%tag_title%% %%current_pagination%% %%sep%% %%sitetitle%%';
                } else {
                    $titleOptions['rankology_titles_tax_titles'][$rankology_tax_key]['title'] = '%%term_title%% %%current_pagination%% %%sep%% %%sitetitle%%';
                }

                //Desc
                if ('category' == $rankology_tax_key) {
                    $titleOptions['rankology_titles_tax_titles'][$rankology_tax_key]['description'] = '%%_category_description%%';
                } elseif ('post_tag' == $rankology_tax_key) {
                    $titleOptions['rankology_titles_tax_titles'][$rankology_tax_key]['description'] = '%%tag_description%%';
                } else {
                    $titleOptions['rankology_titles_tax_titles'][$rankology_tax_key]['description'] = '%%term_description%%';
                }
            }
        }

        //Archives
        $postTypes = rankology_get_service('WordPressData')->getPostTypes();
        if (! empty($postTypes)) {
            foreach ($postTypes as $rankology_cpt_key => $rankology_cpt_value) {
                $titleOptions['rankology_titles_archive_titles'][$rankology_cpt_key]['title'] = '%%cpt_plural%% %%current_pagination%% %%sep%% %%sitetitle%%';
            }
        }

        //Author
        $titleOptions['rankology_titles_archives_author_title']   = '%%post_author%% %%sep%% %%sitetitle%%';
        $titleOptions['rankology_titles_archives_author_noindex'] = '1';

        //Date
        $titleOptions['rankology_titles_archives_date_title']   = '%%archive_date%% %%sep%% %%sitetitle%%';
        $titleOptions['rankology_titles_archives_date_noindex'] = '1';

        //BuddyPress Groups
        if (is_plugin_active('buddypress/bp-loader.php') || is_plugin_active('buddyboss-platform/bp-loader.php')) {
            $titleOptions['rankology_titles_bp_groups_title'] = '%%post_title%% %%sep%% %%sitetitle%%';
        }

        //Search
        $titleOptions['rankology_titles_archives_search_title'] = '%%search_keywords%% %%sep%% %%sitetitle%%';

        //404
        $titleOptions['rankology_titles_archives_404_title'] = esc_html__('404 - Page not found', 'wp-rankology') . ' %%sep%% %%sitetitle%%';

        //Link rel prev/next
        $titleOptions['rankology_titles_paged_rel'] = '1';

        //Check if the value is an array (important!)
        if (is_array($titleOptions)) {
            add_option('rankology_titles_option_name', $titleOptions);
        }
    }
}
