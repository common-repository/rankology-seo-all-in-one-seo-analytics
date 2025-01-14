<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostThumbnailUrl implements GetTagValue {
    const NAME = 'post_thumbnail_url';

    public static function getDescription() {
        return esc_html__('Post Thumbnail URL', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if (isset($context['is_single'], $context['post']) && $context['is_single'] && ! empty($context['post'])) {
            $value = get_the_post_thumbnail_url($context['post'], 'full');
            /**
             * @
             * Please use rankology_get_tag_post_thumbnail_url_value
             */
            $value = apply_filters('rankology_titles_post_thumbnail_url', $value);
        }

        return apply_filters('rankology_get_tag_post_thumbnail_url_value', $value, $context);
    }
}
