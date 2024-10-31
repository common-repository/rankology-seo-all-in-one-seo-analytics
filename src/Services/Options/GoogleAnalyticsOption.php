<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class GoogleAnalyticsOption
{
    /**
     * 
     *
     * @return array
     */
    public function getOption() {
        return get_option(Options::KEY_OPTION_GOOGLE_ANALYTICS);
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
     * @return string
     */
    public function getHook() {
        return $this->searchOptionByKey('rankology_google_analytics_hook');
    }

    /**
     * 
     *
     * @return string
     */
    public function getOptOutMessageOk() {
        return $this->searchOptionByKey('rankology_google_analytics_opt_out_msg_ok');
    }

    /**
     * 
     *
     * @return string
     */
    public function getOptOutMessageClose() {
        return $this->searchOptionByKey('rankology_google_analytics_opt_out_msg_close');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBg() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_bg');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbTxtCol() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_txt_col');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbLkCol() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_lk_col');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnBg() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_bg');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnBgHov() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_bg_hov');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnCol() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_col');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnColHov() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_col_hov');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnSecBg() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_sec_bg');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnSecCol() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_sec_col');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnSecBgHov() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_sec_bg_hov');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBtnSecColHov() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_btn_sec_col_hov');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbPos() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_pos');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbWidth() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_width');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBackdrop() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_backdrop');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbBackdropBg() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_backdrop_bg');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbTxtAlign() {
        return $this->searchOptionByKey('rankology_google_analytics_cb_txt_align');
    }

    /**
     * 
     *
     * @return string
     */
    public function getOptOutEditChoice() {
        return $this->searchOptionByKey('rankology_google_analytics_opt_out_edit_choice');
    }

    /**
     * 
     *
     * @return string
     */
    public function getOptOutMessageEdit() {
        return $this->searchOptionByKey('rankology_google_analytics_opt_out_msg_edit');
    }

    /**
     * 
     *
     * @return string
     */
    public function getOptimize() {
        return $this->searchOptionByKey('rankology_google_analytics_optimize');
    }

    /**
     * Ads
     * 
     *
     * @return string
     */
    public function getAds() {
        return $this->searchOptionByKey('rankology_google_analytics_ads');
    }

    /**
     * Additional tracking code - head
     * 
     *
     * @return string
     */
    public function getOtherTracking() {
        return $this->searchOptionByKey('rankology_google_analytics_other_tracking');
    }

    /**
     * Additional tracking code - body
     * 
     *
     * @return string
     */
    public function getOtherTrackingBody() {
        return $this->searchOptionByKey('rankology_google_analytics_other_tracking_body');
    }

    /**
     * Additional tracking code - footer
     * 
     *
     * @return string
     */
    public function getOtherTrackingFooter() {
        return $this->searchOptionByKey('rankology_google_analytics_other_tracking_footer');
    }

    /**
     * Remarketing
     * 
     *
     * @return string
     */
    public function getRemarketing() {
        return $this->searchOptionByKey('rankology_google_analytics_remarketing');
    }

    /**
     * IP Anonymization
     * 
     *
     * @return string
     */
    public function getIpAnonymization() {
        return $this->searchOptionByKey('rankology_google_analytics_ip_anonymization');
    }

    /**
     * Link attribution
     * 
     *
     * @return string
     */
    public function getLinkAttribution() {
        return $this->searchOptionByKey('rankology_google_analytics_link_attribution');
    }

    /**
     * Cross Domain Enable
     * 
     *
     * @return string
     */
    public function getCrossEnable() {
        return $this->searchOptionByKey('rankology_google_analytics_cross_enable');
    }

    /**
     * Cross Domain
     * 
     *
     * @return string
     */
    public function getCrossDomain() {
        return $this->searchOptionByKey('rankology_google_analytics_cross_domain');
    }

    /**
     * Events external links tracking Enable
     * 
     *
     * @return string
     */
    public function getLinkTrackingEnable() {
        return $this->searchOptionByKey('rankology_google_analytics_link_tracking_enable');
    }

    /**
     * Events downloads tracking Enable
     * 
     *
     * @return string
     */
    public function getDownloadTrackingEnable() {
        return $this->searchOptionByKey('rankology_google_analytics_download_tracking_enable');
    }

    /**
     * Events tracking file types
     * 
     *
     * @return string
     */
    public function getDownloadTracking() {
        return $this->searchOptionByKey('rankology_google_analytics_download_tracking');
    }

    /**
     * Events affiliate links tracking Enable
     * 
     *
     * @return string
     */
    public function getAffiliateTrackingEnable() {
        return $this->searchOptionByKey('rankology_google_analytics_affiliate_tracking_enable');
    }

    /**
     * Events tracking affiliate match
     * 
     *
     * @return string
     */
    public function getAffiliateTracking() {
        return $this->searchOptionByKey('rankology_google_analytics_affiliate_tracking');
    }

    /**
     * Events phone tracking
     * 
     *
     * @return string
     */
    public function getPhoneTracking() {
        return $this->searchOptionByKey('rankology_google_analytics_phone_tracking');
    }

    /**
     * Custom Dimension Author
     * 
     *
     * @return string
     */
    public function getCdAuthor() {
        return $this->searchOptionByKey('rankology_google_analytics_cd_author');
    }

    /**
     * Custom Dimension Category
     * 
     *
     * @return string
     */
    public function getCdCategory() {
        return $this->searchOptionByKey('rankology_google_analytics_cd_category');
    }

    /**
     * Custom Dimension Tag
     * 
     *
     * @return string
     */
    public function getCdTag() {
        return $this->searchOptionByKey('rankology_google_analytics_cd_tag');
    }

    /**
     * Custom Dimension Post Type
     * 
     *
     * @return string
     */
    public function getCdPostType() {
        return $this->searchOptionByKey('rankology_google_analytics_cd_post_type');
    }

    /**
     * Custom Dimension Logged In
     * 
     *
     * @return string
     */
    public function getCdLoggedInUser() {
        return $this->searchOptionByKey('rankology_google_analytics_cd_logged_in_user');
    }

    /**
     * Get option for "Measure purchases"
     * 
     *
     * @return string
     */
    public function getPurchases() {
        return $this->searchOptionByKey('rankology_google_analytics_purchases');
    }

    /**
     * Get option for "Add to cart event"
     * 
     *
     * @return string
     */
    public function getAddToCart() {
        return $this->searchOptionByKey('rankology_google_analytics_add_to_cart');
    }

    /**

     * Get option for "Remove from cart event"
     * 
     *
     * @return string
     */
    public function getRemoveFromCart() {
        return $this->searchOptionByKey('rankology_google_analytics_remove_from_cart');
    }

    /**
     * 
     *
     * @return string
     */
    public function getEnableOption(){
        return $this->searchOptionByKey('rankology_google_analytics_enable');
    }

    /**
     * 
     *
     * @return string
     */
    public function getGA4(){
        return $this->searchOptionByKey('rankology_google_analytics_ga4');
    }

    /**
     * 
     *
     * @return string
     */
    public function getGA4PropertId(){
        return $this->searchOptionByKey('rankology_google_analytics_ga4_property_id');
    }

    /**
     * 
     *
     * @return string
     */
    public function getRoles(){
        return $this->searchOptionByKey('rankology_google_analytics_roles');
    }

    /**
     * 
     *
     * @return string
     */
    public function getDisable(){
        return $this->searchOptionByKey('rankology_google_analytics_disable');
    }

    /**
     * 
     *
     * @return string
     */
    public function getHalfDisable(){
        return $this->searchOptionByKey('rankology_google_analytics_half_disable');
    }

    /**
     * 
     *
     * @return string
     */
    public function getOptOutMsg(){
        return $this->searchOptionByKey('rankology_google_analytics_opt_out_msg');
    }

    /**
     * 
     *
     * @return string
     */
    public function getCbExpDate(){
        return $this->searchOptionByKey('rankology_google_analytics_cb_exp_date');
    }

    /**
     * 
     *
     * @return string
     */
    public function getRemoveToCart() {
        return $this->searchOptionByKey('rankology_google_analytics_remove_from_cart');
    }

    /**
     * 
     *
     * @return string
     */
    public function getAuth() {
        return $this->searchOptionByKey('rankology_google_analytics_auth');
    }

    /**
     * 
     *
     * @return string
     */
    public function getAuthClientId() {
        return $this->searchOptionByKey('rankology_google_analytics_auth_client_id');
    }

    /**
     * 
     *
     * @return string
     */
    public function getAuthSecretId() {
        return $this->searchOptionByKey('rankology_google_analytics_auth_secret_id');
    }

}
