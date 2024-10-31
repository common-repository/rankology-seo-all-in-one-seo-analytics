<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class SitemapOption {
    const NAME_SERVICE = 'SitemapOption';

    /**
     * 
     *
     * @return array
     */
    public function getOption() {
        return get_option(Options::KEY_OPTION_SITEMAP);
    }

    /**
     * 
     *
     * @return string|nul
     *
     * @param string $key
     */
    protected function searchOptionByKey($key) {
        $data = $this->getOption();

        if (empty($data)) {
            return null;
        }

        if ( ! isset($data[$key])) {
            return null;
        }

        return $data[$key];
    }

    /**
     * 
     *
     * @return string|null
     */
    public function isEnabled() {
        return $this->searchOptionByKey('rankology_xml_sitemap_general_enable');
    }

    /**
     * 
     * @
     * @return string|null
     */
    public function videoIsEnabled() {
        return $this->searchOptionByKey('rankology_xml_sitemap_video_enable');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getPostTypesList() {
        return $this->searchOptionByKey('rankology_xml_sitemap_post_types_list');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getTaxonomiesList() {
        return $this->searchOptionByKey('rankology_xml_sitemap_taxonomies_list');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function authorIsEnable() {
        return $this->searchOptionByKey('rankology_xml_sitemap_author_enable');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function imageIsEnable() {
        return $this->searchOptionByKey('rankology_xml_sitemap_img_enable');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlEnable() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_enable');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlMapping() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_mapping');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlExclude() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_exclude');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlOrder() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_order');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlOrderBy() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_orderby');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlDate() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_date');
    }

    /**
     * 
     *
     * @return string|null
     */
    public function getHtmlArchiveLinks() {
        return $this->searchOptionByKey('rankology_xml_sitemap_html_archive_links');
    }
}
