<?php

namespace Rankology\Tags\Schema\SocialAccount;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Instagram implements GetTagValue {
    const NAME = 'social_account_instagram';

    public static function getDescription() {
        return esc_html__('Instagram URL', 'wp-rankology');
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

        $value   = rankology_get_service('SocialOption')->getSocialAccountsInstagram();

        return apply_filters('rankology_get_tag_schema_social_account_instagram', $value, $context);
    }
}
