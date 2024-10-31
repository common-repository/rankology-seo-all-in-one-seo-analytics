<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class CurrentPagination implements GetTagValue {
    const NAME = 'current_pagination';

    public static function getDescription() {
        return esc_html__('Current Number Page', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $value   = '';

        if ( ! $context) {
            return $value;
        }

        if ($context['paged'] > '1') {
            $value = $context['paged'];
        }

        /**
         * @
         * Please use rankology_get_tag_current_pagination_value
         */
        $value = apply_filters('rankology_paged', $value);

        return apply_filters('rankology_get_tag_current_pagination_value', $value, $context);
    }
}
