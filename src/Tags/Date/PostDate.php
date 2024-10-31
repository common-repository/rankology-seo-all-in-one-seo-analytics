<?php

namespace Rankology\Tags\Date;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostDate implements GetTagValue {
    const NAME = 'post_date';

    const ALIAS = ['date'];

    public static function getDescription() {
        return esc_html__('Post Date', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if (isset($context['post'])) {
            $value = get_the_date(get_option('date_format'), $context['post']->ID);
        }

        return apply_filters('rankology_get_tag_post_date_value', $value, $context);
    }
}
