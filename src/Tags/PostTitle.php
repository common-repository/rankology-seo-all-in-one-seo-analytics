<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostTitle implements GetTagValue {
    const NAME = 'post_title';

    const ALIAS = ['title'];

    public static function getDescription() {
        return esc_html__('Post Title', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if (
            (isset($context['is_home']) || isset($context['is_single']))
            && isset($context['post']) && $context['post']) {
            $value = get_post_field('post_title', $context['post']->ID);
            $value = str_replace('<br>', ' ', $value);
            $value = esc_attr(strip_tags($value));
        }

        return apply_filters('rankology_get_tag_post_title_value', $value, $context);
    }
}
