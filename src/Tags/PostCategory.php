<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostCategory implements GetTagValue {
    const NAME = 'post_category';

    public static function getDescription() {
        return esc_html__('Post Category', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if ($context['is_single'] && $context['has_category'] && isset($context['post']->ID)) {
            $terms               = get_the_terms($context['post']->ID, 'category');
            $value               = $terms[0]->name;
            /**
             * @
             * Please use rankology_get_tag_post_category_value
             */
            $value               = apply_filters('rankology_titles_cat', $value);
        }

        return apply_filters('rankology_get_tag_post_category_value', $value, $context);
    }
}
