<?php

namespace Rankology\Tags\WooCommerce;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\GetTagValue;

class PriceValidDate implements GetTagValue {
    const NAME = 'wc_price_valid_date';

    public static function getDescription() {
        return esc_html__('Product Date On Sale To', 'wp-rankology');
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
            $product    = wc_get_product($context['post']->ID);
            $date       = $product->get_date_on_sale_to();
            if ($date) {
                $value      = $date->date('m-d-Y');
            }
        }

        return apply_filters('rankology_get_tag_wc_price_valid_date', $value, $context);
    }
}
