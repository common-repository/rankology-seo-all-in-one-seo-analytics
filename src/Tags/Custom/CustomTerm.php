<?php

namespace Rankology\Tags\Custom;

if ( ! defined('ABSPATH')) {
    exit;
}

use Rankology\Models\AbstractCustomTagValue;
use Rankology\Models\GetTagValue;

class CustomTerm extends AbstractCustomTagValue implements GetTagValue {
    const CUSTOM_FORMAT = '_ct_';
    const NAME          = '_ct_your_custom_taxonomy_slug';

    public static function getDescription() {
        return esc_html__('Custom Term', 'wp-rankology');
    }

    public function getValue($args = null) {
        $context = isset($args[0]) ? $args[0] : null;
        $tag     = isset($args[1]) ? $args[1] : null;
        $value   = '';
        if (null === $tag || ! $context) {
            return $value;
        }

        if ( ! $context['post']) {
            return $value;
        }

        $regex = $this->buildRegex(self::CUSTOM_FORMAT);

        preg_match($regex, $tag, $matches);

        if (empty($matches) || ! array_key_exists('field', $matches)) {
            return $value;
        }

        $field = $matches['field'];

        $terms = wp_get_post_terms($context['post']->ID, $field);
        if (is_wp_error($terms)) {
            return $value;
        }
        $value   = esc_attr($terms[0]->name);
        /**
         * @
         * Use rankology_get_tag' . $tag . '_value
         */
        $value  = apply_filters('rankology_titles_custom_tax', $value, $field);

        return apply_filters('rankology_get_tag' . $tag . '_value', $value, $context);
    }
}
