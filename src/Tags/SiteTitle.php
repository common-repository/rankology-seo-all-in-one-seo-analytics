<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SiteTitle implements GetTagValue {
    const NAME = 'sitetitle';

    const ALIAS = ['sitename'];

    /**
     * 4.8.0.
     *
     * @return string
     */
    public static function getDescription() {
        return esc_html__('Site Title', 'wp-rankology');
    }

    public function getValue($args = null) {
        return get_bloginfo('name');
    }
}
