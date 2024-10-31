<?php

namespace Rankology\Tags;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Page implements GetTagValue {
    const NAME = 'page';

    public static function getDescription() {
        return esc_html__('Page number with context', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        global $wp_query;

        $value = '';

        if ( ! $context) {
            return $value;
        }

        if (isset($wp_query->max_num_pages)) {
            if ($context['paged'] > 1) {
                $currentPage = get_query_var('paged');
            } else {
                $currentPage = 1;
            }

            $value = sprintf(esc_html__('Page %d of %2$d', 'wp-rankology'), $currentPage, $wp_query->max_num_pages);
            /**
             * @
             * Please use rankology_context_paged
             */
            $value = apply_filters('rankology_context_paged', $value);
        }

        return apply_filters('rankology_get_tag_page_value', $value, $context);
    }
}
