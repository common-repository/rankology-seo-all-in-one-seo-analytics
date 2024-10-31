<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class TitleOption {
    /**
     * 
     *
     * @return array
     */
    public function getOption() {
        return get_option(Options::KEY_OPTION_TITLE);
    }

    /**
     * 
     *
     * @param string $key
     *
     * @return mixed
     */
    public function searchOptionByKey($key) {
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
     * @param string $path
     *
     * @return string|null
     */
    public function getTitlesCptNoIndexByPath($path) {
        $data = $this->searchOptionByKey('rankology_titles_archive_titles');

        if ( ! isset($data[$path]['noindex'])) {
            return null;
        }

        return $data[$path]['noindex'];
    }

    /**
     * 
     *
     * @return string
     */
    public function getSeparator() {
        $separator = $this->searchOptionByKey('rankology_titles_sep');
        if ( ! $separator) {
            return '-';
        }

        return $separator;
    }

    /**
     * 
     *
     * @return string
     */
    public function getHomeSiteTitle() {
        return $this->searchOptionByKey('rankology_titles_home_site_title');
    }

    /**
     * 
     *
     * @return string
     */
    public function getHomeSiteTitleAlt() {
        return $this->searchOptionByKey('rankology_titles_home_site_title_alt');
    }

    /**
     * 
     *
     * @return string
     */
    public function getHomeDescriptionTitle() {
        return $this->searchOptionByKey('rankology_titles_home_site_desc');
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getSingleCptTitle($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');

        if ( ! isset($option[$currentCpt]['title'])) {
            return;
        }

        return $option[$currentCpt]['title'];
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getSingleCptDesc($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');

        if ( ! isset($option[$currentCpt]['description'])) {
            return;
        }

        return $option[$currentCpt]['description'];
    }

    /**
     * 
     *
     * @param int|null $id
     */
    public function getSingleCptNoIndex($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');

        if ( ! isset($option[$currentCpt]['noindex'])) {
            return;
        }

        return $option[$currentCpt]['noindex'];
    }

    /**
     * 
     *
     * @param int|null $id
     */
    public function getSingleCptNoFollow($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');
        if ( ! isset($option[$currentCpt]['nofollow'])) {
            return;
        }

        return $option[$currentCpt]['nofollow'];
    }

    /**
     * 
     *
     * @param int|null $id
     */
    public function getSingleCptDate($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');

        if ( ! isset($option[$currentCpt]['date'])) {
            return;
        }

        return $option[$currentCpt]['date'];
    }

    /**
     * 
     *
     * @param int|null $id
     */
    public function getSingleCptThumb($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');

        if ( ! isset($option[$currentCpt]['thumb_gcs'])) {
            return;
        }

        return $option[$currentCpt]['thumb_gcs'];
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getSingleCptEnable($currentCpt) {
        if (null === $currentCpt) {
            return;
        }

        $option =  $this->searchOptionByKey('rankology_titles_single_titles');

        if ( ! isset($option[$currentCpt]['enable'])) {
            return;
        }

        return $option[$currentCpt]['enable'];
    }

    /**
     * 
     */
    public function getTitleNoIndex() {
        return $this->searchOptionByKey('rankology_titles_noindex');
    }

    /**
     * 
     */
    public function getTitleNoFollow() {
        return $this->searchOptionByKey('rankology_titles_nofollow');
    }

    /**
     * 
     */
    public function getTitleNoArchive() {
        return $this->searchOptionByKey('rankology_titles_noarchive');
    }

    /**
     * 
     */
    public function getTitleNoSnippet() {
        return $this->searchOptionByKey('rankology_titles_nosnippet');
    }

    /**
     * 
     */
    public function getTitleNoImageIndex() {
        return $this->searchOptionByKey('rankology_titles_noimageindex');
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getArchivesCPTTitle($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_archive_titles');

        if ( ! isset($option[$currentCpt]['title'])) {
            return;
        }

        return $option[$currentCpt]['title'];
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getArchivesCPTDesc($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_archive_titles');

        if ( ! isset($option[$currentCpt]['description'])) {
            return;
        }

        return $option[$currentCpt]['description'];
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getArchivesCPTNoIndex($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_archive_titles');
        if ( ! isset($option[$currentCpt]['noindex'])) {
            return;
        }

        return $option[$currentCpt]['noindex'];
    }

        /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getArchivesCPTNoFollow($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_titles_archive_titles');
        if ( ! isset($option[$currentCpt]['nofollow'])) {
            return;
        }

        return $option[$currentCpt]['nofollow'];
    }

    /**
     * 
     */
    public function getArchivesAuthorTitle(){
        return $this->searchOptionByKey('rankology_titles_archives_author_title');
    }

    /**
     * 
     */
    public function getArchivesAuthorDescription(){
        return $this->searchOptionByKey('rankology_titles_archives_author_desc');
    }

    /**
     * 
     */
    public function getArchiveAuthorDisable(){
        return $this->searchOptionByKey('rankology_titles_archives_author_disable');
    }

    /**
     * 
     */
    public function getArchiveAuthorNoIndex(){
        return $this->searchOptionByKey('rankology_titles_archives_author_noindex');
    }

    /**
     * 
     */
    public function getArchiveDateDisable(){
        return $this->searchOptionByKey('rankology_titles_archives_date_disable');
    }

    /**
     * 
     */
    public function getTitleArchivesDate(){
        return $this->searchOptionByKey('rankology_titles_archives_date_title');
    }

    /**
     * 
     */
    public function getTitleArchivesSearch(){
        return $this->searchOptionByKey('rankology_titles_archives_search_title');
    }

    /**
     * 
     */
    public function getTitleArchives404(){
        return $this->searchOptionByKey('rankology_titles_archives_404_title');
    }

    /**
     * 
     *
     * @param int|null $currentTax
     */
    public function getTaxTitle() {
        $queried_object           = get_queried_object();
        $currentTax = null !== $queried_object ? $queried_object->taxonomy : '';

        $option =  $this->searchOptionByKey('rankology_titles_tax_titles');

        if ( ! isset($option[$currentTax]['title'])) {
            return;
        }

        return $option[$currentTax]['title'];
    }

    /**
     * 
     *
     * @param int|null $currentTax
     */
    public function getTaxDesc() {
        $queried_object           = get_queried_object();
        $currentTax = null !== $queried_object ? $queried_object->taxonomy : '';

        $option =  $this->searchOptionByKey('rankology_titles_tax_titles');

        if ( ! isset($option[$currentTax]['description'])) {
            return;
        }

        return $option[$currentTax]['description'];
    }

    /**
     * 
     *
     * @param int|null $id
     */
    public function getTaxNoIndex() {
        $queried_object = get_queried_object();
        $currentTax = null !== $queried_object ? $queried_object->taxonomy : '';

        if (null === $queried_object) {
            global $tax;
            $currentTax = $tax->name;
        }

        if (null !== $queried_object && 'yes' === get_term_meta($queried_object->term_id, '_rankology_robots_index', true)) {
            return get_term_meta($queried_object->term_id, '_rankology_robots_index', true);
        }

        $option =  $this->searchOptionByKey('rankology_titles_tax_titles');

        if ( ! isset($option[$currentTax]['noindex'])) {
            return;
        }

        return $option[$currentTax]['noindex'];
    }

    /**
     * 
     *
     * @param int|null $id
     */
    public function getTaxNoFollow() {
        $queried_object = get_queried_object();
        $currentTax = null !== $queried_object ? $queried_object->taxonomy : '';

        if (null === $queried_object) {
            global $tax;
            $currentTax = $tax->name;
        }

        if (null !== $queried_object && 'yes' === get_term_meta($queried_object->term_id, '_rankology_robots_follow', true)) {
            return get_term_meta($queried_object->term_id, '_rankology_robots_follow', true);
        }

        $option =  $this->searchOptionByKey('rankology_titles_tax_titles');

        if ( ! isset($option[$currentTax]['nofollow'])) {
            return;
        }

        return $option[$currentTax]['nofollow'];
    }

    /**
     * 
     *
     * @param int|null $currentTax
     */
    public function getTaxEnable($currentTax) {
        if (null === $currentTax) {
            return;
        }

        $option =  $this->searchOptionByKey('rankology_titles_tax_titles');

        if ( ! isset($option[$currentTax]['enable'])) {
            return;
        }

        return $option[$currentTax]['enable'];
    }

    /**
     * 
     */
    public function getPagedRel(){
        return $this->searchOptionByKey('rankology_titles_paged_rel');
    }

    /**
     * 
     */
    public function getTitleBpGroups(){
        return $this->searchOptionByKey('rankology_titles_bp_groups_title');
    }

    /**
     * 
     */
    public function getBpGroupsDesc(){
        return $this->searchOptionByKey('rankology_titles_bp_groups_desc');
    }

    /**
     * 
     */
    public function getBpGroupsNoIndex(){
        return $this->searchOptionByKey('rankology_titles_bp_groups_noindex');
    }

    /**
     * 
     */
    public function getArchivesDateDesc(){
        return $this->searchOptionByKey('rankology_titles_archives_date_desc');
    }

    /**
     * 
     */
    public function getArchivesDateNoIndex(){
        return $this->searchOptionByKey('rankology_titles_archives_date_noindex');
    }

    /**
     * 
     */
    public function getArchivesSearchDesc(){
        return $this->searchOptionByKey('rankology_titles_archives_search_desc');
    }

    /**
     * 
     */
    public function getArchivesSearchNoIndex(){
        return $this->searchOptionByKey('rankology_titles_archives_search_title_noindex');
    }

    /**
     * 
     */
    public function getArchives404Desc(){
        return $this->searchOptionByKey('rankology_titles_archives_404_desc');
    }

    /**
     * 
     */
    public function getNoSiteLinksSearchBox(){
        return $this->searchOptionByKey('rankology_titles_nositelinkssearchbox');
    }

    /**
     * 
     */
    public function getAttachmentsNoIndex(){
        return $this->searchOptionByKey('rankology_titles_attachments_noindex');
    }

    /**
     * 
     */
    public function getPagedNoIndex(){
        return $this->searchOptionByKey('rankology_titles_paged_noindex');
    }
}
