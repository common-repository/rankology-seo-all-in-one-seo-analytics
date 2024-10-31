<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostUrl implements GetTagValue {
    const NAME = 'post_url';

    public static function getDescription() {
        return esc_html__('Post URL', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';
        if ( ! $context) {
            return $value;
        }

        if ($context['is_single'] && ! empty($context['post'])) {
            $value = esc_url(get_permalink($context['post']));
            /**
             * @
             * Please use rankology_get_tag_post_url_value
             */
            $value = apply_filters('rankology_titles_post_url', $value);
        }

        return apply_filters('rankology_get_tag_post_url_value', $value, $context);
    }
}
