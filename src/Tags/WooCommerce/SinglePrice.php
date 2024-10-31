<?php

namespace Rankology\Tags\WooCommerce;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class SinglePrice implements GetTagValue {
    const NAME = 'wc_single_price';

    public static function getDescription() {
        return esc_html__('Product Price With Taxes', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        if ( ! rankology_get_service('WooCommerceActivate')->isActive()) {
            return '';
        }

        $value = '';

        if ( ! $context) {
            return $value;
        }

        if (is_singular(['product']) || $context['is_product']) {
            $product          = wc_get_product($context['post']->ID);
            $value            = wc_get_price_including_tax($product);
        }

        return apply_filters('rankology_get_tag_wc_single_price_value', $value, $context);
    }
}
