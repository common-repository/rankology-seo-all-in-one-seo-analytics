<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PostTag implements GetTagValue {
    const NAME = 'post_tag';

    public static function getDescription() {
        return esc_html__('Post Tag', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if ($context['is_single'] && $context['has_tag'] && isset($context['post']->ID)) {
            $terms          = get_the_terms($context['post']->ID, 'post_tag');
            $value          = $terms[0]->name;
            /**
             * @
             * Please use rankology_get_tag_post_tag_value
             */
            $value               = apply_filters('rankology_titles_tag', $value);
        }

        return apply_filters('rankology_get_tag_post_tag_value', $value, $context);
    }
}
