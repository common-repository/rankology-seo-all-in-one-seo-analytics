<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class AdvancedOption
{
    /**
     * 
     *
     * @return array
     */
    public function getOption()
    {
        return get_option(Options::KEY_OPTION_ADVANCED);
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
    public function getAccessUniversalMetaboxGutenberg(){
        return $this->searchOptionByKey('rankology_advanced_appearance_universal_metabox');
    }

    /**
     * 
     *
     * @return string
     */
    public function getAppearanceNotification(){
        return $this->searchOptionByKey('rankology_advanced_appearance_notifications');
    }

    /**
     * 
     *
     * @return string
     */
    public function getDisableUniversalMetaboxGutenberg(){
        $data = $this->getOption();

        if(!isset($data['rankology_advanced_appearance_universal_metabox_disable'])){
            return true;
        }

        return $data['rankology_advanced_appearance_universal_metabox_disable'] === '1';
    }

    /**
     * 
     */
    public function getSecurityMetaboxRole(){
        return $this->searchOptionByKey('rankology_advanced_security_metaboxe_role');
    }

    /**
     * 
     */
    public function getSecurityMetaboxRoleContentAnalysis(){
        return $this->searchOptionByKey('rankology_advanced_security_metaboxe_ca_role');
    }

    /**
     * 
     */
    public function getAdvancedAttachments(){
        return $this->searchOptionByKey('rankology_advanced_advanced_attachments');
    }

    /**
     * 
     */
    public function getAdvancedAttachmentsFile(){
        return $this->searchOptionByKey('rankology_advanced_advanced_attachments_file');
    }

    /**
     * 
     */
    public function getAdvancedReplytocom(){
        return $this->searchOptionByKey('rankology_advanced_advanced_replytocom');
    }

    /**
     * 
     */
    public function getAdvancedNoReferrer(){
        return $this->searchOptionByKey('rankology_advanced_advanced_noreferrer');
    }

    /**
     * 
     */
    public function getAdvancedWPGenerator(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_generator');
    }

    /**
     * 
     */
    public function getAdvancedHentry(){
        return $this->searchOptionByKey('rankology_advanced_advanced_hentry');
    }

    /**
     * 
     */
    public function getAdvancedWPShortlink(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_shortlink');
    }

    /**
     * 
     */
    public function getAdvancedWPManifest(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_wlw');
    }

    /**
     * 
     */
    public function getAdvancedWPRSD(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_rsd');
    }

    /**
     * 
     */
    public function getAdvancedOEmbed(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_oembed');
    }

    /**
     * 
     */
    public function getAdvancedXPingback(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_x_pingback');
    }

    /**
     * 
     */
    public function getAdvancedXPoweredBy(){
        return $this->searchOptionByKey('rankology_advanced_advanced_wp_x_powered_by');
    }

    /**
     * 
     */
    public function getAdvancedGoogleVerification(){
        return $this->searchOptionByKey('rankology_advanced_advanced_google');
    }

    /**
     * 
     */
    public function getAdvancedBingVerification(){
        return $this->searchOptionByKey('rankology_advanced_advanced_bing');
    }

    /**
     * 
     */
    public function getAdvancedPinterestVerification(){
        return $this->searchOptionByKey('rankology_advanced_advanced_pinterest');
    }

    /**
     * 
     */
    public function getAdvancedYandexVerification(){
        return $this->searchOptionByKey('rankology_advanced_advanced_yandex');
    }

    /**
     * 
     */
    public function getAdvancedTaxDescEditor(){
        return $this->searchOptionByKey('rankology_advanced_advanced_tax_desc_editor');
    }

    /**
     * 
     */
    public function getImageAutoTitleEditor(){
        return $this->searchOptionByKey('rankology_advanced_advanced_image_auto_title_editor');
    }

    /**
     * 
     */
    public function getImageAutoAltEditor(){
        return $this->searchOptionByKey('rankology_advanced_advanced_image_auto_alt_editor');
    }

    /**
     * 
     */
    public function getImageAutoCaptionEditor(){
        return $this->searchOptionByKey('rankology_advanced_advanced_image_auto_caption_editor');
    }

    /**
     * 
     */
    public function getImageAutoDescriptionEditor(){
        return $this->searchOptionByKey('rankology_advanced_advanced_image_auto_desc_editor');
    }

    /**
     * 
     */
    public function getAppearanceMetaboxePosition(){
        return $this->searchOptionByKey('rankology_advanced_appearance_metaboxe_position');
    }

    /**
     * 
     */
    public function getAppearanceTitleCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_title_col');
    }

    /**
     * 
     */
    public function getAppearanceMetaDescriptionCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_meta_desc_col');
    }

    /**
     * 
     */
    public function getAppearanceRedirectUrlCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_redirect_url_col');
    }

    /**
     * 
     */
    public function getAppearanceRedirectEnableCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_redirect_enable_col');
    }

    /**
     * 
     */
    public function getAppearanceCanonical(){
        return $this->searchOptionByKey('rankology_advanced_appearance_canonical');
    }

    /**
     * 
     */
    public function getAppearanceTargetKwCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_target_kw_col');
    }

    /**
     * 
     */
    public function getAppearanceNoIndexCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_noindex_col');
    }

    /**
     * 
     */
    public function getAppearanceNoFollowCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_nofollow_col');
    }

    /**
     * 
     */
    public function getAppearanceWordsCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_words_col');
    }

    /**
     * 
     */
    public function getAppearancePsCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_ps_col');
    }

    /**
     * 
     */
    public function getAppearanceScoreCol(){
        return $this->searchOptionByKey('rankology_advanced_appearance_score_col');
    }

    /**
     * 
     */
    public function getAppearanceCaMetaboxe(){
        return $this->searchOptionByKey('rankology_advanced_appearance_ca_metaboxe');
    }

    /**
     * 
     */
    public function getAppearanceGenesisSeoMetaboxe(){
        return $this->searchOptionByKey('rankology_advanced_appearance_genesis_seo_metaboxe');
    }

    /**
     * 
     */
    public function getAppearanceGenesisSeoMenu(){
        return $this->searchOptionByKey('rankology_advanced_appearance_genesis_seo_menu');
    }

    /**
     * 
     */
    public function getAppearanceAdminBar(){
        return $this->searchOptionByKey('rankology_advanced_appearance_adminbar');
    }

    /**
     * 
     */
    public function getAppearanceHideSiteOverview(){
        return $this->searchOptionByKey('rankology_advanced_appearance_seo_tools');
    }

    /**
     * 
     */
    public function getAppearanceSearchConsole(){
        return $this->searchOptionByKey('rankology_advanced_appearance_search_console');
    }

    /**
     * 
     */
    public function getAppearanceAdminBarNoIndex(){
        return $this->searchOptionByKey('rankology_advanced_appearance_adminbar_noindex');
    }

    /**
     * 
     */
    public function getAppearanceNews(){
        return $this->searchOptionByKey('rankology_advanced_appearance_news');
    }

    /**
     * 
     */
    public function getAdvancedCleaningFileName(){
        return $this->searchOptionByKey('rankology_advanced_advanced_clean_filename');
    }

    /**
     * 
     */
    public function getAdvancedRemoveCategoryURL(){
        return $this->searchOptionByKey('rankology_advanced_advanced_category_url');
    }

    /**
     * 
     */
    public function getAdvancedRemoveProductCategoryURL(){
        return $this->searchOptionByKey('rankology_advanced_advanced_product_cat_url');
    }

    /**
     * 
     */
    public function getAdvancedImageAutoAltTargetKw(){
        return $this->searchOptionByKey('rankology_advanced_advanced_image_auto_alt_target_kw');
    }

    /**
     * 
     */
    public function getSecurityGaWidgetRole(){
        return $this->searchOptionByKey('rankology_advanced_security_ga_widget_role');
    }

    /**
     * 
     */
    public function getAdvancedCommentsAuthorURLDisable(){
        return $this->searchOptionByKey('rankology_advanced_advanced_comments_author_url');
    }

    /**
     * 
     */
    public function getAdvancedCommentsWebsiteDisable(){
        return $this->searchOptionByKey('rankology_advanced_advanced_comments_website');
    }

    /**
     * 
     */
    public function getAdvancedCommentsFormLinkDisable(){
        return $this->searchOptionByKey('rankology_advanced_advanced_comments_form_link');
    }
}
