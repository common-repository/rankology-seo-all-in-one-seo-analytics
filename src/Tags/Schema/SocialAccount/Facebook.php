<?php

namespace Rankology\Tags\Schema\SocialAccount;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Facebook implements GetTagValue {
    const NAME = 'social_account_facebook';

    public static function getDescription() {
        return esc_html__('Facebook URL', 'wp-rankology');
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

        $value   = rankology_get_service('SocialOption')->getSocialAccountsFacebook();

        return apply_filters('rankology_get_tag_schema_social_account_facebook', $value, $context);
    }
}
