<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class TagDescription implements GetTagValue {
    const NAME = 'tag_description';

    public static function getDescription() {
        return esc_html__('Tag Description', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value   = '';

        if (null !== $context['term_id']) {
            $value = get_term_field('name', $context['term_id']);
            if (is_wp_error($value)) {
                $value = '';
            }
        } else {
            $value   = tag_description();
        }

        $value   = wp_trim_words(
            stripslashes_deep(
                wp_filter_nohtml_kses($value)
            ), rankology_get_service('TagsToString')->getExcerptLengthForTags()
        );

        return apply_filters('rankology_get_tag_tag_description_value', $value, $context);
    }
}