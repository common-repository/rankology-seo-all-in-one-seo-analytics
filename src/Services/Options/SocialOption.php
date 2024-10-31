<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class SocialOption
{
    /**
     * 
     *
     * @return array
     */
    public function getOption() {
        return get_option(Options::KEY_OPTION_SOCIAL);
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
    public function getSocialKnowledgeType() {
        return $this->searchOptionByKey('rankology_social_knowledge_type');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialKnowledgeName() {
        return $this->searchOptionByKey('rankology_social_knowledge_name');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsFacebook() {
        return $this->searchOptionByKey('rankology_social_accounts_facebook');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsTwitter() {
        return $this->searchOptionByKey('rankology_social_accounts_twitter');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsPinterest() {
        return $this->searchOptionByKey('rankology_social_accounts_pinterest');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsInstagram() {
        return $this->searchOptionByKey('rankology_social_accounts_instagram');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsYoutube() {
        return $this->searchOptionByKey('rankology_social_accounts_youtube');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsLinkedin() {
        return $this->searchOptionByKey('rankology_social_accounts_linkedin');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialAccountsExtra() {
        return $this->searchOptionByKey('rankology_social_accounts_extra');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialKnowledgeImage() {
        return $this->searchOptionByKey('rankology_social_knowledge_img');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialKnowledgePhone() {
        return $this->searchOptionByKey('rankology_social_knowledge_phone');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialKnowledgeContactType() {
        return $this->searchOptionByKey('rankology_social_knowledge_contact_type');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialKnowledgeContactOption() {
        return $this->searchOptionByKey('rankology_social_knowledge_contact_option');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialTwitterCard() {
        return $this->searchOptionByKey('rankology_social_twitter_card');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialTwitterCardOg() {
        return $this->searchOptionByKey('rankology_social_twitter_card_og');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialTwitterImg() {
        return $this->searchOptionByKey('rankology_social_twitter_card_img');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialTwitterImgSize() {
        return $this->searchOptionByKey('rankology_social_twitter_card_img_size');
    }


    /**
     * 
     *
     * @return string
     */
    public function getSocialFacebookOGEnable() {
        return $this->searchOptionByKey('rankology_social_facebook_og');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialFacebookImgDefault() {
        return $this->searchOptionByKey('rankology_social_facebook_img_default');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialFacebookImg() {
        return $this->searchOptionByKey('rankology_social_facebook_img');
    }

    /**
     * 
     *
     * @param int|null $currentCpt
     */
    public function getSocialFacebookImgCpt($id = null) {
        $arg = $id;

        if (null === $id) {
            global $post;
            if ( ! isset($post)) {
                return;
            }

            $arg = $post;
        }

        $currentCpt = get_post_type($arg);

        $option =  $this->searchOptionByKey('rankology_social_facebook_img_cpt');

        if ( ! isset($option[$currentCpt]['url'])) {
            return;
        }

        return $option[$currentCpt]['url'];
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialFacebookLinkOwnership() {
        return $this->searchOptionByKey('rankology_social_facebook_link_ownership_id');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialFacebookAdminID() {
        return $this->searchOptionByKey('rankology_social_facebook_admin_id');
    }

    /**
     * 
     *
     * @return string
     */
    public function getSocialFacebookAppID() {
        return $this->searchOptionByKey('rankology_social_facebook_app_id');
    }
}
