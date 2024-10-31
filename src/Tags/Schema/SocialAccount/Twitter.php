<?php

namespace Rankology\Tags\Schema\SocialAccount;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Twitter implements GetTagValue {
    const NAME = 'social_account_twitter';

    public static function getDescription() {
        return esc_html__('Twitter URL', 'wp-rankology');
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

        $value   = rankology_get_service('SocialOption')->getSocialAccountsTwitter();
        if ( ! empty($value)) {
            $value = sprintf('https://twitter.com/%s', $value);
        }

        return apply_filters('rankology_get_tag_schema_social_account_twitter', $value, $context);
    }
}
