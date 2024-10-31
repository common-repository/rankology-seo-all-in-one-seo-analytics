<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class NoticeOption
{
    /**
     * 
     *
     * @return array
     */
    public function getOption()
    {
        return get_option(Options::KEY_OPTION_NOTICE);
    }

    /**
     * 
     *
     * @param string $key
     *
     * @return mixed
     */
    public function searchOptionByKey($key)
    {
        $data = $this->getOption();

        if (empty($data)) {
            return null;
        }

        if (! isset($data[$key])) {
            return null;
        }

        return $data[$key];
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeGetStarted(){
        return $this->searchOptionByKey('notice-get-started');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeTasks(){
        return $this->searchOptionByKey('notice-tasks');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeReview(){
        return $this->searchOptionByKey('notice-review');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeUSM(){
        return $this->searchOptionByKey('notice-usm');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeWizard(){
        return $this->searchOptionByKey('notice-wizard');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeInsightsWizard(){
        return $this->searchOptionByKey('notice-insights-wizard');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeAMPAnalytics(){
        return $this->searchOptionByKey('notice-amp-analytics');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeTitleTag(){
        return $this->searchOptionByKey('notice-title-tag');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeCacheSitemap(){
        return $this->searchOptionByKey('notice-cache-sitemap');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeSwift(){
        return $this->searchOptionByKey('notice-swift');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeEnfold(){
        return $this->searchOptionByKey('notice-enfold');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeSSL(){
        return $this->searchOptionByKey('notice-ssl');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeNoIndex(){
        return $this->searchOptionByKey('notice-noindex');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeRSSUseExcerpt(){
        return $this->searchOptionByKey('notice-rss-use-excerpt');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeGAIds(){
        return $this->searchOptionByKey('notice-ga-ids');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeDivideComments(){
        return $this->searchOptionByKey('notice-divide-comments');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticePostsNumber(){
        return $this->searchOptionByKey('notice-posts-number');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeGoogleBusiness(){
        return $this->searchOptionByKey('notice-google-business');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeSearchConsole(){
        return $this->searchOptionByKey('notice-search-console');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeGoPro(){
        return $this->searchOptionByKey('notice-go-pro');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeGoInsights(){
        return $this->searchOptionByKey('notice-go-insights');
    }

    /**
     * 
     *
     * @return string
     */
    public function getNoticeInsights(){
        return $this->searchOptionByKey('notice-insights');
    }
}
