<?php

namespace Rankology\Tags\WooCommerce;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SingleCategory implements GetTagValue {
    const NAME = 'wc_single_cat';

    public static function getDescription() {
        return esc_html__('Product Category', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;

        $value = '';

        if ( ! rankology_get_service('WooCommerceActivate')->isActive()) {
            return $value;
        }

        if ( ! $context) {
            return $value;
        }

        if (is_singular(['product']) || $context['is_product']) {
            $terms = get_the_terms($context['post']->ID, 'product_cat');

            if ($terms && ! is_wp_error($terms)) {
                $wooSingleCat = [];
                foreach ($terms as $term) {
                    $wooSingleCat[$term->term_id] = $term->name;
                }

                /**
                 * @
                 * Please use rankology_get_tag_wc_single_cat_value
                 */
                $wooSingleCat = apply_filters('rankology_titles_product_cat', $wooSingleCat);

                $value = stripslashes_deep(wp_filter_nohtml_kses(join(', ', $wooSingleCat)));
            }
        }

        return apply_filters('rankology_get_tag_wc_single_cat_value', $value, $context);
    }
}
