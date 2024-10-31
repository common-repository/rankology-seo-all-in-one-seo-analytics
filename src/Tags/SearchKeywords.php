<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SearchKeywords implements GetTagValue {
    const NAME = 'search_keywords';

    public static function getDescription() {
        return esc_html__('Search Keywords', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = get_search_query();

        if ( ! empty($value)) {
            $value = esc_attr('"' . $value . '"');
        } else {
            $value = esc_attr('" "');
        }

        /**
         * @
         * Please use rankology_get_tag_search_keywords_value
         */
        $value = apply_filters('rankology_get_search_query', $value);

        return apply_filters('rankology_get_tag_search_keywords_value', $value, $context);
    }
}
