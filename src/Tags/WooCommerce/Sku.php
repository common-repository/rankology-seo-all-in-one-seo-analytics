<?php

namespace Rankology\Tags\WooCommerce;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class Sku implements GetTagValue {
    const NAME = 'wc_sku';

    public static function getDescription() {
        return esc_html__('Product SKU', 'wp-rankology');
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

        if ((is_singular(['product']) || $context['is_product']) && isset($context['post']->ID)) {
            $product          = wc_get_product($context['post']->ID);
            $value            = $product->get_sku();
        }

        return apply_filters('rankology_get_tag_wc_sku_value', $value, $context);
    }
}
