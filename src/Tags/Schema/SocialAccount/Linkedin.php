<?php

namespace Rankology\Tags\Schema\SocialAccount;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Linkedin implements GetTagValue {
    const NAME = 'social_account_linkedin';

    public static function getDescription() {
        return esc_html__('LinkedIn URL', 'wp-rankology');
    }

    /**
     * 
     *
     * @param array $args
     *
     * @return string
     */
    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = rankology_get_service('SocialOption')->getSocialAccountsLinkedin();

        return apply_filters('rankology_get_tag_schema_social_account_linkedin', $value, $context);
    }
}
